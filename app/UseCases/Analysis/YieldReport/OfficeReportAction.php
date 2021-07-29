<?php


namespace App\UseCases\Analysis\YieldReport;

use App\Models\ActionMaster;
use App\Models\ProspectActionLog;
use App\Models\Prospect;
use App\Models\ExcavationBehaviorLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class OfficeReportAction
{
    public function __invoke($request): array
    {
        //デフォルト画面でログインユーザーの事業所を表示するために
        if (empty($request->input('office_master_id'))){
            $request = $request->merge([
                'office_master_id' => User::find(Auth::user()->id)->office_master_id
            ]);
        }

        //デフォルトで当月初
        if (empty($request->input('start_period'))){
            $request = $request->merge([
                'start_period' => Carbon::now()->startOfMonth()->subYear(),
            ]);
        }else{
            $month = $request->input('start_period');
            $request = $request->merge(['start_period' =>  Carbon::parse("${month}-01 00:00:00")]);
        }

        //デフォルトで当月末
        if (empty($request->input('end_period'))){
            $request = $request->merge([
                'end_period' => Carbon::now()->endOfMonth()
            ]);
        }else{
            $month = $request->input('end_period');
            $request = $request->merge(['end_period' =>  Carbon::parse("${month}-01 00:00:00")->endOfMonth()]);
        }
        //デフォルト
        $request =$request->merge([
            'last_year_start_period' => Carbon::now()->startOfYear()->subYear(2)->addMonth(3),
            'last_year_end_period' => Carbon::now()->startOfYear()->subYear(2)->addMonth(14),
            'before_last_year_start_period' => Carbon::now()->startOfYear()->subYear(3)->addMonth(3),
            'before_last_year_end_period' => Carbon::now()->startOfYear()->subYear(3)->addMonth(14),
            'whole_year_start_period' => '2000-04',
            'whole_year_end_period' => Carbon::now()
        ]);

        //月内のProspect
        $BetweenMonthProspect = $this->BetweenMonthModel(new Prospect, $request);
        //エリアリスト
        $areaList = ActionMaster::where('group_num', 7)->select('id')->pluck('id')->toArray();

        $OfficeProspect = $BetweenMonthProspect
            ->where('office_master_id', $request->office_master_id)
            ->whereIn('area_master_id', $areaList)
            ->get();

        $endMonthProspects = Prospect::with(['prospectActionLogs' => function ($q) use($request){
            $q->whereBetween('date' , [$request->input('start_period'), $request->input('end_period')])
                ->where('stage_action_master_id', 4);
        }]) ->where('office_master_id', $request->office_master_id)->where('date', '<',  $request->input('end_period'))->get();

        //事業所のデータを取得
        //エリア発掘
        $areaAction = [
            'CaretakerVisitActionCount' => $this->ActionCount($OfficeProspect, 48),
            'PersonalVisitActionCount' => $this->ActionCount($OfficeProspect, 49),
            'PostCheckActionCount' => $this->ActionCount($OfficeProspect, 50),
            'CheckTheBuildingActionCount' => $this->ActionCount($OfficeProspect, 51),
            'PatrolLocalInformationActionCount' => $this->ActionCount($OfficeProspect, 52),
            'DMActionCount' => $this->ActionCount($OfficeProspect, 53),
            'FlyerActionCount' => $this->ActionCount($OfficeProspect, 54),
            'LatterActionCount' => $this->ActionCount($OfficeProspect, 55),
            'RandomActionCount' => $this->ActionCount($OfficeProspect, 56),
        ];
        $areaActionMax = max($areaAction);

        $areaMediation = [
            'CaretakerVisitMediation' => $this->OfficeGraphMediationCount($endMonthProspects, 48),
            'PersonalVisitMediation' => $this->OfficeGraphMediationCount($endMonthProspects, 49),
            'PostCheckMediation' => $this->OfficeGraphMediationCount($endMonthProspects, 50),
            'CheckTheBuildingMediation' => $this->OfficeGraphMediationCount($endMonthProspects, 51),
            'PatrolLocalInformationMediation' => $this->OfficeGraphMediationCount($endMonthProspects, 52),
            'DMMediation' => $this->OfficeGraphMediationCount($endMonthProspects, 53),
            'FlyerMediation' => $this->OfficeGraphMediationCount($endMonthProspects, 54),
            'LatterMediation' => $this->OfficeGraphMediationCount($endMonthProspects, 55),
            'RandomMediation' => $this->OfficeGraphMediationCount($endMonthProspects, 56),
        ];

        $areaRate = [
            'CaretakerVisitRate' => $this->division($areaMediation['CaretakerVisitMediation'], $areaAction['CaretakerVisitActionCount']),
            'PersonalVisitRate' => $this->division($areaMediation['PersonalVisitMediation'], $areaAction['PersonalVisitActionCount']),
            'PostCheckRate' => $this->division($areaMediation['PostCheckMediation'], $areaAction['PostCheckActionCount']),
            'CheckTheBuildingRate' => $this->division($areaMediation['CheckTheBuildingMediation'], $areaAction['CheckTheBuildingActionCount']),
            'PatrolLocalInformationRate' => $this->division($areaMediation['PatrolLocalInformationMediation'], $areaAction['PatrolLocalInformationActionCount']),
            'DMRate' => $this->division($areaMediation['DMMediation'], $areaAction['DMActionCount']),
            'FlyerRate' => $this->division($areaMediation['FlyerMediation'], $areaAction['FlyerActionCount']),
            'LatterActionRate' => $this->division($areaMediation['LatterMediation'], $areaAction['LatterActionCount']),
            'RandomActionRate' => $this->division($areaMediation['RandomMediation'], $areaAction['RandomActionCount']),
        ];
        $areaRateMax = max($areaRate);

        $area = array_merge($areaAction, $areaMediation, $areaRate);

        //社内発掘
        $companyAction = [
            'CaretakerTelActionCount' => $this->ActionCount($OfficeProspect, 57),
            'PersonalTelActionCount' => $this->ActionCount($OfficeProspect, 58),
            'RandomTelActionCount' => $this->ActionCount($OfficeProspect, 59),
            'DMActionCount' => $this->ActionCount($OfficeProspect, 60),
            'LatterActionCount' => $this->ActionCount($OfficeProspect, 61),
            'FlyerActionCount' => $this->ActionCount($OfficeProspect, 62),
            'ReturnByMailActionCount' => $this->ActionCount($OfficeProspect, 63),
            'RentalInformationActionCount' => $this->ActionCount($OfficeProspect, 64),
            'RegistrationInformationActionCount' => $this->ActionCount($OfficeProspect, 65),
            'BuildingConfirmationInformationActionCount' => $this->ActionCount($OfficeProspect, 66),
        ];

        $companyActionMax = max($companyAction);

        $companyMediation = [
            'CaretakerTelMediation' => $this->OfficeGraphMediationCount($endMonthProspects, 57),
            'PersonalTelMediation' => $this->OfficeGraphMediationCount($endMonthProspects, 58),
            'RandomTelMediation' => $this->OfficeGraphMediationCount($endMonthProspects, 59),
            'DMMediation' => $this->OfficeGraphMediationCount($endMonthProspects, 60),
            'LatterMediation' => $this->OfficeGraphMediationCount($endMonthProspects, 61),
            'FlyerMediation' => $this->OfficeGraphMediationCount($endMonthProspects, 62),
            'ReturnByMailMediation' => $this->OfficeGraphMediationCount($endMonthProspects, 63),
            'RentalInformationMediation' => $this->OfficeGraphMediationCount($endMonthProspects, 64),
            'RegistrationInformationMediation' => $this->OfficeGraphMediationCount($endMonthProspects, 65),
            'BuildingConfirmationInformationMediation' => $this->OfficeGraphMediationCount($endMonthProspects, 66),
        ];

        $CompanyRate = [
            'CaretakerTelRate' => $this->division($companyMediation['CaretakerTelMediation'], $companyAction['CaretakerTelActionCount']),
            'PersonalTelRate' => $this->division($companyMediation['PersonalTelMediation'], $companyAction['PersonalTelActionCount']),
            'RandomTelRate' => $this->division($companyMediation['RandomTelMediation'], $companyAction['RandomTelActionCount']),
            'DMRate' => $this->division($companyMediation['DMMediation'], $companyAction['DMActionCount']),
            'LatterRate' => $this->division($companyMediation['LatterMediation'], $companyAction['LatterActionCount']),
            'FlyerRate' => $this->division($companyMediation['FlyerMediation'], $companyAction['FlyerActionCount']),
            'ReturnByMailRate' => $this->division($companyMediation['ReturnByMailMediation'], $companyAction['ReturnByMailActionCount']),
            'RentalInformationRate' => $this->division($companyMediation['RentalInformationMediation'], $companyAction['RentalInformationActionCount']),
            'RegistrationInformationRate' => $this->division($companyMediation['RegistrationInformationMediation'], $companyAction['RegistrationInformationActionCount']),
            'BuildingConfirmationInformationRate' => $this->division($companyMediation['BuildingConfirmationInformationMediation'], $companyAction['BuildingConfirmationInformationActionCount']),
        ];

        $CompanyRateMax = max($CompanyRate);
        $company = array_merge($companyAction, $companyMediation, $CompanyRate);

        //反響
        $responseAction = [
            'HpActionCount' => $this->ActionCount($OfficeProspect, 67),
            'SiteActionCount' => $this->ActionCount($OfficeProspect, 68),
            'IntroductionOfficeActionCount' => $this->ActionCount($OfficeProspect, 69),
            'IntroductionHeadOfficeActionCount' => $this->ActionCount($OfficeProspect, 70),
        ];
        $responseActionMax = max($responseAction);
        $responseMediation = [
            'HpMediation' => $this->OfficeGraphMediationCount($endMonthProspects, 67),
            'SiteMediation' => $this->OfficeGraphMediationCount($endMonthProspects, 68),
            'IntroductionOfficeMediation' => $this->OfficeGraphMediationCount($endMonthProspects, 69),
            'IntroductionHeadOfficeMediation' => $this->OfficeGraphMediationCount($endMonthProspects, 70),
        ];
        $responseRate = [
            'HpRate' => $this->division($responseMediation['HpMediation'], $responseAction['HpActionCount']),
            'SiteRate' => $this->division($responseMediation['SiteMediation'], $responseAction['SiteActionCount']),
            'IntroductionOfficeRate' => $this->division($responseMediation['IntroductionOfficeMediation'], $responseAction['IntroductionOfficeActionCount']),
            'IntroductionHeadOfficeRate' => $this->division($responseMediation['IntroductionHeadOfficeMediation'], $responseAction['IntroductionHeadOfficeActionCount']),
        ];
        $responseRateMax = max($responseRate);
        $response = array_merge($responseAction, $responseMediation, $responseRate);

        //前取り
        $preAction = [
            'PreVisitActionCount' => $this->ActionCount($OfficeProspect, 71),
            'PreTelActionCount' => $this->ActionCount($OfficeProspect, 72),
            'PreSelfDiscoveryActionCount' => $this->ActionCount($OfficeProspect, 73),
            'PreResponseActionCount' => $this->ActionCount($OfficeProspect, 74),
            'PreOtherActionCount' => $this->ActionCount($OfficeProspect, 75),
        ];
        $preActionMax = max($preAction);
        $preMediation = [
            'PreVisitMediation' => $this->OfficeGraphMediationCount($endMonthProspects, 71),
            'PreTelMediation' => $this->OfficeGraphMediationCount($endMonthProspects, 72),
            'PreSelfDiscoveryMediation' => $this->OfficeGraphMediationCount($endMonthProspects, 73),
            'PreResponseMediation' => $this->OfficeGraphMediationCount($endMonthProspects, 74),
            'PreOtherMediation' => $this->OfficeGraphMediationCount($endMonthProspects, 75),
        ];
        $preRate = [
            'PreVisitRate' => $this->division($preMediation['PreVisitMediation'], $preAction['PreVisitActionCount']),
            'PreTelRate' => $this->division($preMediation['PreTelMediation'], $preAction['PreTelActionCount']),
            'PreSelfDiscoveryRate' => $this->division($preMediation['PreSelfDiscoveryMediation'], $preAction['PreSelfDiscoveryActionCount']),
            'PreResponseRate' => $this->division($preMediation['PreResponseMediation'], $preAction['PreResponseActionCount']),
            'PreOtherRate' => $this->division($preMediation['PreOtherMediation'], $preAction['PreOtherActionCount']),
        ];
        $preRateMax =  max($preRate);
        $pre = array_merge($preAction, $preMediation, $preRate);

        //その他
        $otherAction = [
            'BusinessInvolvementActionCount' => $this->ActionCount($OfficeProspect, 76),
            'OpenRoomActionCount' => $this->ActionCount($OfficeProspect, 77),
            'FreeVisitActionCount' => $this->ActionCount($OfficeProspect, 78),
            'OtherActionCount' => $this->ActionCount($OfficeProspect, 79),
        ];
        $otherActionMax = max($otherAction);
        $otherMediation = [
            'BusinessInvolvementMediation' => $this->OfficeGraphMediationCount($endMonthProspects, 76),
            'OpenRoomMediation' => $this->OfficeGraphMediationCount($endMonthProspects, 77),
            'FreeVisitMediation' => $this->OfficeGraphMediationCount($endMonthProspects, 78),
            'OtherMediation' => $this->OfficeGraphMediationCount($endMonthProspects, 79),
        ];
        $otherRate = [
            'BusinessInvolvementRate' => $this->division($otherMediation['BusinessInvolvementMediation'], $otherAction['BusinessInvolvementActionCount']),
            'OpenRoomRate' => $this->division($otherMediation['OpenRoomMediation'], $otherAction['OpenRoomActionCount']),
            'FreeVisitRate' => $this->division($otherMediation['FreeVisitMediation'], $otherAction['FreeVisitActionCount']),
            'OtherRate' => $this->division($otherMediation['OtherMediation'], $otherAction['OtherActionCount']),
        ];
        $otherRateMax = max($otherRate);
        $other = array_merge($otherAction, $otherMediation, $otherRate);

        $ActionMax = max([$areaActionMax, $companyActionMax, $responseActionMax, $preActionMax, $otherActionMax]);
        $RateMax = max([$areaRateMax, $CompanyRateMax, $responseRateMax, $preRateMax, $otherRateMax]);

        return array_merge(['area' => $area], ['company' => $company], ['response' => $response], ['pre' => $pre], ['other' => $other], ['ActionMax' => $ActionMax], ['RateMax' => $RateMax]);
    }

    //該当事業所の社員のIDを取得
    private function searchUser($request): \Illuminate\Support\Collection
    {
        return User::where('office_master_id', $request->input('office_master_id'))->get();
    }

    //月内Modelを取得
    private function BetweenMonthModel($ModelInstance, $request)
    {
        return $ModelInstance
            ->query()
            ->whereBetween('date' , [$request->input('start_period'), $request->input('end_period')]);
    }

    //全事業所の発生源別の見込み発生数
    private function ActionCount($BetweenMonthProspect, $generating_medium_master_id)
    {
        return $BetweenMonthProspect
            ->where('generating_medium_master_id', $generating_medium_master_id)
            ->count();
    }

    //媒介数のカウント
    private function OfficeGraphMediationCount($ProspectCollection, $generating_medium_master_id): int
    {
        $ProspectCollection = $ProspectCollection->where('generating_medium_master_id', $generating_medium_master_id);
        if($ProspectCollection->isEmpty()) return 0 ;
        $count = 0;
        foreach ($ProspectCollection as $prospect){
            $count += $prospect->prospectActionLogs->count();
        }
        return $count;
    }

    //媒介率の計算
    protected function division($numerator, $denominator)
    {
        if ($numerator == 0 || $denominator == 0) return 0;
        return round($numerator/ $denominator * 100, 1);
    }
}