<?php


namespace App\UseCases\Analysis;


use Carbon\Carbon;
use App\Models\Team;
use App\Models\Prospect;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class WebResponse
{
    public function __invoke($request): array
    {
        //デフォルト画面でログインユーザーの事業所を表示するために
        if (empty($request->input('office_master_id'))){
            $request = $request->merge([
                'office_master_id' => User::find(Auth::user()->id)->office_master_id
            ]);
        }

        //デフォルトで当月の月初
        if (empty($request->input('start_period'))){
            $request = $request->merge([
                'start_period' => Carbon::now()->startOfMonth()
            ]);
        }else{
            $month = $request->input('start_period');
            $request = $request->merge(['start_period' => Carbon::parse("${month}-01 00:00:00")]);
        }

        //デフォルトで当月の月末
        if (empty($request->input('end_period'))){
            $request = $request->merge([
                'end_period' => Carbon::now()->endOfMonth()
            ]);
        }else{
            $month = $request->input('end_period');
            $request = $request->merge(['end_period' => Carbon::parse("${month}-01 00:00:00")->endOfMonth()]);
        }

        //事業所の社員IDを取得
        $UserId = $this->searchUser($request);
        //事業所のチームIDを取得
        $teams = $this->searchTeam($UserId);
        //該当期間の見込みリスト
        $BetweenProspect = $this->TargetMonthModel(Prospect::with('prospectActionLogs'), $request);
//        $endOfMonthProspect = $this->endOfMonthModel($request);
        //sum変数
        $sumEchoCount = 0;
        $sumResponseCount = 0;
        $sumWebNegotiationCount = 0;
        $sumAssessmentNegotiationCount = 0;
        $sumMediationCount = 0;
        $sumExclusiveCount = 0;
        foreach ($teams->sortBy('area_master_id') as $team){
            $thisBetweenProspect = $this->ThisTeamModel($BetweenProspect, $team);
//            $thisEndOfMonthProspect = $this->ThisTeamModel($endOfMonthProspect, $team);

            $EchoCount = $this->EchoCount($thisBetweenProspect);
            $ResponseCount = $this->ResponseCount($thisBetweenProspect);
            $WebNegotiationCount = $this->ActionCount($thisBetweenProspect, 'web_negotiation');
            $AssessmentNegotiationCount = $this->ActionCount($thisBetweenProspect, 'assessment_negotiation');
            $MediationCount =  $this-> MediationCount($thisBetweenProspect);
            $ExclusiveCount = $this->ExclusiveCount($thisBetweenProspect);

            $analysisData['list'][] = [
                'area' => $team->area->action_name,
                'sale' => $team->sale->sei,
                'hat' => $team->hat->sei ?? '',
                'EchoCount' => $EchoCount,
                'ResponseCount' => $ResponseCount,
                'WebNegotiationCount' => $WebNegotiationCount,
                'AssessmentNegotiationCount' => $AssessmentNegotiationCount,
                'MediationCount' => $MediationCount,
                'ExclusiveCount' => $ExclusiveCount,
                'EchoRate' => $this->RateCalc($ResponseCount, $EchoCount),
                'AssessmentRate' => $this->RateCalc($AssessmentNegotiationCount, $EchoCount),
                'MediationRate' => $this->RateCalc($MediationCount, $EchoCount),
                'ExclusiveRate' => $this->RateCalc($ExclusiveCount, $MediationCount),
            ];
            $sumEchoCount += $EchoCount;
            $sumResponseCount += $ResponseCount;
            $sumWebNegotiationCount += $WebNegotiationCount;
            $sumAssessmentNegotiationCount += $AssessmentNegotiationCount;
            $sumMediationCount += $MediationCount;
            $sumExclusiveCount += $ExclusiveCount;
        }
        //各項目の平均値を計算
        $analysisData['sum']['sumEchoCount'] = $sumEchoCount;
        $analysisData['sum']['sumResponseCount'] = $sumResponseCount;
        $analysisData['sum']['sumWebNegotiationCount'] = $sumWebNegotiationCount;
        $analysisData['sum']['sumAssessmentNegotiationCount'] = $sumAssessmentNegotiationCount;
        $analysisData['sum']['sumMediationCount'] = $sumMediationCount;
        $analysisData['sum']['sumExclusiveCount'] = $sumExclusiveCount;
        $analysisData['average'] = $this->average($analysisData);
        return $analysisData;
    }

    //該当事業所の社員のIDを取得
    private function searchUser($request): \Illuminate\Support\Collection
    {
        return User::where('office_master_id', $request->input('office_master_id'))
            ->pluck('id');
    }

    //該当事業所のチームを取得
    private function searchTeam($UserId): \Illuminate\Support\Collection
    {
        return Team::with('sale', 'hat', 'area')
            ->whereIn('sales_id', $UserId)
            ->orWhereIn('hat_id', $UserId)
            ->get();
    }

    //月内でのmodelを取得
    private function TargetMonthModel($ModelInstance, $request)
    {
        return $ModelInstance
            ->whereBetween('date', [$request->input('start_period')->format('Y-m-d'), $request->input('end_period')->format('Y-m-d')])->get();
    }

    //月末まで
    private function endOfMonthModel($request)
    {
        return Prospect::with(['prospectActionLogs' => function($query) use ($request){
            $query->whereBetween('date' , [$request->input('start_period')->format('Y-m-d'), $request->input('end_period')->format('Y-m-d')]);
        }])
            ->where('date', '<=', $request->input('end_period')->format('Y-m-d'))
            ->get();
    }


    //該当ユーザーのModel取得
    private function ThisTeamModel($ModelInstance, $team)
    {
        return $ModelInstance
            ->where('office_master_id', $team->office_master_id)
            ->where('area_master_id', $team->area_master_id)
            ->whereIn('generating_medium_master_id', [67, 68]);
    }
    
    //反響数
    private function EchoCount($ProspectInstance)
    {
        if ($ProspectInstance->isEmpty()){
            return 0;
        }
        return $ProspectInstance->count();
    }

    //反応有数
    private function ResponseCount($ProspectInstance): int
    {
        $count = 0;
        if ($ProspectInstance->isEmpty()){
            return $count;
        }
        foreach ($ProspectInstance as $prospect){
            $checkTELHome = $prospect->prospectActionLogs->where('TEL_home', 1);
            $checkVisit = $prospect->prospectActionLogs->where('visit', 1);
            $checkHp = $prospect->prospectActionLogs->where('re_hp', 1);
            $checkSite = $prospect->prospectActionLogs->where('re_site', 1);
            $checkTel = $prospect->prospectActionLogs->where('re_TEL', 1);
            $checkEmail = $prospect->prospectActionLogs->where('re_email', 1);
            $checkLetter = $prospect->prospectActionLogs->where('re_letter', 1);
            $checkOther = $prospect->prospectActionLogs->where('re_other', 1);
            if ($checkTELHome->isNotEmpty() || $checkVisit->isNotEmpty() || $checkHp->isNotEmpty() || $checkSite->isNotEmpty()  || $checkTel->isNotEmpty()  || $checkEmail->isNotEmpty()  || $checkLetter->isNotEmpty()  || $checkOther->isNotEmpty() ){
                $count++;
            }
        }
        return $count;
    }

    //Web商談 or 査定 数
    private function ActionCount($ProspectInstance, $target_column): int
    {
        $count = 0;
        if ($ProspectInstance->isEmpty()){
            return $count;
        }
        foreach ($ProspectInstance as $prospect){
            $checkModel = $prospect->prospectActionLogs->where($target_column, 1);
            if ($checkModel->isNotEmpty()){
                $count++;
            }
        }
        return $count;
    }

    //媒介数
    private function MediationCount($ProspectInstance)
    {
        $count = 0;
        if ($ProspectInstance->isEmpty()){
            return $count;
        }
        foreach ($ProspectInstance as $prospect){
            $count += $prospect->prospectActionLogs
                ->where('stage_action_master_id', 4)
                ->count();
        }
        return $count;
    }

    //専任、専属、売主数
    private function ExclusiveCount($ProspectInstance)
    {
        $count = 0;
        if ($ProspectInstance->isEmpty()){
            return $count;
        }
        foreach ($ProspectInstance as $prospect){
            $mediation = $prospect->prospectActionLogs
                ->where('stage_action_master_id', 4);
            $countSeller = $mediation
                ->where('status_action_master_id', 14)
                ->count();
            $countDedicatedIntermediary = $mediation
                ->where('status_action_master_id', 15)
                ->count();
            $countExclusive = $mediation
                ->where('status_action_master_id', 17)
                ->count();
            $count += $countSeller + $countDedicatedIntermediary + $countExclusive;
        }
        return $count;
    }

    //rate計算用
    private function RateCalc($numerator, $denominator)
    {
        if ($numerator == 0 || $denominator == 0){
            return 0;
        }
        return round($numerator / $denominator * 100, 1);
    }

    //割合の平均
    private function average($analysisData): array
    {
        return[
            'EchoRateAverage' => $this->RateCalc($analysisData['sum']['sumResponseCount'], $analysisData['sum']['sumEchoCount']),
            'AssessmentRateAverage' => $this->RateCalc($analysisData['sum']['sumAssessmentNegotiationCount'], $analysisData['sum']['sumEchoCount']),
            'MediationRateAverage' => $this->RateCalc($analysisData['sum']['sumMediationCount'], $analysisData['sum']['sumEchoCount']),
            'ExclusiveRateAverage' => $this->RateCalc($analysisData['sum']['sumExclusiveCount'], $analysisData['sum']['sumMediationCount']),
        ];
    }
}