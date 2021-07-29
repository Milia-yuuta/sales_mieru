<?php


namespace App\UseCases\Analysis\MonthlyResult;


use App\Models\Prospect;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class OfficeReportAction
{
    public function __invoke($request): array
    {
        $TeamInstance = Team::with('sale','hat');

        //デフォルト画面でログインユーザーの事業所を表示するために
        if (empty($request->input('office_master_id'))){
            $request = $request->merge([
                'office_master_id' => Auth::user()->office_master_id,
                'top_office_id' =>  Auth::user()->office_master_id,
            ]);
        }

        //デフォルトのチームID
        if (empty($request->input('team_id'))){
            if (empty(Auth::user()->AreaIdSearch)){
                $team = Team::where('office_master_id', $request->office_master_id)->first();
            }else{
                $team = Team::where('sales_id', Auth::user()->id)
                    ->orWhere('hat_id', Auth::user()->id)
                    ->first();
            }
            $request = $request->merge([
                'team_id' => $team === NUll ? Auth::user()->AreaIdSearch : $team->id
            ]);
        }

        //デフォルトで当年
        if (empty($request->input('start_period'))){
            $request = $request->merge([
                'start_period' => Carbon::now()->startOfYear(),
                'end_period' => Carbon::now()->endOfYear()
            ]);
        }elseif (is_string($request->input('start_period'))){
            $request = $request->merge([
                'start_period' => Carbon::createFromDate($request->input('start_period')),
                'end_period' => Carbon::createFromDate($request->input('end_period'))
            ]);
        }
        $team = $TeamInstance->find($request->input('team_id'));

        $period = CarbonPeriod::create($request->input('start_period'), $request->input('end_period'))->months();
        foreach ($period as $date){
            $periods[] = $date;
        }

        $areaProspects = $this->searchByAreaProspect($team);

        foreach ($periods as $month) {
            $TargetMonthProspect = $this->thisMonthProspect($areaProspects, $month);
            $countProspect[] = $this->ProspectTotalCount($TargetMonthProspect);
            $StageUpCount[] = $this->stageUpGenerate($TargetMonthProspect, $month) + $this->newStageUpGenerate($TargetMonthProspect);
            $countVisit[] = $this->VisitTotalCount($team, $month);
            $MediationCount[] = $this->MediationTotalCount($team, $month);
            $monthArrayText[] = "{$month->format('m')}月";
        }

        return array_merge(['month' => $monthArrayText], ['countStageUp' => $StageUpCount], ['countProspect' => $countProspect], ['countVisit' => $countVisit], ['countMediation' => $MediationCount]);
    }

    //該当事業所の社員のIDを取得
    protected function searchUser($request): \Illuminate\Support\Collection
    {
        return User::where('office_master_id', $request->input('office_master_id'))
            ->pluck('id');
    }

    protected function searchByAreaProspect($team)
    {
        return Prospect::with('prospectActionLogs')
            ->where('office_master_id', $team->office_master_id)
            ->Where('area_master_id', $team->area_master_id)
            ->get();
    }

    //当年の該当チームのモデルを取得
    protected function thisMonthProspect(Collection $areaProspects, $month)
    {
        return $areaProspects->whereBetween('date', [$month->startOfMonth()->format('Y-m-d'), $month->endOfMonth()])->each(function (Prospect $prospect) use($month) {
            $prospect->load(['prospectActionLogs' => function($query) use($month) {
                $query->whereDate('date', '<=', $month->endOfMonth()->format('Y-m-d'));
            }]);
        });

//        foreach ($areaProspects as $prospect){
//            $prospect->prospectActionLogs->where('date' , '<=', Carbon::create($month->endOfMonth()->format('Y-m-d')));
//        }
//        dd($areaProspects);
//        return $areaProspects;

//        return Prospect::with(['prospectActionLogs' => function($query) use ($month){
//            $query->where('date' , '<=', Carbon::create($month->endOfMonth()->format('Y-m-d')));
//        }])
//            ->whereBetween('date', [$month->startOfMonth()->format('Y-m-d'), $month->endOfMonth()->format('Y-m-d')])
//            ->where('office_master_id', $team->office_master_id)
//            ->Where('area_master_id', $team->area_master_id)
//            ->get();
    }

    //該当チームの見込み発生数
    protected function ProspectCount($ThisBetweenProspect, $target_stage):int
    {
        if ($ThisBetweenProspect->isEmpty()) return 0;
        $count = 0;
        foreach ($ThisBetweenProspect as $prospect){
            $count +=
                $prospect->prospectActionLogs
                    ->where('stage_action_master_id', $target_stage)
                    ->count();
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
    private function stageUpGenerate($prospects, $month): int
    {
//        $prospects = Prospect::with(['prospectActionLogs' => function($query) use ($month){
//            $query->where('date' , '<=', Carbon::create($month->endOfMonth()->format('Y-m-d')));
//        }])
//            ->where('office_master_id', $team->office_master_id)
//            ->Where('area_master_id', $team->area_master_id)
//            ->get()
//            ->where('date', '<', $month->startOfMonth()->format('Y-m-d'));
        $latentFromDiscrimination  = $this->StageUpCount($prospects, 1, 'latentFromDiscrimination', $month);
        $overtFromDiscrimination = $this->StageUpCount($prospects, 1, 'overtFromDiscrimination', $month);
        $overtFromLatent = $this->StageUpCount($prospects, 2, 'overtFromLatent', $month);
        return $latentFromDiscrimination + $overtFromDiscrimination + $overtFromLatent;
    }

    //ステージアップ合計
    protected function StageUpCount($prospects, $first_stage_id, $stage, $month): int
    {
        $count = 0;
        foreach ($prospects as $prospect) {
            $firstProspectActionLog = $prospect->prospectActionLogs
                ->where('date' , '<=', Carbon::create($month->format('Y-m-d'))->subMonthNoOverflow()->endOfMonth())
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

    protected function newStageUpGenerate($prospect): int
    {
        $latentFromDiscrimination  = $this->newStageUpCount($prospect, 1, 'latentFromDiscrimination');
        $overtFromDiscrimination = $this->newStageUpCount($prospect, 1, 'overtFromDiscrimination');
        $overtFromLatent = $this->newStageUpCount($prospect, 2, 'overtFromLatent');
        return $latentFromDiscrimination + $overtFromDiscrimination + $overtFromLatent;
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
    protected function VisitTotalCount($team, $month): int
    {
        $prospects = Prospect::with(['prospectActionLogs' => function($query) use ($month){
            $query->whereBetween('date' , [ Carbon::create($month->startOfMonth()->format('Y-m-d')), Carbon::create($month->endOfMonth()->format('Y-m-d'))]);
        }])
            ->where('office_master_id', $team->office_master_id)
            ->Where('area_master_id', $team->area_master_id)
            ->get()
            ->where('date', '<=', $month->endOfMonth()->format('Y-m-d'));

        $WebNegotiation = 0;
        $AssessmentNegotiation = 0;
        $ReNegotiation = 0;
        if ($prospects->isEmpty()) return 0;
        foreach ($prospects as $prospect){
            $WebNegotiation += $prospect->prospectActionLogs
                ->where('web_negotiation', 1)->count();
            $AssessmentNegotiation += $prospect->prospectActionLogs
                ->where('assessment_negotiation', 1)->count();
            $ReNegotiation += $prospect->prospectActionLogs
                ->where('re-negotiation', 1)->count();
        }
        return $WebNegotiation + $AssessmentNegotiation + $ReNegotiation;
    }

    //媒介合計
    protected function MediationTotalCount($team, $month): int
    {
        $prospects = Prospect::with(['prospectActionLogs' => function($query) use ($month){
            $query->whereBetween('date' , [ Carbon::create($month->startOfMonth()->format('Y-m-d')), Carbon::create($month->endOfMonth()->format('Y-m-d'))]);
        }])
            ->where('office_master_id', $team->office_master_id)
            ->Where('area_master_id', $team->area_master_id)
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
            } elseif ($lastProspectActionLog->stage_action_master_id === 4){
                $count ++;
            }else{
                $count += 0;
            }
        }
        return $count;
    }
}