<?php


namespace App\UseCases\Analysis\StageTrend;

use App\Models\Prospect;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class FootListReportAction
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

        //該当事業所の社員毎のステージ推移
        foreach ($teams->sortBy('area_master_id') as $team){
            //UserIdで特定
            $prospects = $this->ThisUserProspect($PeriodProspect, $team);
            $startMonthAreaProspect = $this->ThisUserProspect($startMonthProspect, $team);
            $endMonthAreaProspect = $this->ThisUserProspect($endMonthProspect, $team);
            $newCountAreaProspect = $this->ThisUserProspect($newCountProspect, $team);

//            $user = [
//                'id' => $team->id,
//                'user_name' => $team->sale->sei,
//                'pair_name' => $team->hat->sei ?? '',
//                'area' => $team->area->action_name
//            ];

//            //判別
//            $discrimination = [
//                'StartCount' => $this->StartMonthStageCount($startMonthAreaProspect,1),
//                'MediationCount' => -($this->StageUpCount($prospects, 1, 'mediation', $request)),
//                'StageUpCount' => -($this->StageUpCount($prospects, 1, 'discrimination', $request)),
//                'StageDiscriminationDownCount' => $this->FromTheUpperStage($prospects, 1, 'discrimination', $request),
//                'DemotedCount' => -($this->StageUpCount($prospects, 1, 'demoted', $request)),
//                'NewCount' => $this->NewCount($newCountAreaProspect, 1),
//                'EndCount' => $this->endMonthStageCount($endMonthAreaProspect, 1)
//            ];


            //潜在
            $latent = [
                'AssessmentCount' => $this->NewActionInCount($request, 2, 'assessment_negotiation', $team),
                'ReNegotiationCount' => $this->NewActionInCount($request, 2, 're-negotiation', $team),
            ];

            //顕在
            $overt = [
                'AssessmentCount' => $this->NewActionInCount($request, 3, 'assessment_negotiation', $team),
                'ReNegotiationCount' => $this->NewActionInCount($request, 3, 're-negotiation', $team),
            ];

            //媒介
            $mediation = [
                'DedicatedIntermediaryCount' => $this->NewStatusInCount($request, 15, $team),
                'SellerCount' => $this->NewStatusInCount($request, 14, $team),
                'panpyCount' => $this->NewStatusInCount($request, 16, $team),
                'ExclusiveCount' => $this->NewStatusInCount($request, 17, $team),
            ];
            $analysisData[$team->id] = array_merge(['latent' => $latent, 'overt' => $overt, 'mediation' => $mediation]);
        }
        return $analysisData;
    }
}