<?php


namespace App\UseCases\Analysis\StageTrend;

use App\Models\ProspectActionLog;
use App\Models\Prospect;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Null_;

class StageTrendPropertyRoomListAction
{
    public function __invoke($request): array
    {
        //デフォルト画面でログインユーザーの事業所を表示するために
        if (empty($request->input('office_master_id'))) {
            $request = $request->merge([
                'office_master_id' => Auth::user()->office_master_id
            ]);
        }

        //デフォルトで当月初
        if (empty($request->input('start_period'))) {
            $request = $request->merge([
                'start_period' => Carbon::now()->startOfMonth()
            ]);
        } else {
            $month = $request->input('start_period');
            $request = $request->merge(['start_period' => Carbon::parse("${month}-01 00:00:00")]);
        }

        //デフォルトで当月末
        if (empty($request->input('end_period'))) {
            $request = $request->merge([
                'end_period' => Carbon::now()->endOfMonth()
            ]);
        } else {
            $month = $request->input('end_period');
            $request = $request->merge(['end_period' => Carbon::parse("${month}-01 00:00:00")->endOfMonth()]);
        }

        //事業所の社員IDを取得
        $teams = $this->searchTeam($request);

        //期間のProspect
        $PeriodProspect = $this->PeriodProspect($request);
        $startMonthProspect = $this->generateStartMonthProspect($request);
        $endMonthProspect = $this->generateEndMonthProspect($request);
        $newCountProspect = $this->generateNewCountProspect($request);

        //該当事業所の社員毎のステージ推移
        foreach ($teams->sortBy('area_master_id') as $team) {
            unset($discrimination, $latent, $overt);
            //UserIdで特定
            $prospects = $this->ThisUserProspect($PeriodProspect, $team);
            $startMonthAreaProspect = $this->ThisUserProspect($startMonthProspect, $team);
            $endMonthAreaProspect = $this->ThisUserProspect($endMonthProspect, $team);
            $newCountAreaProspect = $this->ThisUserProspect($newCountProspect, $team);

            $user = [
                'id' => $team->id,
                'user_name' => $team->sale->sei,
                'pair_name' => $team->hat->sei ?? '',
                'office' => $team->sale->userAffiliation->name,
                'area' => $team->area->action_name
            ];

            //判別
            $discrimination = [
                'StartCount' => $this->StartMonthStageCount($startMonthAreaProspect, 1),
                'MediationCount' => $this->StageUpCount($prospects, 1, 'mediation', $request),
                'StageUpCount' => $this->StageUpCount($prospects, 1, 'discrimination', $request),
                'StageDiscriminationDownCount' => $this->FromTheUpperStage($prospects, 1, 'discrimination', $request),
                'DemotedCount' => $this->StageUpCount($prospects, 1, 'demoted', $request),
                'NewCount' => $this->NewCount($newCountAreaProspect,1),
                'EndCount' => $this->endMonthStageCount($endMonthAreaProspect, 1)
            ];

            //潜在
            $latent = [
                'StartCount' => $this->StartMonthStageCount($startMonthAreaProspect, 2),
                'MediationCount' => $this->StageUpCount($prospects, 2, 'mediation', $request),
                'OvertFromLatentCount' => $this->StageUpCount($prospects, 2, 'latent', $request),
                'StageLatentDownCount' => $this->FromTheUpperStage($prospects, 2, 'latentFromDiscrimination', $request),
                'FromOvert' => $this->FromTheUpperStage($prospects, 2, 'latent', $request),
                'DemotedCount' => $this->StageUpCount($prospects, 2, 'demotedFromLatent', $request),
                'NewCount' => $this->NewCount($newCountAreaProspect,2),
                'EndCount' => $this->endMonthStageCount($endMonthAreaProspect, 2),
            ];

            //顕在
            $overt = [
                'StartCount' => $this->StartMonthStageCount($startMonthAreaProspect, 3),
                'MediationCount' => $this->StageUpCount($prospects, 3, 'mediation', $request),
                'FromBottomCount' => $this->FromTheUpperStage($prospects, 3, 'overtFromLowerStage', $request),
                'DemotedCount' => $this->StageUpCount($prospects, 3, 'demotedFromOvert', $request),
                'NewCount' => $this->NewCount($newCountAreaProspect, 3),
                'EndCount' => $this->endMonthStageCount($endMonthAreaProspect, 3),

            ];
            $analysisData[$user['id']] = array_merge(['discrimination' => $discrimination, 'latent' => $latent, 'overt' => $overt]);
        }
        return $analysisData;
    }

