<?php


namespace App\UseCases\Analysis\YieldReport;


use App\Models\ExcavationBehaviorLog;
use App\Models\Prospect;
use App\Models\ProspectActionLog;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class IndividualAction
{
    public function __invoke($request)
    {

        //月内のExcavationBehaviorLog
        $BetweenMonthExcavationBehaviorLog = ExcavationBehaviorLog::whereBetween('action_date' , [$request->input('start_period'), $request->input('end_period')]);

        //月内のProspectActionLog
        $BetweenMonthProspect = Prospect::whereBetween('date' , [$request->input('start_period'), $request->input('end_period')]);
        $endMonthProspects = Prospect::with(['prospectActionLogs' => function ($q) use($request){
            $q->whereBetween('date' , [$request->input('start_period'), $request->input('end_period')])
                ->where('stage_action_master_id', 4);
        }])->where('date', '<',  $request->input('end_period'));

        //事業所の社員IDを取得
        $pairs = $this->searchPair($request);

        $count = -1;
        //該当事業所の社員毎の追客レポートを取得
        foreach ($pairs->sortBy('area_master_id')->values() as $key => $pair){
            ++$count;
            //UserIdで特定
            $thisProspect = $this->ThisSearchArea($BetweenMonthProspect, $pair);
            $thisEndMonthProspect = $this->ThisSearchArea($endMonthProspects, $pair);
            $ThisExcavationBehaviorLog = $this->ThisSearchUser($BetweenMonthExcavationBehaviorLog,$pair);

            $hat_name = $pair->hat->sei ?? '';
            $user[] = "{$pair->sale->sei}／{$hat_name}";

            //エリア発掘
            //管理人訪問
            $areaVisitActionCount[] = $this->ExcavationBehaviorLogActionCount($ThisExcavationBehaviorLog, 'manager_visit_count');
            $areaVisitOccurrenceCount[] =  $this->ProspectOccurrenceCount($thisProspect, 48);
            $areaVisitMediationCount[] = $this->MediationCount($thisEndMonthProspect, 48);
            $areaVisitRate[] = [
                'x' => $this->division($areaVisitOccurrenceCount[$key], $areaVisitActionCount[$key]),
                'y' => $this->division($areaVisitMediationCount[$key], $areaVisitOccurrenceCount[$key]),
                'label' => "{$pair->sale->sei}/{$hat_name}",
            ];

            //ポストC
            $areaPostActionCount[] = $this->ExcavationBehaviorLogActionCount($ThisExcavationBehaviorLog, 'check_post_count');
            $areaPostOccurrenceCount[] = $this->ProspectOccurrenceCount($thisProspect, 50);
            $areaPostMediationCount[] = $this->MediationCount($thisEndMonthProspect, 50);
            $areaPostRate[] = [
                'x' => $count,
                'y' => $this->division($areaPostMediationCount[$key], $areaPostOccurrenceCount[$key]),
                'label' => "{$pair->sale->sei}/{$hat_name}",
            ];

            //一棟C
            $areaBuildingActionCount[] = $this->ExcavationBehaviorLogActionCount($ThisExcavationBehaviorLog, 'check_building_count');
            $areaBuildingOccurrenceCount[] = $this->ProspectOccurrenceCount($thisProspect, 51);
            $areaBuildingMediationCount[] = $this->MediationCount($thisEndMonthProspect, 51);
            $areaBuildingRate[] = [
                'x' => $this->division($areaBuildingOccurrenceCount[$key], $areaBuildingActionCount[$key]),
                'y' => $this->division($areaBuildingMediationCount[$key], $areaBuildingOccurrenceCount[$key]),
                'label' => "{$pair->sale->sei}/{$hat_name}",
            ];

            //巡回現地情報
            $areaPatrolLocalInformationOccurrenceCount[] = $this->ProspectOccurrenceCount($thisProspect, 52);
            $areaPatrolLocalInformationMediationCount[] = $this->MediationCount($thisEndMonthProspect, 52);
            $areaPatrolLocalInformationRate[] = [
                'x' => $count,
                'y' => $this->division($areaPostMediationCount[$key], $areaPatrolLocalInformationOccurrenceCount[$key]),
                'label' => "{$pair->sale->sei}/{$hat_name}",
            ];

            //DM手まき
            $areaDMActionCount[] = $this->ExcavationBehaviorLogActionCount($ThisExcavationBehaviorLog, 'DM_distribution_count');
            $areaDMOccurrenceCount[] = $this->ProspectOccurrenceCount($thisProspect, 53);
            $areaDMMediationCount[] = $this->MediationCount($thisEndMonthProspect, 53);
            $areaDMRate[] = [
                'x' => $this->division($areaDMOccurrenceCount[$key], $areaDMActionCount[$key]),
                'y' => $this->division($areaDMMediationCount[$key], $areaDMOccurrenceCount[$key]),
                'label' => "{$pair->sale->sei}/{$hat_name}",
            ];

            //チラシ手まき
            $areaFlyerActionCount[] = $this->ExcavationBehaviorLogActionCount($ThisExcavationBehaviorLog, 'flyer_distribution_count');
            $areaFlyerOccurrenceCount[] = $this->ProspectOccurrenceCount($thisProspect, 54);
            $areaFlyerMediationCount[] = $this->MediationCount($thisEndMonthProspect, 54);
            $areaFlyerRate[] = [
                'x' => $this->division($areaFlyerOccurrenceCount[$key], $areaFlyerActionCount[$key]),
                'y' => $this->division($areaFlyerMediationCount[$key], $areaFlyerOccurrenceCount[$key]),
                'label' => "{$pair->sale->sei}/{$hat_name}",
            ];

            //限定手紙・封書手まき
            $areaLetterActionCount[] = $this->ExcavationBehaviorLogActionCount($ThisExcavationBehaviorLog, 'letter_distribution_count');
            $areaLetterOccurrenceCount[] = $this->ProspectOccurrenceCount($thisProspect, 55);
            $areaLetterMediationCount[] = $this->MediationCount($thisEndMonthProspect, 55);
            $areaLetterRate[] = [
                'x' => $this->division($areaLetterOccurrenceCount[$key], $areaLetterActionCount[$key]),
                'y' => $this->division($areaLetterMediationCount[$key], $areaLetterOccurrenceCount[$key]),
                'label' => "{$pair->sale->sei}/{$hat_name}",
            ];

            //ランダム戸別訪問
            $areaRandomVisitActionCount[] = $this->ExcavationBehaviorLogActionCount($ThisExcavationBehaviorLog, 'random_visit_implementation_count');
            $areaRandomVisitOccurrenceCount[] = $this->ProspectOccurrenceCount($thisProspect, 56);
            $areaRandomVisitMediationCount[] = $this->MediationCount($thisEndMonthProspect, 56);
            $areaRandomVisitRate[] = [
                'x' => $this->division($areaRandomVisitOccurrenceCount[$key], $areaRandomVisitActionCount[$key]),
                'y' => $this->division($areaRandomVisitMediationCount[$key], $areaRandomVisitOccurrenceCount[$key]),
                'label' => "{$pair->sale->sei}/{$hat_name}",
            ];

            //社内発掘
            //管理人TEL
            $companyCaretakerTELActionCount[] = $this->ExcavationBehaviorLogActionCount($ThisExcavationBehaviorLog, 'manager_TEL_count');
            $companyCaretakerTELOccurrenceCount[] = $this->ProspectOccurrenceCount($thisProspect, 57);
            $companyCaretakerTELMediationCount[] = $this->MediationCount($thisEndMonthProspect, 57);
            $companyCaretakerTELRate[] = [
                'x' => $this->division($companyCaretakerTELOccurrenceCount[$key], $companyCaretakerTELActionCount[$key]),
                'y' => $this->division($companyCaretakerTELMediationCount[$key], $companyCaretakerTELOccurrenceCount[$key]),
                'label' => "{$pair->sale->sei}/{$hat_name}",
            ];

            //個別TEL
            $companyIndividualTELActionCount[] = $this->ExcavationBehaviorLogActionCount($ThisExcavationBehaviorLog, 'personal_TEL_count');
            $companyIndividualTELOccurrenceCount[] = $this->ProspectOccurrenceCount($thisProspect, 58);
            $companyIndividualTELMediationCount[] = $this->MediationCount($thisEndMonthProspect, 58);
            $companyIndividualTELRate[] = [
                'x' => $this->division($companyIndividualTELOccurrenceCount[$key], $companyIndividualTELActionCount[$key]),
                'y' => $this->division($companyIndividualTELMediationCount[$key], $companyIndividualTELOccurrenceCount[$key]),
                'label' => "{$pair->sale->sei}/{$hat_name}",
            ];

            //ランダムTEL
            $companyRandomTELActionCount[] = $this->ExcavationBehaviorLogActionCount($ThisExcavationBehaviorLog, 'random_TEL_implementation_count');
            $companyRandomTELOccurrenceCount[] = $this->ProspectOccurrenceCount($thisProspect, 59);
            $companyRandomTELMediationCount[] = $this->MediationCount($thisEndMonthProspect, 59);
            $companyRandomTELRate[] = [
                'x' => $this->division($companyRandomTELOccurrenceCount[$key], $companyRandomTELActionCount[$key]),
                'y' => $this->division($companyRandomTELMediationCount[$key], $companyRandomTELOccurrenceCount[$key]),
                'label' => "{$pair->sale->sei}/{$hat_name}",
            ];

            //DM郵送
            $companyDMActionCount[] = $this->ExcavationBehaviorLogActionCount($ThisExcavationBehaviorLog, 'DM_mail_count');
            $companyDMOccurrenceCount[] = $this->ProspectOccurrenceCount($thisProspect, 60);
            $companyDMMediationCount[] = $this->MediationCount($thisEndMonthProspect, 60);
            $companyDMRate[] = [
                'x' => $this->division($companyDMOccurrenceCount[$key], $companyDMActionCount[$key]),
                'y' => $this->division($companyDMMediationCount[$key], $companyDMOccurrenceCount[$key]),
                'label' => "{$pair->sale->sei}/{$hat_name}",
            ];

            //手紙、郵送
            $companyLetterActionCount[] = $this->ExcavationBehaviorLogActionCount($ThisExcavationBehaviorLog, 'mail_letter_count');
            $companyLetterOccurrenceCount[] = $this->ProspectOccurrenceCount($thisProspect, 61);
            $companyLetterMediationCount[] = $this->MediationCount($thisEndMonthProspect, 61);
            $companyLetterRate[] = [
                'x' => $this->division($companyLetterOccurrenceCount[$key], $companyLetterActionCount[$key]),
                'y' => $this->division($companyLetterMediationCount[$key], $companyLetterOccurrenceCount[$key]),
                'label' => "{$pair->sale->sei}/{$hat_name}",
            ];

            //チラシ
            $companyFlyerActionCount[] = $this->ExcavationBehaviorLogActionCount($ThisExcavationBehaviorLog, 'flyer_delivery_count');
            $companyFlyerOccurrenceCount[] = $this->ProspectOccurrenceCount($thisProspect, 62);
            $companyFlyerMediationCount[] = $this->MediationCount($thisEndMonthProspect, 62);
            $companyFlyerRate[] = [
                'x' => $this->division($companyFlyerOccurrenceCount[$key], $companyFlyerActionCount[$key]),
                'y' => $this->division($companyFlyerMediationCount[$key], $companyFlyerOccurrenceCount[$key]),
                'label' => "{$pair->sale->sei}/{$hat_name}",
            ];

            //郵送物戻
            $companyReturnToMailOccurrenceCount[] = $this->ProspectOccurrenceCount($thisProspect, 63);
            $companyReturnToMailMediationCount[] = $this->MediationCount($thisEndMonthProspect, 63);
            $companyReturnToMailRate[] = [
                'x' => $count,
                'y' => $this->division($companyReturnToMailMediationCount[$key], $companyReturnToMailOccurrenceCount[$key]),
                'label' => "{$pair->sale->sei}/{$hat_name}",
            ];

            //賃貸情報
            $companyRentalInformationOccurrenceCount[] = $this->ProspectOccurrenceCount($thisProspect, 64);
            $companyRentalInformationMediationCount[] = $this->MediationCount($thisEndMonthProspect, 64);
            $companyRentalInformationRate[] = [
                'x' => $count,
                'y' => $this->division($companyRentalInformationMediationCount[$key], $companyRentalInformationOccurrenceCount[$key]),
                'label' => "{$pair->sale->sei}/{$hat_name}",
            ];

            //登記情報
            $companyRegistrationInformationOccurrenceCount[] = $this->ProspectOccurrenceCount($thisProspect, 65);
            $companyRegistrationInformationMediationCount[] = $this->MediationCount($thisEndMonthProspect, 65);
            $companyRegistrationInformationRate[] = [
                'x' => $count,
                'y' => $this->division($companyRegistrationInformationMediationCount[$key], $companyRegistrationInformationOccurrenceCount[$key]),
                'label' => "{$pair->sale->sei}/{$hat_name}",
            ];

            //建築確認情報
            $companyBuildingInformationOccurrenceCount[] = $this->ProspectOccurrenceCount($thisProspect, 66);
            $companyBuildingInformationMediationCount[] = $this->MediationCount($thisEndMonthProspect, 66);
            $companyBuildingInformationRate[] = [
                'x' => $count,
                'y' => $this->division($companyBuildingInformationMediationCount[$key], $companyBuildingInformationOccurrenceCount[$key]),
                'label' => "{$pair->sale->sei}/{$hat_name}",
            ];

            //反響
            //当社HP
            $reHpOccurrenceCount[] = $this->ProspectOccurrenceCount($thisProspect, 67);
            $reHpMediationCount[] = $this->MediationCount($thisEndMonthProspect, 67);
            $reHpRate[] = [
                'x' => $count,
                'y' => $this->division($reHpMediationCount[$key], $reHpOccurrenceCount[$key]),
                'label' => "{$pair->sale->sei}/{$hat_name}",
            ];

            //一括査定サイト
            $reSiteOccurrenceCount[] = $this->ProspectOccurrenceCount($thisProspect, 68);
            $reSiteMediationCount[] = $this->MediationCount($thisEndMonthProspect, 68);
            $reSiteRate[] = [
                'x' => $count,
                'y' => $this->division($reSiteMediationCount[$key], $reSiteOccurrenceCount[$key]),
                'label' => "{$pair->sale->sei}/{$hat_name}",
            ];


            //他営業所紹介
            $reOtherSalesOfficeOccurrenceCount[] = $this->ProspectOccurrenceCount($thisProspect, 69);
            $reOtherSalesOfficeMediationCount[] = $this->MediationCount($thisEndMonthProspect, 69);
            $reOtherSalesOfficeRate[] = [
                'x' => $count,
                'y' => $this->division($reOtherSalesOfficeMediationCount[$key], $reOtherSalesOfficeOccurrenceCount[$key]),
                'label' => "{$pair->sale->sei}/{$hat_name}",
            ];

            //他グループ会社紹介
            $reOtherGroupCompanyOccurrenceCount[] = $this->ProspectOccurrenceCount($thisProspect, 70);
            $reOtherGroupCompanyMediationCount[] = $this->MediationCount($thisEndMonthProspect, 70);
            $reOtherGroupCompanyRate[] = [
                'x' => $count,
                'y' => $this->division($reOtherGroupCompanyMediationCount[$key], $reOtherGroupCompanyOccurrenceCount[$key]),
                'label' => "{$pair->sale->sei}/{$hat_name}",
            ];

            //前取
            //前取訪問
            $preVisitActionCount[] = $this->ExcavationBehaviorLogActionCount($ThisExcavationBehaviorLog, 'pre_visit_preliminary_count');
            $preVisitOccurrenceCount[] = $this->ProspectOccurrenceCount($thisProspect, 71);
            $preVisitMediationCount[] = $this->MediationCount($thisEndMonthProspect, 71);
            $preVisitRate[] = [
                'x' => $this->division($preVisitOccurrenceCount[$key], $preVisitActionCount[$key]),
                'y' => $this->division($preVisitMediationCount[$key], $preVisitOccurrenceCount[$key]),
                'label' => "{$pair->sale->sei}/{$hat_name}",
            ];

            //前取TEL
            $preTELActionCount[] = $this->ExcavationBehaviorLogActionCount($ThisExcavationBehaviorLog, 'pre_TEL_home_count');
            $preTELOccurrenceCount[] = $this->ProspectOccurrenceCount($thisProspect, 72);
            $preTELMediationCount[] = $this->MediationCount($thisEndMonthProspect, 72);
            $preTELRate[] = [
                'x' => $this->division($preTELOccurrenceCount[$key], $preTELActionCount[$key]),
                'y' => $this->division($preTELMediationCount[$key], $preTELOccurrenceCount[$key]),
                'label' => "{$pair->sale->sei}/{$hat_name}",
            ];

            //前取自己発見
            $preSelfDiscoveryOccurrenceCount[] = $this->ProspectOccurrenceCount($thisProspect, 73);
            $preSelfDiscoveryMediationCount[] = $this->MediationCount($thisEndMonthProspect, 73);
            $preSelfDiscoveryRate[] = [
                'x' => $count,
                'y' => $this->division($preSelfDiscoveryMediationCount[$key], $preSelfDiscoveryOccurrenceCount[$key]),
                'label' => "{$pair->sale->sei}/{$hat_name}",
            ];

            //前取反響
            $preReOccurrenceCount[] = $this->ProspectOccurrenceCount($thisProspect, 74);
            $preREMediationCount[] = $this->MediationCount($thisEndMonthProspect, 74);
            $preRERate[] = [
                'x' => $count,
                'y' => $this->division($preREMediationCount[$key], $preReOccurrenceCount[$key]),
                'label' => "{$pair->sale->sei}/{$hat_name}",
            ];

            //前取その他
            $preOtherOccurrenceCount[] = $this->ProspectOccurrenceCount($thisProspect, 75);
            $preOtherMediationCount[] = $this->MediationCount($thisEndMonthProspect, 75);
            $preOtherRate[] = [
                'x' => $count,
                'y' => $this->division($preOtherMediationCount[$key], $preOtherOccurrenceCount[$key]),
                'label' => "{$pair->sale->sei}/{$hat_name}",
            ];


            //その他
            //業者関与
            $otherBusinessInvolvementOccurrenceCount[] = $this->ProspectOccurrenceCount($thisProspect, 76);
            $otherBusinessInvolvementMediationCount[] = $this->MediationCount($thisEndMonthProspect, 76);
            $otherBusinessInvolvementRate[] = [
                'x' => $count,
                'y' => $this->division($otherBusinessInvolvementMediationCount[$key], $otherBusinessInvolvementOccurrenceCount[$key]),
                'label' => "{$pair->sale->sei}/{$hat_name}",
            ];

            //オープンルーム
            $otherOpenRoomOccurrenceCount[] = $this->ProspectOccurrenceCount($thisProspect, 77);
            $otherOpenRoomMediationCount[] = $this->MediationCount($thisEndMonthProspect, 77);
            $otherOpenRoomRate[] = [
                'x' => $count,
                'y' => $this->division($otherOpenRoomMediationCount[$key], $otherOpenRoomOccurrenceCount[$key]),
                'label' => "{$pair->sale->sei}/{$hat_name}",
            ];

            //フリー来社
            $otherFreeVisitOccurrenceCount[] = $this->ProspectOccurrenceCount($thisProspect, 78);
            $otherFreeVisitMediationCount[] = $this->MediationCount($thisEndMonthProspect, 78);
            $otherFreeVisitRate[] = [
                'x' => $count,
                'y' => $this->division($otherFreeVisitMediationCount[$key], $otherFreeVisitOccurrenceCount[$key]),
                'label' => "{$pair->sale->sei}/{$hat_name}",
            ];

            //その他
            $otherOtherOccurrenceCount[] = $this->ProspectOccurrenceCount($thisProspect, 79);
            $otherOtherMediationCount[] = $this->MediationCount($thisEndMonthProspect, 79);
            $otherOtherRate[] = [
                'x' => $count,
                'y' => $this->division($otherOtherMediationCount[$key], $otherOtherOccurrenceCount[$key]),
                'label' => "{$pair->sale->sei}/{$hat_name}",
            ];
        }

        $analysisData['area']['visit']['bar'] = array_merge(
            ['user' => $user],
            ['ActionCount' => $areaVisitActionCount],
            ['OccurrenceCount' => $areaVisitOccurrenceCount],
            ['MediationCount' => $areaVisitMediationCount]
        );
        $analysisData['area']['visit']['rate'] = $areaVisitRate;

        $analysisData['area']['post']['bar'] = array_merge(
            ['user' => $user],
            ['OccurrenceCount' => $areaPostOccurrenceCount],
            ['MediationCount' => $areaPostMediationCount]
        );
        $analysisData['area']['post']['rate'] = $areaPostRate;

        $analysisData['area']['building']['bar'] = array_merge(
            ['user' => $user],
            ['ActionCount' => $areaBuildingActionCount],
            ['OccurrenceCount' => $areaBuildingOccurrenceCount],
            ['MediationCount' => $areaBuildingMediationCount]
        );
        $analysisData['area']['building']['rate'] = $areaBuildingRate;

        $analysisData['area']['PatrolLocalInformation']['bar'] = array_merge(
            ['user' => $user],
            ['OccurrenceCount' => $areaPatrolLocalInformationOccurrenceCount],
            ['MediationCount' => $areaPatrolLocalInformationMediationCount]
        );
        $analysisData['area']['PatrolLocalInformation']['rate'] = $areaPatrolLocalInformationRate;

        $analysisData['area']['DM']['bar'] = array_merge(
            ['user' => $user],
            ['ActionCount' => $areaDMActionCount],
            ['OccurrenceCount' => $areaDMOccurrenceCount],
            ['MediationCount' => $areaDMMediationCount]
        );
        $analysisData['area']['DM']['rate'] = $areaDMRate;

        $analysisData['area']['flyer']['bar'] = array_merge(
            ['user' => $user],
            ['ActionCount' => $areaFlyerActionCount],
            ['OccurrenceCount' => $areaFlyerOccurrenceCount],
            ['MediationCount' => $areaFlyerMediationCount]
        );
        $analysisData['area']['flyer']['rate'] = $areaFlyerRate;

        $analysisData['area']['letter']['bar'] = array_merge(
            ['user' => $user],
            ['ActionCount' => $areaLetterActionCount],
            ['OccurrenceCount' => $areaLetterOccurrenceCount],
            ['MediationCount' => $areaLetterMediationCount]
        );
        $analysisData['area']['letter']['rate'] = $areaLetterRate;

        $analysisData['area']['randomVisit']['bar'] = array_merge(
            ['user' => $user],
            ['ActionCount' => $areaRandomVisitActionCount],
            ['OccurrenceCount' => $areaRandomVisitOccurrenceCount],
            ['MediationCount' => $areaRandomVisitMediationCount]
        );
        $analysisData['area']['randomVisit']['rate'] = $areaRandomVisitRate;

        $analysisData['company']['caretakerTEL']['bar'] = array_merge(
            ['user' => $user],
            ['ActionCount' => $companyCaretakerTELActionCount],
            ['OccurrenceCount' => $companyCaretakerTELOccurrenceCount],
            ['MediationCount' => $companyCaretakerTELMediationCount]
        );
        $analysisData['company']['caretakerTEL']['rate'] = $companyCaretakerTELRate;

        $analysisData['company']['individualTEL']['bar'] = array_merge(
            ['user' => $user],
            ['ActionCount' => $companyIndividualTELActionCount],
            ['OccurrenceCount' => $companyIndividualTELOccurrenceCount],
            ['MediationCount' => $companyIndividualTELMediationCount]
        );
        $analysisData['company']['individualTEL']['rate'] = $companyIndividualTELRate;

        $analysisData['company']['randomTEL']['bar'] = array_merge(
            ['user' => $user],
            ['ActionCount' => $companyRandomTELActionCount],
            ['OccurrenceCount' => $companyRandomTELOccurrenceCount],
            ['MediationCount' => $companyRandomTELMediationCount]
        );
        $analysisData['company']['randomTEL']['rate'] = $companyRandomTELRate;

        $analysisData['company']['DM']['bar'] = array_merge(
            ['user' => $user],
            ['ActionCount' => $companyDMActionCount],
            ['OccurrenceCount' => $companyDMOccurrenceCount],
            ['MediationCount' => $companyDMMediationCount]
        );
        $analysisData['company']['DM']['rate'] = $companyDMRate;

        $analysisData['company']['letter']['bar'] = array_merge(
            ['user' => $user],
            ['ActionCount' => $companyLetterActionCount],
            ['OccurrenceCount' => $companyLetterOccurrenceCount],
            ['MediationCount' => $companyLetterMediationCount]
        );
        $analysisData['company']['letter']['rate'] = $companyLetterRate;

        $analysisData['company']['flyer']['bar'] = array_merge(
            ['user' => $user],
            ['ActionCount' => $companyFlyerActionCount],
            ['OccurrenceCount' => $companyFlyerOccurrenceCount],
            ['MediationCount' => $companyFlyerMediationCount]
        );
        $analysisData['company']['flyer']['rate'] = $companyFlyerRate;

        $analysisData['company']['returnToMail']['bar'] = array_merge(
            ['user' => $user],
            ['OccurrenceCount' => $companyReturnToMailOccurrenceCount],
            ['MediationCount' => $companyReturnToMailMediationCount]
        );
        $analysisData['company']['returnToMail']['rate'] = $companyReturnToMailRate;

        $analysisData['company']['rentalInformation']['bar'] = array_merge(
            ['user' => $user],
            ['OccurrenceCount' => $companyRentalInformationOccurrenceCount],
            ['MediationCount' => $companyRentalInformationMediationCount]
        );
        $analysisData['company']['rentalInformation']['rate'] = $companyRentalInformationRate;


        $analysisData['company']['registerInformation']['bar'] = array_merge(
            ['user' => $user],
            ['OccurrenceCount' => $companyRegistrationInformationOccurrenceCount],
            ['MediationCount' => $companyRegistrationInformationMediationCount]
        );
        $analysisData['company']['registerInformation']['rate'] = $companyRegistrationInformationRate;

        $analysisData['company']['buildingInformation']['bar'] = array_merge(
            ['user' => $user],
            ['OccurrenceCount' => $companyBuildingInformationOccurrenceCount],
            ['MediationCount' => $companyBuildingInformationMediationCount]
        );
        $analysisData['company']['buildingInformation']['rate'] = $companyBuildingInformationRate;

        $analysisData['re']['hp']['bar'] = array_merge(
            ['user' => $user],
            ['OccurrenceCount' => $reHpOccurrenceCount],
            ['MediationCount' => $reHpMediationCount]
        );
        $analysisData['re']['hp']['rate'] = $reHpRate;

        $analysisData['re']['site']['bar'] = array_merge(
            ['user' => $user],
            ['OccurrenceCount' => $reSiteOccurrenceCount],
            ['MediationCount' => $reSiteMediationCount]
        );
        $analysisData['re']['site']['rate'] = $reSiteRate;

        $analysisData['re']['otherSalesOffice']['bar'] = array_merge(
            ['user' => $user],
            ['OccurrenceCount' => $reOtherSalesOfficeOccurrenceCount],
            ['MediationCount' => $reOtherSalesOfficeMediationCount]
        );
        $analysisData['re']['otherSalesOffice']['rate'] = $reOtherSalesOfficeRate;

        $analysisData['re']['otherGroupCompany']['bar'] = array_merge(
            ['user' => $user],
            ['OccurrenceCount' => $reOtherGroupCompanyOccurrenceCount],
            ['MediationCount' => $reOtherGroupCompanyMediationCount]
        );
        $analysisData['re']['otherGroupCompany']['rate'] = $reOtherGroupCompanyRate;

        $analysisData['pre']['visit']['bar'] = array_merge(
            ['user' => $user],
            ['ActionCount' => $preVisitActionCount],
            ['OccurrenceCount' => $preVisitOccurrenceCount],
            ['MediationCount' => $preVisitMediationCount]
        );
        $analysisData['pre']['visit']['rate'] = $preVisitRate;

        $analysisData['pre']['tel']['bar'] = array_merge(
            ['user' => $user],
            ['ActionCount' => $preTELActionCount],
            ['OccurrenceCount' => $preTELOccurrenceCount],
            ['MediationCount' => $preTELMediationCount]
        );
        $analysisData['pre']['tel']['rate'] = $preTELRate;

        $analysisData['pre']['selfDiscovery']['bar'] = array_merge(
            ['user' => $user],
            ['OccurrenceCount' => $preSelfDiscoveryOccurrenceCount],
            ['MediationCount' => $preSelfDiscoveryMediationCount]
        );
        $analysisData['pre']['selfDiscovery']['rate'] = $preSelfDiscoveryRate;

        $analysisData['pre']['other']['bar'] = array_merge(
            ['user' => $user],
            ['OccurrenceCount' => $preOtherOccurrenceCount],
            ['MediationCount' => $preOtherMediationCount]
        );
        $analysisData['pre']['other']['rate'] = $preOtherRate;

        $analysisData['pre']['re']['bar'] = array_merge(
            ['user' => $user],
            ['OccurrenceCount' => $preReOccurrenceCount],
            ['MediationCount' => $preREMediationCount]
        );
        $analysisData['pre']['re']['rate'] = $preRERate;

        $analysisData['other']['businessInvolvement']['bar'] = array_merge(
            ['user' => $user],
            ['OccurrenceCount' => $otherBusinessInvolvementOccurrenceCount],
            ['MediationCount' => $otherBusinessInvolvementMediationCount]
        );
        $analysisData['other']['businessInvolvement']['rate'] = $otherBusinessInvolvementRate;

        $analysisData['other']['openRoom']['bar'] = array_merge(
            ['user' => $user],
            ['OccurrenceCount' => $otherOpenRoomOccurrenceCount],
            ['MediationCount' => $otherBusinessInvolvementMediationCount]
        );
        $analysisData['other']['openRoom']['rate'] = $otherOpenRoomRate;

        $analysisData['other']['freeVisit']['bar'] = array_merge(
            ['user' => $user],
            ['OccurrenceCount' => $otherFreeVisitOccurrenceCount],
            ['MediationCount' => $otherFreeVisitMediationCount]
        );
        $analysisData['other']['freeVisit']['rate'] = $otherFreeVisitRate;

        $analysisData['other']['other']['bar'] = array_merge(
            ['user' => $user],
            ['OccurrenceCount' => $otherOtherOccurrenceCount],
            ['MediationCount' => $otherOtherMediationCount]
        );
        $analysisData['other']['other']['rate'] = $otherOtherRate;

        return $analysisData;
    }

    //該当事業所の社員のIDを取得
    private function searchPair($request): \Illuminate\Support\Collection
    {
        return Team::where('office_master_id', $request->input('office_master_id'))->get();
    }

    //月初時点でのProspectActionLogを取得
    private function StartMonthProspectActionLog($request)
    {
        return ProspectActionLog::query()
            ->where('created_at' , '<=', $request->input('start_period'));
    }

    //月内Modelを取得
    private function fetchMonthModelInPeriod($ModelInstance, $request)
    {
        return $ModelInstance
            ->query()
            ->whereBetween('created_at' , [$request->input('start_period'), $request->input('end_period')]);
    }

    //全事業所の発生源別の見込み発生数
    private function ActionCount($BetweenMonthProspect, $generating_medium_master_id)
    {
        return $BetweenMonthProspect
            ->where('generating_medium_master_id', $generating_medium_master_id)
            ->count();
    }

    protected function ThisSearchArea($ModelInstance, $pair)
    {
        return $ModelInstance->get()->where('office_master_id', $pair->office_master_id)->where('area_master_id', $pair->area_master_id);
    }

    protected function ThisSearchUser($ModelInstance, $pair)
    {
        return $ModelInstance->get()->where('office_master_id', $pair->office_master_id)->where('area_master_id', $pair->area_master_id);
    }

    private function ExcavationBehaviorLogActionCount($BetweenMonthExcavationBehaviorLog, $target_column)
    {
        return $BetweenMonthExcavationBehaviorLog
            ->sum($target_column);
    }

    private function ProspectOccurrenceCount($BetweenMonthProspect, $generating_medium_master_id)
    {
        return $BetweenMonthProspect
            ->where('generating_medium_master_id', $generating_medium_master_id)
            ->count();
    }

    private function MediationCount($ProspectCollection, $generating_medium_master_id)
    {
        $ProspectCollection = $ProspectCollection->where('generating_medium_master_id', $generating_medium_master_id);
        if($ProspectCollection->isEmpty()) return 0 ;
        $count = 0;
        foreach ($ProspectCollection as $prospect){
            $count += $prospect->prospectActionLogs->count();
        }
        return $count;
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
    protected function division($numer, $denom)
    {
        if ($numer == 0 || $denom == 0) return 0;
        return round($numer/ $denom * 100, 1);
    }
}
