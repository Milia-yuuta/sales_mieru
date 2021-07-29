<?php


namespace App\UseCases\Analysis\MonthlyResult;


use App\Models\Prospect;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;

class IndividualReportAction
{
    public function __invoke($request): array
    {

        //デフォルトで当月
        if (empty($request->input('period'))){
            $request = $request->merge([
                'period' => Carbon::now()
            ]);
        }elseif (is_string($request->input('period'))){
            $request = $request->merge([
                'period' => Carbon::createFromDate($request->input('period'))
            ]);
        }

        //事業所の社員IDを取得
        $UserId = $this->searchUser($request);
        //事業所のチームIDを取得
        $TeamId = $this->searchTeam($UserId);

        $searchByOfficeProspects = $this-> searchByOfficeProspect($request);
        $beforeThisMonthProspects = $this->beforeThisMonthProspect($request);
        //ページ下部で使用する事業所の各チームの見込み分析リスト
        foreach ($TeamId->sortBy('area_master_id')as $team){
            $TeamProspect = $this->ThisTeamProspect($searchByOfficeProspects, $team);
            $beforeThisMonthProspect = $this->ThisTeamProspect($beforeThisMonthProspects, $team);
            unset($TeamName, $ProspectStageCount, $StageUpCount, $VisitCount, $MediationCount);

            //チーム名
            $TeamName = [
                'sales' => $team->sale->sei,
                'hat' => $team->hat->sei ?? '',
                'area' => $team->area->action_name,
            ];

            //見込み発生数
            $ProspectStageCount = [
                'discrimination' => $this->ProspectCount($TeamProspect, 1),
                'latent' => $this->ProspectCount($TeamProspect, 2),
                'overt' => $this->ProspectCount($TeamProspect, 3),
                'total' => 0,
            ];
            $ProspectStageCount['total'] = $ProspectStageCount['discrimination'] + $ProspectStageCount['latent'] + $ProspectStageCount['overt'];

            //ステージUP数
            $StageUpCount = [
                'LatentFormDiscrimination' => $this->stageUpGenerate($beforeThisMonthProspect, $team, $request->input('period'), 1,'latentFromDiscrimination') + $this->newStageUpCount($TeamProspect, 1, 'latentFromDiscrimination'),
                'OvertFromDiscrimination' => $this->stageUpGenerate($beforeThisMonthProspect, $team, $request->input('period'), 1,'overtFromDiscrimination') +  $this->newStageUpCount($TeamProspect, 1, 'overtFromDiscrimination'),
                'OvertFromLatent' => $this->stageUpGenerate($beforeThisMonthProspect, $team, $request->input('period'), 2,'overtFromLatent') +  $this->newStageUpCount($TeamProspect, 2, 'overtFromLatent'),
                'total' => 0,
            ];
            $StageUpCount['total'] = $StageUpCount['LatentFormDiscrimination'] + $StageUpCount['OvertFromDiscrimination'] + $StageUpCount['OvertFromLatent'];

            //査定、訪問数
            $VisitCount = [
                'WebNegotiation' => $this->countVisit($team, $request->input('period'), 'web_negotiation'),
                'AssessmentNegotiation' => $this->countVisit($team, $request->input('period'), 'assessment_negotiation'),
                'ReNegotiation' => $this->countVisit($team, $request->input('period'), 're-negotiation'),
                'total' => 0,
            ];
            $VisitCount['total'] = $VisitCount['WebNegotiation'] + $VisitCount['AssessmentNegotiation'] + $VisitCount['ReNegotiation'];

            //媒介数
            $MediationCount = [
                'DedicatedIntermediaryCount' => $this->countMediation($team, $request->input('period'), 15),
                'SellerCount' => $this->countMediation($team, $request->input('period'), 14),
                'panpyCount' => $this->countMediation($team, $request->input('period'), 16),
                'ExclusiveCount' => $this->countMediation($team, $request->input('period'), 17),
                'total' =>  0,
            ];
            $MediationCount['total'] = $MediationCount['DedicatedIntermediaryCount'] + $MediationCount['SellerCount'] + $MediationCount['panpyCount'] + $MediationCount['ExclusiveCount'];
            $analysisData[] = array_merge(['TeamName' => $TeamName], ['countProspect' => $ProspectStageCount], ['countStageUp' => $StageUpCount], ['countVisit' => $VisitCount], ['countMediation' => $MediationCount]);
        }
        return $analysisData;
    }

    //該当事業所の社員のIDを取得
    protected function searchUser($request): \Illuminate\Support\Collection
    {
        return User::where('office_master_id', $request->input('office_master_id'))
            ->pluck('id');
    }

    //該当事業所のチームを取得
    private function searchTeam($UserId): \Illuminate\Support\Collection
    {
        return Team::with('sale','hat')
            ->whereIn('sales_id', $UserId)
            ->orWhereIn('hat_id', $UserId)
            ->get();
    }