    //該当事業所の社員のIDを取得
    protected function searchTeam($request): \Illuminate\Support\Collection
    {
        return Team::where('office_master_id', $request->input('office_master_id'))->get();
    }

    //期間のProspectを取得
    protected function PeriodProspect($request): \Illuminate\Database\Eloquent\Collection|array
    {
        return Prospect::with(['prospectActionLogs' => function($query) use ($request){
            $query->where('date' , '<',Carbon::create($request->input('end_period')->format('Y-m-d')));
        }])
            ->where('office_master_id', $request->office_master_id)
            ->where('date', '<=',Carbon::create($request->input('start_period')->format('Y-m-d'))->subMonthNoOverflow()->lastOfMonth())
            ->get();
    }
    protected function generateStartMonthProspect($request): \Illuminate\Database\Eloquent\Collection|array
    {
        return
            Prospect::with(['prospectActionLogs' => function($query) use ($request){
                $query->where('date' , '<', Carbon::create($request->input('start_period')->format('Y-m-d')));
            }])
                ->where('office_master_id', $request->office_master_id)
                ->where('date', '<',Carbon::create($request->input('start_period')->format('Y-m-d')))
                ->get();
    }

    protected function generateEndMonthProspect($request): \Illuminate\Database\Eloquent\Collection|array
    {
        return
            Prospect::with(['prospectActionLogs' => function($query) use ($request){
                $query->where('date' , '<=', Carbon::create($request->input('end_period')->format('Y-m-d')));
            }])
                ->where('office_master_id', $request->office_master_id)
                ->where('date', '<=',Carbon::create($request->input('end_period')->format('Y-m-d')))
                ->get();
    }

    protected function generateNewCountProspect($request): \Illuminate\Database\Eloquent\Collection|array
    {
        return
            Prospect::with(['prospectActionLogs' => function($query) use ($request){
                $query->whereBetween('date' , [Carbon::create($request->input('start_period')->format('Y-m-d')), Carbon::create($request->input('end_period')->format('Y-m-d'))]);
            }])
                ->whereBetween('date' , [Carbon::create($request->input('start_period')->format('Y-m-d')), Carbon::create($request->input('end_period')->format('Y-m-d'))])
                ->where('office_master_id', $request->office_master_id)
                ->get();
    }

    //該当ユーザーのProspectを取得
    protected function ThisUserProspect($prospect, $team)
    {
        return $prospect->where('area_master_id', $team->area_master_id);
    }

    //月初のカウント
    protected function StartMonthStageCount($prospects, $target_stage_id): ?array
    {
        //早期リターン
        if ($prospects->isEmpty()) return NULL;

        $roomList = [];
        foreach ($prospects as $prospect) {
            $prospectActionLog = $prospect->prospectActionLogs
                ->sortBy('date')
                ->last();
            if ($prospectActionLog?->stage_action_master_id === $target_stage_id) {
                $roomList[] = [
                    'id' => $prospectActionLog->prospect_id,
                ];
            }
        }
        return $roomList;
    }

    //月末のカウント
    protected function endMonthStageCount($prospects, $target_stage_id): ?array
    {
        if ($prospects->isEmpty())return NULL;
        $roomList = [];
        foreach ($prospects as $prospect){
            $prospectActionLog = $prospect->prospectActionLogs
                ->sortBy('date')
                ->last();
            if ($prospectActionLog?->stage_action_master_id === $target_stage_id){
                $roomList[] = [
                    'id' => $prospectActionLog->prospect_id,
                ];
            }
        }
        return $roomList;
    }

