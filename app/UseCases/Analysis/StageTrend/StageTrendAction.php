<?php


namespace App\UseCases\Analysis\StageTrend;

use App\Models\Prospect;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StageTrendAction
{
    public function __invoke($request)
    {
        //デフォルト画面でログインユーザーの事業所を表示するために
        if (empty($request->input('office_master_id'))){
            $request = $request->merge([
                'office_master_id' => Auth::user()->office_master_id
            ]);
        }

        //デフォルトで当月初
        if (empty($request->input('start_period'))){
            $request = $request->merge([
                'start_period' => now()->startOfMonth()
            ]);
        }else{
            $month = $request->input('start_period');
            $request = $request->merge(['start_period' => Carbon::parse("${month}-01 00:00:00")]);
        }

        //デフォルトで当月末
        if (empty($request->input('end_period'))){
            $request = $request->merge([
                'end_period' => now()->endOfMonth()
            ]);
        }else{
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
        $newActionProspect = $this->generateNewActionCountProspect($request);

        //該当事業所の社員毎のステージ推移
        foreach ($teams->sortBy('area_master_id') as $team){
//            unset($discrimination, $latent, $overt);
            //UserIdで特定
            $prospects = $this->ThisUserProspect($PeriodProspect, $team);
            $startMonthAreaProspect = $this->ThisUserProspect($startMonthProspect, $team);
            $endMonthAreaProspect = $this->ThisUserProspect($endMonthProspect, $team);
            $newCountAreaProspect = $this->ThisUserProspect($newCountProspect, $team);
            $newActionAreaProspect = $this->ThisUserProspect($newActionProspect, $team);

            $user = [
                'id' => $team->id,
                'user_name' => $team->sale->sei,
                'pair_name' => $team->hat->sei ?? '',
                'area' => $team->area->action_name
            ];

            //判別
            $discrimination = [
                'StartCount' => $this->StartMonthStageCount($startMonthAreaProspect,1),
                'MediationCount' => -($this->StageUpCount($prospects, 1, 'mediation', $request)),
                'StageUpCount' => -($this->StageUpCount($prospects, 1, 'discrimination', $request)),
                'StageDiscriminationDownCount' => $this->FromTheUpperStage($prospects, 1, 'discrimination', $request),
                'DemotedCount' => -($this->StageUpCount($prospects, 1, 'demoted', $request)),
                'NewCount' => $this->NewCount($newCountAreaProspect, 1),
                'EndCount' => $this->endMonthStageCount($endMonthAreaProspect, 1)
            ];


            //潜在
            $latent = [
                'StartCount' => $this->StartMonthStageCount($startMonthAreaProspect,2),
                'MediationCount' => -($this->StageUpCount($prospects, 2, 'mediation', $request)),
                'OvertFromLatentCount' => -($this->StageUpCount($prospects, 2, 'latent', $request)),
                'StageLatentDownCount' =>$this->FromTheUpperStage($prospects, 2, 'latentFromDiscrimination', $request),
                'FromOvert' => $this->FromTheUpperStage($prospects, 2, 'latent', $request),
                'DemotedCount' => -($this->StageUpCount($prospects, 2, 'demotedFromLatent', $request)),
                'NewCount' => $this->NewCount($newCountAreaProspect, 2),
                'EndCount' => $this->endMonthStageCount($endMonthAreaProspect, 2),
                'AssessmentCount' => $this->NewActionInCount($newActionAreaProspect, 2, 'assessment_negotiation'),
                'ReNegotiationCount' => $this->NewActionInCount($newActionAreaProspect, 2, 're-negotiation'),
            ];

            //顕在
            $overt = [
                'StartCount' => $this->StartMonthStageCount($startMonthAreaProspect,3),
                'MediationCount' => -($this->StageUpCount($prospects, 3, 'mediation', $request)),
                'FromBottomCount' =>  $this->FromTheUpperStage($prospects, 3, 'overtFromLowerStage', $request),
                'DemotedCount' => -($this->StageUpCount($prospects, 3, 'demotedFromOvert', $request)),
                'NewCount' => $this->NewCount($newCountAreaProspect, 3),
                'EndCount' => $this->endMonthStageCount($endMonthAreaProspect, 3),
                'AssessmentCount' => $this->NewActionInCount($newActionAreaProspect, 3, 'assessment_negotiation'),
                'ReNegotiationCount' => $this->NewActionInCount($newActionAreaProspect, 3, 're-negotiation'),
            ];

            //媒介
            $mediation = [
                'DedicatedIntermediaryCount' => $this->NewStatusInCount($newActionAreaProspect, 15),
                'SellerCount' => $this->NewStatusInCount($newActionAreaProspect, 14),
                'panpyCount' => $this->NewStatusInCount($newActionAreaProspect, 16),
                'ExclusiveCount' => $this->NewStatusInCount($newActionAreaProspect, 17),
            ];
            $analysisData[] = array_merge(['user' => $user, 'discrimination' => $discrimination, 'latent' => $latent, 'overt' => $overt, 'mediation' => $mediation]);
        }
        return $analysisData;
    }


    //該当事業所の社員のIDを取得
    protected function searchTeam($request): \Illuminate\Support\Collection
    {
        return Team::where('office_master_id', $request->input('office_master_id'))->get();
    }

    //期間のProspectを取得
    protected function PeriodProspect($request)
    {
        return Prospect::with(['prospectActionLogs' => function($query) use ($request){
            $query->where('date' , '<',Carbon::create($request->input('end_period')->format('Y-m-d')));
        }])
            ->where('date', '<=',Carbon::create($request->input('start_period')->format('Y-m-d'))->subMonthNoOverflow()->lastOfMonth())
            ->where('office_master_id', $request->input('office_master_id'))
            ->get();
    }

    protected function generateStartMonthProspect($request)
    {
        return
            Prospect::with(['prospectActionLogs' => function($query) use ($request){
                $query->where('date' , '<', Carbon::create($request->input('start_period')->format('Y-m-d')));
            }])
                ->where('office_master_id', $request->office_master_id)
                ->where('date', '<',Carbon::create($request->input('start_period')->format('Y-m-d')))
                ->get();
    }

    protected function generateEndMonthProspect($request)
    {
        return
            Prospect::with(['prospectActionLogs' => function($query) use ($request){
                $query->where('date' , '<=', Carbon::create($request->input('end_period')->format('Y-m-d')));
            }])
                ->where('office_master_id', $request->office_master_id)
                ->where('date', '<=',Carbon::create($request->input('end_period')->format('Y-m-d')))
                ->get();
    }

    protected function generateNewCountProspect($request)
    {
        return
            Prospect::with(['prospectActionLogs' => function($query) use ($request){
                $query->whereBetween('date' , [Carbon::create($request->input('start_period')->format('Y-m-d')), Carbon::create($request->input('end_period')->format('Y-m-d'))]);
            }])
                ->whereBetween('date' , [Carbon::create($request->input('start_period')->format('Y-m-d')), Carbon::create($request->input('end_period')->format('Y-m-d'))])
                ->where('office_master_id', $request->office_master_id)
                ->get();
    }

    protected function generateNewActionCountProspect($request)
    {
        return Prospect::with(['prospectActionLogs' => function ($query) use ($request) {
            $query->whereBetween('date', [Carbon::create($request->input('start_period')->format('Y-m-d')), Carbon::create($request->input('end_period')->format('Y-m-d'))]);
        }])
            ->where('date', '<', Carbon::create($request->input('end_period')->format('Y-m-d')))
            ->where('office_master_id', $request->office_master_id)
            ->get();
    }

    //該当ユーザーのProspectを取得
    protected function ThisUserProspect($prospect, $team)
    {
        return $prospect->where('area_master_id', $team->area_master_id);
    }

    //月初のカウント
    protected function StartMonthStageCount($prospects, $target_stage_id)
    {
        if ($prospects->isEmpty())return 0;
        $count = 0;
        foreach ($prospects as $prospect){
            $prospectActionLog = $prospect->prospectActionLogs
                ->sortBy('date')
                ->last();

            if (empty($prospectActionLog)) {
                $count += 0;
            } elseif($prospectActionLog->stage_action_master_id === $target_stage_id){
                ++$count;
            }
        }
        return $count;
    }

    //月末のカウント
    protected function endMonthStageCount($prospects, $target_stage_id): int
    {
        if ($prospects->isEmpty())return 0;
        $count = 0;
        foreach ($prospects as $prospect){
            $prospectActionLog = $prospect->prospectActionLogs
                ->sortBy('date')
                ->last();
            if (empty($prospectActionLog)) {
                $count += 0;
            } elseif($prospectActionLog->stage_action_master_id === $target_stage_id){
                ++$count;
            }
        }
        return $count;
    }

    //ステージアップした見込みを絞り込み
    protected function StageUpCount($prospects, $first_stage_id, $stage, $request): int
    {
        $count = 0;
        foreach ($prospects as $prospect) {
            $firstProspectActionLog = $prospect->prospectActionLogs
                ->where('date' , '<', Carbon::create($request->input('start_period')->format('Y-m-d'))->subMonthNoOverflow()->lastOfMonth())
                ->sortBy('date')
                ->last();
            $lastProspectActionLog = $prospect->prospectActionLogs
                ->sortBy('date')
                ->last();
            if (empty($lastProspectActionLog) || empty($firstProspectActionLog)) {
                $count += 0;
            } elseif($firstProspectActionLog->stage_action_master_id === $first_stage_id){
                $count += $this->stageUpJudgment($lastProspectActionLog, $stage);
            }
        }
        return $count;
    }

    protected function stageUpJudgment($lastProspectActionLog, $stage): int
    {
        if ($lastProspectActionLog?->stage_action_master_id === NULL){
            return 0;
        }
        switch ($stage){
            case 'discrimination':
                if (1 < $lastProspectActionLog->stage_action_master_id && $lastProspectActionLog->stage_action_master_id < 4 ){
                    return 1;
                }else{
                    return 0;
                }
            case 'latent':
                if (2 < $lastProspectActionLog->stage_action_master_id && $lastProspectActionLog->stage_action_master_id < 4 ){
                    return 1;
                }else{
                    return 0;
                }
            case 'overt':
                if ($lastProspectActionLog->stage_action_master_id && $lastProspectActionLog->stage_action_master_id < 4 ){
                    return 1;
                }else{
                    return 0;
                }
            case 'mediation':
                if ($lastProspectActionLog->stage_action_master_id === 4){
                    return 1;
                }else{
                    return 0;
                }
            case 'demoted':
                if ($lastProspectActionLog->stage_action_master_id === 103){
                    return 1;
                }else{
                    return 0;
                }
            case 'demotedFromLatent':
                if ($lastProspectActionLog->stage_action_master_id === 103 || $lastProspectActionLog->stage_action_master_id === 1){
                    return 1;
                }else{
                    return 0;
                }
            case 'demotedFromOvert':
                if ($lastProspectActionLog->stage_action_master_id === 103 || $lastProspectActionLog->stage_action_master_id < 3){
                    return 1;
                }else{
                    return 0;
                }
            case 'latentFromDiscrimination':
                if ($lastProspectActionLog->stage_action_master_id === 1){
                    return 1;
                }else{
                    return 0;
                }
            case 'overtFromLowerStage':
                if ($lastProspectActionLog->stage_action_master_id < 3){
                    return 1;
                }else{
                    return 0;
                }
            default:
                return 0;
        }
    }

    //上位stから
    protected function FromTheUpperStage($prospects, $target_stage_id, $stage, $request): int
    {
        $count = 0;
        foreach ($prospects as $prospect) {
            $firstProspectActionLog = $prospect->prospectActionLogs
                ->where('date' , '<', Carbon::create($request->input('start_period')->format('Y-m-d'))->subMonthNoOverflow()->lastOfMonth())
                ->sortBy('date')
                ->last();
            $lastProspectActionLog = $prospect->prospectActionLogs
                ->sortBy('date')
                ->last();
            if (empty($lastProspectActionLog)) {
                $count += 0;
            } elseif($lastProspectActionLog->stage_action_master_id === $target_stage_id){
                $count += $this->stageUpJudgment($firstProspectActionLog, $stage);
            }
        }
        return $count;
    }

    protected function NewCount($prospects, $target_stage_id): int
    {
        if ($prospects->isEmpty())return 0;
        $count = 0;
        foreach ($prospects as $prospect){
            $prospectActionLog = $prospect->prospectActionLogs
                ->sortBy('date')
                ->last();
            if (empty($prospectActionLog)) {
                $count += 0;
            } elseif($prospectActionLog->stage_action_master_id === $target_stage_id){
                ++$count;
            }
        }
        return $count;
    }

    protected function NewActionInCount($prospects, $target_stage_id, $target_status_column): int
    {
        if ($prospects->isEmpty())return 0;
        $count = 0;

        foreach ($prospects as $prospect){
            $count += $prospect->prospectActionLogs
                ->where('stage_action_master_id', $target_stage_id)
                ->where($target_status_column, 1)
                ->count();
        }
        return $count;
    }

    protected function NewStatusInCount($prospects, $target_status_id): int
    {
        if ($prospects->isEmpty())return 0;
        $count = 0;
        foreach ($prospects as $prospect){
            $count += $prospect->prospectActionLogs
                ->where('stage_action_master_id', 4)
                ->where('status_action_master_id', $target_status_id)
                ->count();
        }
        return $count;
    }

}