    protected function searchByOfficeProspect($request): \Illuminate\Database\Eloquent\Collection|array
    {
        return Prospect::with(['prospectActionLogs' => function($query) use ($request){
            $query->where('date' , '<=', Carbon::create($request->input('period')->endOfMonth()->format('Y-m-d')));
        }])
            ->whereBetween('date', [$request->input('period')->startOfMonth()->format('Y-m-d'), $request->input('period')->endOfMonth()->format('Y-m-d')])
            ->where('office_master_id', $request->input('office_master_id'))
            ->get();
    }

    protected function beforeThisMonthProspect($request): \Illuminate\Database\Eloquent\Collection|array
    {
        return Prospect::with(['prospectActionLogs' => function($query) use ($request){
            $query->where('date' , '<=', Carbon::create($request->input('period')->endOfMonth()->format('Y-m-d')));
        }])
            ->where('office_master_id', $request->office_master_id)
            ->get()
            ->where('date', '<', $request->input('period')->startOfMonth()->format('Y-m-d'));
    }

    //当年の該当チームのモデルを取得
    protected function ThisTeamProspect($searchByOfficeProspect, $team)
    {
        return $searchByOfficeProspect
            ->where('area_master_id', $team->area_master_id);
    }

    //該当チームの見込み発生数
    protected function ProspectCount($ThisBetweenProspect, $target_stage):int
    {
        if ($ThisBetweenProspect->isEmpty()) return 0;
        $count = 0;
        foreach ($ThisBetweenProspect as $prospect){
            $firstProspectActionLog =
                $prospect->prospectActionLogs
                    ->sortBy('date')
                    ->first();
            if ($firstProspectActionLog?->stage_action_master_id === $target_stage){
                $count++;
            }else{
                $count += 0;
            }
        }
        return $count;
    }

    //該当チームの見込み発生数合計
    protected function ProspectTotalCount($ThisPeriodProspects): int
    {
        if ($ThisPeriodProspects->isEmpty()) return 0;
        return $ThisPeriodProspects->count();
    }

    //当月前の見込のステージアップ数
    private function stageUpGenerate($beforeThisMonthProspect, $team, $month, $firstStage,$target_stage): int
    {
        $prospects = $beforeThisMonthProspect
            ->where('area_master_id', $team->area_master_id);
        return $this->StageUpCount($prospects, $firstStage, $target_stage, $month);
    }

    //ステージアップ合計
    protected function StageUpCount($prospects, $first_stage_id, $stage, $month): int
    {
        $count = 0;
        foreach ($prospects as $prospect) {
            $firstProspectActionLog = $prospect->prospectActionLogs
                ->where('date' , '<', Carbon::create($month->format('Y-m-d'))->startOfMonth()->format('Y-m-d'))
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

    //ステージアップ合計
    protected function newStageUpCount($prospects, $first_stage_id, $stage): int
    {
        $count = 0;
        foreach ($prospects as $prospect) {
            $firstProspectActionLog = $prospect->prospectActionLogs
                ->sortBy('date')
                ->first();
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
        switch ($stage){
            case 'latentFromDiscrimination':
                if ($lastProspectActionLog->stage_action_master_id === 2){
                    return 1;
                }else{
                    return 0;
                }
            case 'overtFromLatent':
            case 'overtFromDiscrimination':
                if ($lastProspectActionLog->stage_action_master_id === 3){
                    return 1;
                }else{
                    return 0;
                }
            default:
                return 0;
        }
    }

    //査定、訪問の合計
    protected function countVisit($team, $month, $target_column): int
    {
        $prospects = Prospect::with(['prospectActionLogs' => function($query) use ($month){
            $query->whereBetween('date' , [ Carbon::create($month->startOfMonth()->format('Y-m-d')), Carbon::create($month->endOfMonth()->format('Y-m-d'))]);
        }])
            ->where('office_master_id', $team->office_master_id)
            ->where('area_master_id', $team->area_master_id)
            ->get()
            ->where('date', '<=', $month->endOfMonth()->format('Y-m-d'));

        $WebNegotiation = 0;
        if ($prospects->isEmpty()) return 0;
        foreach ($prospects as $prospect){
            $WebNegotiation += $prospect->prospectActionLogs
                ->where($target_column, 1)->count();
        }
        return $WebNegotiation;
    }

    //媒介合計
    protected function countMediation($team, $month, $targetStatus): int
    {
        $prospects = Prospect::with(['prospectActionLogs' => function($query) use ($month){
            $query->whereBetween('date' , [ Carbon::create($month->startOfMonth()->format('Y-m-d')), Carbon::create($month->endOfMonth()->format('Y-m-d'))]);
        }])
            ->where('office_master_id', $team->office_master_id)
            ->where('area_master_id', $team->area_master_id)
            ->get()
            ->where('date', '<=', $month->endOfMonth()->format('Y-m-d'));

        if ($prospects->isEmpty()){return 0;}
        $count = 0;
        foreach ($prospects as $prospect) {
            $lastProspectActionLog = $prospect->prospectActionLogs
                ->sortBy('date')
                ->last();
            if (empty($lastProspectActionLog)){
                $count += 0;
            } elseif ($lastProspectActionLog->status_action_master_id === $targetStatus){
                $count ++;
            }else{
                $count += 0;
            }
        }
        return $count;
    }
}