    //ステージアップした見込みを絞り込み
    protected function StageUpCount($prospects, $first_stage_id, $stage, $request)
    {
        $roomList = [];
        foreach ($prospects as $prospect) {
            if ($prospect->prospectActionLogs->count() === 1){
                continue;
            }
            $firstProspectActionLog = $prospect->prospectActionLogs
                ->where('date' , '<', Carbon::create($request->input('start_period')->format('Y-m-d'))->subMonthNoOverflow()->lastOfMonth())
                ->sortBy('date')
                ->last();
            $lastProspectActionLog = $prospect->prospectActionLogs
                ->sortBy('date')
                ->last();
            if($firstProspectActionLog?->stage_action_master_id === $first_stage_id){
                $roomList[] = $this->stageUpJudgment($lastProspectActionLog, $stage);
            }
        }

        return $roomList;
    }

    protected function stageUpJudgment($lastProspectActionLog, $stage)
    {
        if ($lastProspectActionLog?->stage_action_master_id === NULL){
            return NULL;
        }
        switch ($stage){
            case 'discrimination':
                if (1 < $lastProspectActionLog->stage_action_master_id && $lastProspectActionLog->stage_action_master_id < 4 ){
                    return [
                        'id' => $lastProspectActionLog->prospect_id,
                    ];
                }else{
                    return NULL;
                }
            case 'latent':
                if (2 < $lastProspectActionLog->stage_action_master_id && $lastProspectActionLog->stage_action_master_id < 4 ){
                    return [
                        'id' => $lastProspectActionLog->prospect_id,
                    ];
                }else{
                    return NULL;
                }
//            case 'overt':
//                if ($lastProspectActionLog->stage_action_master_id && $lastProspectActionLog->stage_action_master_id < 4 ){
//                    return [
//                        'id' => $lastProspectActionLog->prospect_id,
//                    ];
//                }else{
//                    return NULL;
//                }
            case 'mediation':
                if ($lastProspectActionLog->stage_action_master_id === 4){
                    return [
                        'id' => $lastProspectActionLog->prospect_id,
                    ];
                }else{
                    return NULL;
                }
            case 'demoted':
                if ($lastProspectActionLog->stage_action_master_id === 103){
                    return [
                        'id' => $lastProspectActionLog->prospect_id,
                    ];
                }else{
                    return NULL;
                }
            case 'demotedFromLatent':
                if ($lastProspectActionLog->stage_action_master_id === 103 || $lastProspectActionLog->stage_action_master_id === 1){
                    return [
                        'id' => $lastProspectActionLog->prospect_id,
                    ];
                }else{
                    return NULL;
                }
            case 'demotedFromOvert':
                if ($lastProspectActionLog->stage_action_master_id === 103 || $lastProspectActionLog->stage_action_master_id < 3){
                    return [
                        'id' => $lastProspectActionLog->prospect_id,
                    ];
                }else{
                    return NULL;
                }
            case 'latentFromDiscrimination':
                if ($lastProspectActionLog->stage_action_master_id === 1){
                    return [
                        'id' => $lastProspectActionLog->prospect_id,
                    ];
                }else{
                    return NULL;
                }
            case 'overtFromLowerStage':
                if ($lastProspectActionLog->stage_action_master_id < 3){
                    return [
                        'id' => $lastProspectActionLog->prospect_id,
                    ];
                }else{
                    return NULL;
                }
        }
    }

    //上位stから
    protected function FromTheUpperStage($prospects, $target_stage_id, $stage, $request): array
    {
        $roomList = [];
        foreach ($prospects as $prospect) {
            $firstProspectActionLog = $prospect->prospectActionLogs
                ->where('date' , '<', Carbon::create($request->input('start_period')->format('Y-m-d'))->subMonthNoOverflow()->lastOfMonth())
                ->sortBy('date')
                ->last();
            $lastProspectActionLog = $prospect->prospectActionLogs
                ->sortBy('date')
                ->last();
            if ($lastProspectActionLog?->stage_action_master_id === $target_stage_id){
                $roomList[] = $this->stageUpJudgment($firstProspectActionLog, $stage);
            }
        }
        return $roomList;
    }

    protected function NewCount($prospects, $target_stage_id): ?array
    {
        if ($prospects->isEmpty())return NULL;
        $roomList = [];
        foreach ($prospects as $prospect){
            $prospectActionLog = $prospect->prospectActionLogs
                ->sortBy('date')
                ->last();
            if ($prospectActionLog->stage_action_master_id === $target_stage_id){
                $roomList[] = [
                    'id' => $prospectActionLog->prospect_id,
                ];
            }
        }
        return $roomList;
    }
}