<?php


namespace App\UseCases\Analysis;

use App\Models\ActionMaster;
use App\Models\Team;
use App\Models\UserMaster;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Prospect;
use App\Models\ExcavationBehaviorLog;
use phpDocumentor\Reflection\Types\Collection;

class ExactionReportAction
{
    public function __invoke($request):array
    {
        $prospect = new Prospect;

        //デフォルト画面でログインユーザーの事業所を表示するために
        if (empty($request->input('office_master_id'))){
            $request = $request->merge([
                'office_master_id' => Auth::user()->office_master_id
            ]);
        }

        //デフォルトで当月初
        if (empty($request->input('start_period'))){
            $request = $request->merge([
                'start_period' => Carbon::now()->startOfMonth()
            ]);
        }else{
            $month = $request->input('start_period');
            $request = $request->merge(['start_period' => Carbon::parse("${month}-01 00:00:00")]);
        }

        //デフォルトで当月末
        if (empty($request->input('end_period'))){
            $request = $request->merge([
                'end_period' => Carbon::now()->endOfMonth()
            ]);
        }else{
            $month = $request->input('end_period');
            $request = $request->merge(['end_period' => Carbon::parse("${month}-01 00:00:00")->endOfMonth()]);
        }

        //事業所の社員IDを取得
        $pairs = $this->searchPair($request);
        //該当期間のProspect
        $TargetMonthProspect = $this->TargetMonthModel($prospect, $request);
        //該当期間のExcavationBehaviorLog
        $TargetExcavationBehaviorLog = ExcavationBehaviorLog::whereBetween('action_date' , [$request->input('start_period'), $request->input('end_period')])->get();

        foreach ($pairs->sortBy('area_master_id')->values() as $index => $pair){
            unset($person, $area, $company);

            //pair円グラフ用
            $ThisProspect = $this->ThisSearchArea($TargetMonthProspect, $pair);
            $ThisExcavationBehaviorLog = $this->ThisSearchUser($TargetExcavationBehaviorLog, $pair);
            $hat_name = $pair->hat->sei ?? '';
            $person = [
                'user_name' => "{$pair->sale->sei}/{$hat_name}",
            ];

            //エリア発掘/発生媒体
            $area = $this->generateGraphArea($ThisProspect);
            $areaTotal = $area['CaretakerVisitActiveCount'] + $area['PersonalVisitActiveCount'] + $area['PostCheckActiveCount'] + $area['CheckTheBuildingActiveCount'] + $area['PatrolLocalInformationActiveCount'] + $area['DMActiveCount'] + $area['FlyerActiveCount'] + $area['LatterActiveCount'] + $area['RandomActiveCount'];
            $area += ['areaTotal' => $areaTotal];

            //社内発掘/発生媒体
            $company = $this->generateGraphCompany($ThisProspect);
            $companyTotal = $company['CaretakerTelActiveCount'] + $company['PersonalTelActiveCount'] + $company['RandomTelActiveCount'] + $company['LatterActiveCount'] + $company['FlyerActiveCount'] + $company['DMActiveCount'] + $company['ReturnByMailActiveCount'] + $company['RentalInformationActiveCount'] + $company['RegistrationInformationActiveCount'] + $company['BuildingConfirmationInformationActiveCount'];
            $company += ['companyTotal' => $companyTotal];

            //前取発掘/発生媒体
            $pre = $this->generateGraphPre($ThisProspect);
            $preTotal = $pre['PreVisitActiveCount'] + $pre['PreTelActiveCount'] + $pre['PreSelfDiscoveryActiveCount'] + $pre['PreResponseActiveCount'] + $pre['PreOtherActiveCount'];
            $pre += ['preTotal' => $preTotal];

            //反響発生媒体
            $re = $this->generateGraphRe($ThisProspect);
            $reTotal = $re['hpActiveCount'] + $re['siteActiveCount'] + $re['otherSalesOfficeActiveCount'] + $re['otherGroupsActiveCount'];
            $re += ['reTotal' => $reTotal];

            //その他発生媒体
            $other = $this->generateGraphOther($ThisProspect);
            $otherTotal = $other['contractorInvolvementActiveCount'] + $other['openRoomActiveCount'] + $other['freeVisitActiveCount'] + $other['otherActiveCount'];
            $other += ['otherTotal' => $otherTotal];

            $totalCount = $areaTotal + $companyTotal + $preTotal + $reTotal + $otherTotal;
            $analysisData['graph'][] = array_merge(['person' => $person], ['area' => $area], ['company' => $company], ['pre' => $pre], ['re' => $re], ['other' => $other], ['total' => $totalCount]);

            //sales用の配列作成
            $ThisSaleProspect = $TargetMonthProspect->where('office_master_id', $pair->office_master_id)->where('area_master_id', $pair->area_master_id)->where('input_person', $pair?->sale?->status_id);
            $ThisPairExcavationBehaviorLog = $TargetExcavationBehaviorLog->where('office_master_id', $pair->office_master_id)->where('area_master_id', $pair->area_master_id);
            $ThisSaleExcavationBehaviorLog = $TargetExcavationBehaviorLog->where('office_master_id', $pair->office_master_id)->where('area_master_id', $pair->area_master_id)->where('status_id', 1);
            $area_name = ActionMaster::find($pair->area_master_id)->action_name;
            $salePerson = [
                'user_name' => $pair->sale->sei,
            ];

            //エリア発掘/発生媒体
            $saleArea = $this->generateSaleArea($ThisSaleExcavationBehaviorLog, $ThisSaleProspect, $ThisExcavationBehaviorLog, $ThisProspect, $ThisPairExcavationBehaviorLog);
            //社内発掘/発生媒体
            $saleCompany = $this->generateSaleCompany($ThisSaleExcavationBehaviorLog, $ThisSaleProspect, $ThisExcavationBehaviorLog, $ThisProspect, $ThisPairExcavationBehaviorLog);
            //前取発掘/発生媒体
            $salePre = $this->generateSalePre($ThisSaleExcavationBehaviorLog, $ThisSaleProspect, $ThisExcavationBehaviorLog, $ThisProspect, $ThisPairExcavationBehaviorLog);
            //反響発生媒体
            $saleRe = $this->generateSaleRe($ThisSaleProspect, $ThisProspect, );
            //その他発生媒体
            $saleOther = $this->generateSaleOther($ThisSaleProspect, $ThisProspect);

            $analysisData['user'][$index]['sale'] = array_merge(['area_name' => $area_name],['person' => $salePerson], ['area' => $saleArea], ['company' => $saleCompany], ['pre' => $salePre], ['re' => $saleRe], ['other' => $saleOther]);

            //hat
            $ThishatProspect = $TargetMonthProspect->where('office_master_id', $pair->office_master_id)->where('area_master_id', $pair->area_master_id)->where('input_person', 2);
            $ThishatExcavationBehaviorLog = $TargetExcavationBehaviorLog->where('office_master_id', $pair->office_master_id)->where('area_master_id', $pair->area_master_id)->where('status_id', 2);
            $hatPerson = [
                'user_name' => $hat_name,
            ];
            //エリア発掘/発生媒体
            $hatArea = $this->generatehatArea($ThishatExcavationBehaviorLog, $ThishatProspect);
            //社内発掘/発生媒体
            $hatCompany = $this->generatehatCompany($ThishatExcavationBehaviorLog, $ThishatProspect);
            //前取発掘/発生媒体
            $hatPre = $this->generatehatPre($ThishatExcavationBehaviorLog, $ThishatProspect);
            //反響発生媒体
            $hatRe = $this->generatehatRe($ThishatProspect);
            //その他発生媒体
            $hatOther = $this->generatehatOther($ThishatProspect);

            $analysisData['user'][$index]['hat'] = array_merge(['person' => $hatPerson], ['area' => $hatArea], ['company' => $hatCompany], ['pre' => $hatPre], ['re' => $hatRe], ['other' => $hatOther]);
        }

        //円グラフ用の営業所トータル
        $office = $this->OfficeTotal($analysisData, $request);
        $office += ['total' => $office['area']['areaTotal'] + $office['company']['companyTotal'] + $office['pre']['preTotal'] + $office['re']['reTotal'] + $office['other']['otherTotal']];
        $analysisData['office'] = $office;
        return $analysisData;
    }

    //該当事業所の社員のIDを取得
    protected function searchPair($request): \Illuminate\Support\Collection
    {
        return Team::where('office_master_id', $request->input('office_master_id'))->get();
    }

    //月時点でのmodelを取得
    protected function TargetMonthModel($ModelInstance, $request)
    {
        return $ModelInstance
            ->query()
            ->whereBetween('date' , [$request->input('start_period'), $request->input('end_period')])
            ->get();
    }

    //該当ユーザーのModelを取得
    private function ThisSearchArea($ModelInstance, $pair)
    {
        return $ModelInstance->where('office_master_id', $pair->office_master_id)->where('area_master_id', $pair->area_master_id);
    }

    //該当ユーザーのModelを取得
    private function ThisSearchUser($ModelInstance, $pair)
    {
        return $ModelInstance->whereIn('user_id', [$pair->sales_id, $pair->hat_id]);
    }

    //該当見込みリストの発生数を取得
    private function CountActive($ThisProspect, $target_id)
    {
        return $ThisProspect
            ->where('generating_medium_master_id', $target_id)
            ->count();
    }

    //発掘の行動数を取得
    private function CountAction($ThisExcavationBehaviorLog, $target_column)
    {
        return $ThisExcavationBehaviorLog
            ->where($target_column, '>=', 1)
            ->sum($target_column);
    }

    // 発掘/見込 = 発生率
    private function RateCalc($ActionCount, $ActiveCount)
    {
        if($ActionCount === 0 || $ActiveCount === 0) return '0%';
        return round($ActiveCount / $ActionCount * 100 , 1).'%';
    }

    //area算出
    private function generateGraphArea($ThisProspect): array
    {
        $area = [
            'CaretakerVisitActiveCount' => $this->CountActive($ThisProspect, 48),
            'PersonalVisitActiveCount' => $this->CountActive($ThisProspect, 49),
            'PostCheckActiveCount' => $this->CountActive($ThisProspect, 50),
            'CheckTheBuildingActiveCount' => $this->CountActive($ThisProspect, 51),
            'PatrolLocalInformationActiveCount' => $this->CountActive($ThisProspect, 52),
            'DMActiveCount' => $this->CountActive($ThisProspect, 53),
            'FlyerActiveCount' => $this->CountActive($ThisProspect, 54),
            'LatterActiveCount' => $this->CountActive($ThisProspect, 55),
            'RandomActiveCount' => $this->CountActive($ThisProspect, 56),
        ];
        return $area;
    }

    //company算出
    private function generateGraphCompany($ThisProspect): array
    {
        $company = [
            'CaretakerTelActiveCount' => $this->CountActive($ThisProspect, 57),
            'PersonalTelActiveCount' => $this->CountActive($ThisProspect, 58),
            'RandomTelActiveCount' => $this->CountActive($ThisProspect, 59),
            'LatterActiveCount' => $this->CountActive($ThisProspect, 61),
            'FlyerActiveCount' => $this->CountActive($ThisProspect, 62),
            'DMActiveCount' => $this->CountActive($ThisProspect, 60),
            'ReturnByMailActiveCount' => $this->CountActive($ThisProspect, 63),
            'RentalInformationActiveCount' => $this->CountActive($ThisProspect, 64),
            'RegistrationInformationActiveCount' => $this->CountActive($ThisProspect, 65),
            'BuildingConfirmationInformationActiveCount' => $this->CountActive($ThisProspect, 66),
        ];
        return $company;
    }

    //前取算出
    private function generateGraphPre($ThisProspect): array
    {
        $pre = [
            'PreVisitActiveCount' => $this->CountActive($ThisProspect, 71),
            'PreTelActiveCount' => $this->CountActive($ThisProspect, 72),
            'PreSelfDiscoveryActiveCount' => $this->CountActive($ThisProspect, 73),
            'PreResponseActiveCount' => $this->CountActive($ThisProspect, 74),
            'PreOtherActiveCount' => $this->CountActive($ThisProspect, 75),
        ];
        return $pre;
    }

    //反響算出
    private function generateGraphRe($ThisProspect): array
    {
        $re = [
            'hpActiveCount' => $this->CountActive($ThisProspect, 67),
            'siteActiveCount' => $this->CountActive($ThisProspect, 68),
            'otherSalesOfficeActiveCount' => $this->CountActive($ThisProspect, 69),
            'otherGroupsActiveCount' => $this->CountActive($ThisProspect, 70),
        ];
        return  $re;
    }

    //その他算出
    private function generateGraphOther($ThisProspect): array
    {
        $other = [
            'contractorInvolvementActiveCount' => $this->CountActive($ThisProspect, 76),
            'openRoomActiveCount' => $this->CountActive($ThisProspect, 77),
            'freeVisitActiveCount' => $this->CountActive($ThisProspect, 78),
            'otherActiveCount' => $this->CountActive($ThisProspect, 79),
        ];
        return  $other;
    }


    //sale用area算出
    private function generateSaleArea($ThisSaleExcavationBehaviorLog, $ThisSaleProspect, $ThisExcavationBehaviorLog, $ThisProspect, $ThisPairExcavationBehaviorLog): array
    {
        $area = [
            'CaretakerVisitActionCount' => $this->CountAction($ThisSaleExcavationBehaviorLog, 'manager_visit_count'),
            'PairCaretakerVisitActionCount' => $this->CountAction($ThisPairExcavationBehaviorLog, 'manager_visit_count'),
            'CaretakerVisitActiveCount' => $this->CountActive($ThisSaleProspect, 48),
            'PairCaretakerVisitActiveCount' => $this->CountActive($ThisProspect, 48),
            'CaretakerVisitRate' => 0,
            'PairCaretakerVisitRate' => 0,
            'PersonalVisitActionCount' => $this->CountAction($ThisSaleExcavationBehaviorLog, 'personal_visit_count'),
            'PairPersonalVisitActionCount' => $this->CountAction($ThisPairExcavationBehaviorLog, 'personal_visit_count'),
            'PersonalVisitActiveCount' => $this->CountActive($ThisSaleProspect, 49),
            'PairPersonalVisitActiveCount' => $this->CountActive($ThisProspect, 49),
            'PersonalVisitRate' => 0,
            'PairPersonalVisitRate' => 0,
            'PostCheckActiveCount' => $this->CountActive($ThisSaleProspect, 50),
            'PairPostCheckActiveCount' => $this->CountActive($ThisProspect, 50),
            'CheckTheBuildingActionCount' => $this->CountAction($ThisSaleExcavationBehaviorLog, 'check_building_count'),
            'PairCheckTheBuildingActionCount' => $this->CountAction($ThisPairExcavationBehaviorLog, 'check_building_count'),
            'CheckTheBuildingActiveCount' => $this->CountActive($ThisSaleProspect, 51),
            'PairCheckTheBuildingActiveCount' => $this->CountActive($ThisProspect, 51),
            'CheckTheBuildingRate' => 0,
            'PairCheckTheBuildingRate' => 0,
            'PatrolLocalInformationActiveCount' => $this->CountActive($ThisSaleProspect, 52),
            'PairPatrolLocalInformationActiveCount' => $this->CountActive($ThisProspect, 52),
            'DMActionCount' =>  $this->CountAction($ThisSaleExcavationBehaviorLog, 'DM_distribution_count'),
            'PairDMActionCount' =>  $this->CountAction($ThisPairExcavationBehaviorLog, 'DM_distribution_count'),
            'DMActiveCount' => $this->CountActive($ThisSaleProspect, 53),
            'PairDMActiveCount' => $this->CountActive($ThisProspect, 53),
            'DMRate' => 0,
            'PairDMRate' => 0,
            'FlyerActionCount' => $this->CountAction($ThisSaleExcavationBehaviorLog, 'flyer_distribution_count'),
            'PairFlyerActionCount' => $this->CountAction($ThisPairExcavationBehaviorLog, 'flyer_distribution_count'),
            'FlyerActiveCount' => $this->CountActive($ThisSaleProspect, 54),
            'PairFlyerActiveCount' => $this->CountActive($ThisProspect, 54),
            'FlyerRate' => 0,
            'PairFlyerRate' => 0,
            'LatterActionCount' => $this->CountAction($ThisSaleExcavationBehaviorLog, 'letter_distribution_count'),
            'PairLatterActionCount' => $this->CountAction($ThisPairExcavationBehaviorLog, 'letter_distribution_count'),
            'LatterActiveCount' => $this->CountActive($ThisSaleProspect, 55),
            'PairLatterActiveCount' => $this->CountActive($ThisProspect, 55),
            'LatterRate' => 0,
            'PairLatterRate' => 0,
            'RandomImplementationCount' => $this->CountAction($ThisSaleExcavationBehaviorLog, 'random_visit_implementation_count'),
            'PairRandomImplementationCount' => $this->CountAction($ThisPairExcavationBehaviorLog, 'random_visit_implementation_count'),
            'RandomActionCount' => $this->CountAction($ThisSaleExcavationBehaviorLog, 'random_visit_at_home_count'),
            'PairRandomActionCount' => $this->CountAction($ThisPairExcavationBehaviorLog, 'random_visit_at_home_count'),
            'RandomActiveCount' => $this->CountActive($ThisSaleProspect, 56),
            'PairRandomActiveCount' => $this->CountActive($ThisProspect, 56),
            'RandomRate' => 0,
            'PairRandomRate' => 0,
        ];

        $area['CaretakerVisitRate'] = $this->RateCalc($area['CaretakerVisitActionCount'], $area['CaretakerVisitActiveCount']);
        $area['PairCaretakerVisitRate'] = $this->RateCalc($area['PairCaretakerVisitActionCount'], $area['PairCaretakerVisitActiveCount']);
        $area['PersonalVisitRate'] = $this->RateCalc($area['PersonalVisitActionCount'], $area['PersonalVisitActiveCount']);
        $area['PairPersonalVisitRate'] = $this->RateCalc($area['PairPersonalVisitActionCount'], $area['PairPersonalVisitActiveCount']);
        $area['CheckTheBuildingRate'] = $this->RateCalc($area['CheckTheBuildingActionCount'], $area['CheckTheBuildingActiveCount']);
        $area['PairCheckTheBuildingRate'] = $this->RateCalc($area['PairCheckTheBuildingActionCount'], $area['PairCheckTheBuildingActiveCount']);
        $area['DMRate'] = $this->RateCalc($area['DMActionCount'], $area['DMActiveCount']);
        $area['PairDMRate'] = $this->RateCalc($area['PairDMActionCount'], $area['PairDMActiveCount']);
        $area['FlyerRate'] = $this->RateCalc($area['FlyerActionCount'], $area['FlyerActiveCount']);
        $area['PairFlyerRate'] = $this->RateCalc($area['PairFlyerActionCount'], $area['PairFlyerActiveCount']);
        $area['LatterRate'] = $this->RateCalc($area['LatterActionCount'], $area['LatterActiveCount']);
        $area['PairLatterRate'] = $this->RateCalc($area['PairLatterActionCount'], $area['PairLatterActiveCount']);
        $area['RandomRate'] = $this->RateCalc($area['RandomActionCount'], $area['RandomActiveCount']);
        $area['PairRandomRate'] = $this->RateCalc($area['PairRandomActionCount'], $area['PairRandomActiveCount']);

        return $area;
    }

    //company算出
    private function generateSaleCompany($ThisSaleExcavationBehaviorLog, $ThisSaleProspect, $ThisExcavationBehaviorLog, $ThisProspect, $ThisPairExcavationBehaviorLog): array
    {
        $company = [
            'CaretakerTelActionCount' => $this->CountAction($ThisSaleExcavationBehaviorLog, 'manager_TEL_count'),
            'PairCaretakerTelActionCount' => $this->CountAction($ThisPairExcavationBehaviorLog, 'manager_TEL_count'),
            'CaretakerTelActiveCount' => $this->CountActive($ThisSaleProspect, 57),
            'PairCaretakerTelActiveCount' => $this->CountActive($ThisProspect, 57),
            'CaretakerTelRate' => 0,
            'PairCaretakerTelRate' => 0,
            'PersonalTelActionCount' => $this->CountAction($ThisSaleExcavationBehaviorLog, 'personal_TEL_count'),
            'PairPersonalTelActionCount' => $this->CountAction($ThisPairExcavationBehaviorLog, 'personal_TEL_count'),
            'PersonalTelActiveCount' => $this->CountActive($ThisSaleProspect, 58),
            'PairPersonalTelActiveCount' => $this->CountActive($ThisProspect, 58),
            'PersonalTelRate' => 0,
            'PairPersonalTelRate' => 0,
            'RandomTelImplementationCount' => $this->CountAction($ThisSaleExcavationBehaviorLog, 'random_TEL_implementation_count'),
            'PairRandomTelImplementationCount' => $this->CountAction($ThisPairExcavationBehaviorLog, 'random_TEL_implementation_count'),
            'RandomTelActionCount' => $this->CountAction($ThisSaleExcavationBehaviorLog, 'random_TEL_at_home_count'),
            'PairRandomTelActionCount' => $this->CountAction($ThisPairExcavationBehaviorLog, 'random_TEL_at_home_count'),
            'RandomTelActiveCount' => $this->CountActive($ThisSaleProspect, 59),
            'PairRandomTelActiveCount' => $this->CountActive($ThisProspect, 59),
            'RandomTelRate' => 0,
            'PairRandomTelRate' => 0,
            'LatterActionCount' => $this->CountAction($ThisSaleExcavationBehaviorLog, 'mail_letter_count'),
            'PairLatterActionCount' => $this->CountAction($ThisPairExcavationBehaviorLog, 'mail_letter_count'),
            'LatterActiveCount' => $this->CountActive($ThisSaleProspect, 61),
            'PairLatterActiveCount' => $this->CountActive($ThisProspect, 61),
            'LatterRate' => 0,
            'PairLatterRate' => 0,
            'FlyerActionCount' => $this->CountAction($ThisSaleExcavationBehaviorLog, 'flyer_delivery_count'),
            'PairFlyerActionCount' => $this->CountAction($ThisPairExcavationBehaviorLog, 'flyer_delivery_count'),
            'FlyerActiveCount' => $this->CountActive($ThisSaleProspect, 62),
            'PairFlyerActiveCount' => $this->CountActive($ThisProspect, 62),
            'FlyerRate' => 0,
            'PairFlyerRate' => 0,
            'DMActionCount' => $this->CountAction($ThisSaleExcavationBehaviorLog, 'DM_mail_count'),
            'PairDMActionCount' => $this->CountAction($ThisPairExcavationBehaviorLog, 'DM_mail_count'),
            'DMActiveCount' => $this->CountActive($ThisSaleProspect, 60),
            'PairDMActiveCount' => $this->CountActive($ThisProspect, 60),
            'DMRate' => 0,
            'PairDMRate' => 0,
            'ReturnByMailActiveCount' => $this->CountActive($ThisSaleProspect, 63),
            'PairReturnByMailActiveCount' => $this->CountActive($ThisProspect, 63),
            'RentalInformationActiveCount' => $this->CountActive($ThisSaleProspect, 64),
            'PairRentalInformationActiveCount' => $this->CountActive($ThisProspect, 64),
            'RegistrationInformationActiveCount' => $this->CountActive($ThisSaleProspect, 65),
            'PairRegistrationInformationActiveCount' => $this->CountActive($ThisProspect, 65),
            'BuildingConfirmationInformationActiveCount' => $this->CountActive($ThisSaleProspect, 66),
            'PairBuildingConfirmationInformationActiveCount' => $this->CountActive($ThisProspect, 66),
        ];

        $company['CaretakerTelRate'] = $this->RateCalc($company['CaretakerTelActionCount'], $company['CaretakerTelActiveCount']);
        $company['PairCaretakerTelRate'] = $this->RateCalc($company['PairCaretakerTelActionCount'], $company['PairCaretakerTelActiveCount']);
        $company['PersonalTelRate'] = $this->RateCalc($company['PersonalTelActionCount'], $company['PersonalTelActiveCount']);
        $company['PairPersonalTelRate'] = $this->RateCalc($company['PairPersonalTelActionCount'], $company['PairPersonalTelActiveCount']);
        $company['RandomTelRate'] = $this->RateCalc($company['RandomTelActionCount'], $company['RandomTelActiveCount']);
        $company['PairRandomTelRate'] = $this->RateCalc($company['PairRandomTelActionCount'], $company['PairRandomTelActiveCount']);
        $company['LatterRate'] = $this->RateCalc($company['LatterActionCount'], $company['LatterActiveCount']);
        $company['PairLatterRate'] = $this->RateCalc($company['PairLatterActionCount'], $company['PairLatterActiveCount']);
        $company['FlyerRate'] = $this->RateCalc($company['FlyerActionCount'], $company['FlyerActiveCount']);
        $company['PairFlyerRate'] = $this->RateCalc($company['PairFlyerActionCount'], $company['PairFlyerActiveCount']);
        $company['DMRate'] = $this->RateCalc($company['DMActionCount'], $company['DMActiveCount']);
        $company['PairDMRate'] = $this->RateCalc($company['PairDMActionCount'], $company['PairDMActiveCount']);

        return $company;
    }

    //前取算出
    private function generateSalePre($ThisSaleExcavationBehaviorLog, $ThisSaleProspect, $ThisExcavationBehaviorLog, $ThisProspect, $ThisPairExcavationBehaviorLog): array
    {
        $pre = [
            'PreVisitActionCount' => $this->CountAction($ThisSaleExcavationBehaviorLog, 'pre_visit_preliminary_count'),
            'PairPreVisitActionCount' => $this->CountAction($ThisPairExcavationBehaviorLog, 'pre_visit_preliminary_count'),
            'PreVisitHomeActionCount' => $this->CountAction($ThisSaleExcavationBehaviorLog, 'pre_visit_home_count'),
            'PairPreVisitHomeActionCount' => $this->CountAction($ThisPairExcavationBehaviorLog, 'pre_visit_home_count'),
            'PreVisitActiveCount' => $this->CountActive($ThisSaleProspect, 71),
            'PairPreVisitActiveCount' => $this->CountActive($ThisProspect, 71),
            'PreVisitRate' => 0,
            'PairPreVisitRate' => 0,
            'PreTelActionCount' => $this->CountAction($ThisSaleExcavationBehaviorLog, 'pre_TEL_home_count'),
            'PairPreTelActionCount' => $this->CountAction($ThisPairExcavationBehaviorLog, 'pre_TEL_home_count'),
            'PreTelActiveCount' => $this->CountActive($ThisSaleProspect, 72),
            'PairPreTelActiveCount' => $this->CountActive($ThisProspect, 72),
            'PreTelRate' => 0,
            'PairPreTelRate' => 0,
            'PreSelfDiscoveryActiveCount' => $this->CountActive($ThisSaleProspect, 73),
            'PairPreSelfDiscoveryActiveCount' => $this->CountActive($ThisProspect, 73),
            'PreResponseActiveCount' => $this->CountActive($ThisSaleProspect, 74),
            'PairPreResponseActiveCount' => $this->CountActive($ThisProspect, 74),
            'PreOtherActiveCount' => $this->CountActive($ThisSaleProspect, 75),
            'PairPreOtherActiveCount' => $this->CountActive($ThisProspect, 75),
        ];

        $pre['PreVisitRate'] = $this->RateCalc($pre['PreVisitActionCount'], $pre['PreVisitActiveCount']);
        $pre['PairPreVisitRate'] = $this->RateCalc($pre['PairPreVisitActionCount'], $pre['PairPreVisitActiveCount']);
        $pre['PreTelRate'] = $this->RateCalc($pre['PreTelActionCount'], $pre['PreTelActiveCount']);
        $pre['PairPreTelRate'] = $this->RateCalc($pre['PairPreTelActionCount'], $pre['PairPreTelActiveCount']);

        return $pre;
    }

    //反響算出
    private function generateSaleRe($ThisSaleProspect, $ThisProspect): array
    {
        $re = [
            'hpActiveCount' => $this->CountActive($ThisSaleProspect, 67),
            'pairHpActiveCount' => $this->CountActive($ThisProspect, 67),
            'siteActiveCount' => $this->CountActive($ThisSaleProspect, 68),
            'pairSiteActiveCount' => $this->CountActive($ThisProspect, 68),
            'otherSalesOfficeActiveCount' => $this->CountActive($ThisSaleProspect, 69),
            'pairOtherSalesOfficeActiveCount' => $this->CountActive($ThisProspect, 69),
            'otherGroupsActiveCount' => $this->CountActive($ThisSaleProspect, 70),
            'pairOtherGroupsActiveCount' => $this->CountActive($ThisProspect, 70),
        ];
        return  $re;
    }

    //その他算出
    private function generateSaleOther($ThisSaleProspect, $ThisProspect): array
    {
        $other = [
            'contractorInvolvementActiveCount' => $this->CountActive($ThisSaleProspect, 76),
            'pairContractorInvolvementActiveCount' => $this->CountActive($ThisProspect, 76),
            'openRoomActiveCount' => $this->CountActive($ThisSaleProspect, 77),
            'pairOpenRoomActiveCount' => $this->CountActive($ThisProspect, 77),
            'freeVisitActiveCount' => $this->CountActive($ThisSaleProspect, 78),
            'pairFreeVisitActiveCount' => $this->CountActive($ThisProspect, 78),
            'otherActiveCount' => $this->CountActive($ThisSaleProspect, 79),
            'pairOtherActiveCount' => $this->CountActive($ThisProspect, 79),
        ];
        return  $other;
    }

    //area算出
    private function generatehatArea($ThisExcavationBehaviorLog, $ThisProspect): array
    {
        $area = [
            'CaretakerVisitActionCount' => $this->CountAction($ThisExcavationBehaviorLog, 'manager_visit_count'),
            'CaretakerVisitActiveCount' => $this->CountActive($ThisProspect, 48),
            'CaretakerVisitRate' => 0,
            'PersonalVisitActionCount' => $this->CountAction($ThisExcavationBehaviorLog, 'personal_visit_count'),
            'PersonalVisitActiveCount' => $this->CountActive($ThisProspect, 49),
            'PersonalVisitRate' => 0,
            'PostCheckActiveCount' => $this->CountActive($ThisProspect, 50),
            'CheckTheBuildingActionCount' => $this->CountAction($ThisExcavationBehaviorLog, 'check_building_count'),
            'CheckTheBuildingActiveCount' => $this->CountActive($ThisProspect, 51),
            'CheckTheBuildingRate' => 0,
            'PatrolLocalInformationActiveCount' => $this->CountActive($ThisProspect, 52),
            'DMActionCount' =>  $this->CountAction($ThisExcavationBehaviorLog, 'DM_distribution_count'),
            'DMActiveCount' => $this->CountActive($ThisProspect, 53),
            'DMRate' => 0,
            'FlyerActionCount' => $this->CountAction($ThisExcavationBehaviorLog, 'flyer_distribution_count'),
            'FlyerActiveCount' => $this->CountActive($ThisProspect, 54),
            'FlyerRate' => 0,
            'LatterActionCount' => $this->CountAction($ThisExcavationBehaviorLog, 'letter_distribution_count'),
            'LatterActiveCount' => $this->CountActive($ThisProspect, 55),
            'LatterRate' => 0,
            'RandomImplementationCount' => $this->CountAction($ThisExcavationBehaviorLog, 'random_visit_implementation_count'),
            'RandomActionCount' => $this->CountAction($ThisExcavationBehaviorLog, 'random_visit_at_home_count'),
            'RandomActiveCount' => $this->CountActive($ThisProspect, 56),
            'RandomRate' => 0,
        ];

        $area['CaretakerVisitRate'] = $this->RateCalc($area['CaretakerVisitActionCount'], $area['CaretakerVisitActiveCount']);
        $area['PersonalVisitRate'] = $this->RateCalc($area['PersonalVisitActionCount'], $area['PersonalVisitActiveCount']);
        $area['CheckTheBuildingRate'] = $this->RateCalc($area['CheckTheBuildingActionCount'], $area['CheckTheBuildingActiveCount']);
        $area['DMRate'] = $this->RateCalc($area['DMActionCount'], $area['DMActiveCount']);
        $area['FlyerRate'] = $this->RateCalc($area['FlyerActionCount'], $area['FlyerActiveCount']);
        $area['LatterRate'] = $this->RateCalc($area['LatterActionCount'], $area['LatterActiveCount']);
        $area['RandomRate'] = $this->RateCalc($area['RandomActionCount'], $area['RandomActiveCount']);

        return $area;
    }

    //company算出
    private function generatehatCompany($ThisExcavationBehaviorLog, $ThisProspect): array
    {
        $company = [
            'CaretakerTelActionCount' => $this->CountAction($ThisExcavationBehaviorLog, 'manager_TEL_count'),
            'CaretakerTelActiveCount' => $this->CountActive($ThisProspect, 57),
            'CaretakerTelRate' => 0,
            'PersonalTelActionCount' => $this->CountAction($ThisExcavationBehaviorLog, 'personal_TEL_count'),
            'PersonalTelActiveCount' => $this->CountActive($ThisProspect, 58),
            'PersonalTelRate' => 0,
            'RandomTelImplementationCount' => $this->CountAction($ThisExcavationBehaviorLog, 'random_TEL_implementation_count'),
            'RandomTelActionCount' => $this->CountAction($ThisExcavationBehaviorLog, 'random_TEL_at_home_count'),
            'RandomTelActiveCount' => $this->CountActive($ThisProspect, 59),
            'RandomTelRate' => 0,
            'LatterActionCount' => $this->CountAction($ThisExcavationBehaviorLog, 'mail_letter_count'),
            'LatterActiveCount' => $this->CountActive($ThisProspect, 61),
            'LatterRate' => 0,
            'FlyerActionCount' => $this->CountAction($ThisExcavationBehaviorLog, 'flyer_delivery_count'),
            'FlyerActiveCount' => $this->CountActive($ThisProspect, 62),
            'FlyerRate' => 0,
            'DMActionCount' => $this->CountAction($ThisExcavationBehaviorLog, 'DM_mail_count'),
            'DMActiveCount' => $this->CountActive($ThisProspect, 60),
            'DMRate' => 0,
            'ReturnByMailActiveCount' => $this->CountActive($ThisProspect, 63),
            'RentalInformationActiveCount' => $this->CountActive($ThisProspect, 64),
            'RegistrationInformationActiveCount' => $this->CountActive($ThisProspect, 65),
            'BuildingConfirmationInformationActiveCount' => $this->CountActive($ThisProspect, 66),
        ];

        $company['CaretakerTelRate'] = $this->RateCalc($company['CaretakerTelActionCount'], $company['CaretakerTelActiveCount']);
        $company['PersonalTelRate'] = $this->RateCalc($company['PersonalTelActionCount'], $company['PersonalTelActiveCount']);
        $company['RandomTelRate'] = $this->RateCalc($company['RandomTelActionCount'], $company['RandomTelActiveCount']);
        $company['LatterRate'] = $this->RateCalc($company['LatterActionCount'], $company['LatterActiveCount']);
        $company['FlyerRate'] = $this->RateCalc($company['FlyerActionCount'], $company['FlyerActiveCount']);
        $company['DMRate'] = $this->RateCalc($company['DMActionCount'], $company['DMActiveCount']);

        return $company;
    }

    //前取算出
    private function generatehatPre($ThisExcavationBehaviorLog, $ThisProspect): array
    {
        $pre = [
            'PreVisitActionCount' => $this->CountAction($ThisExcavationBehaviorLog, 'pre_visit_preliminary_count'),
            'PreVisitActiveCount' => $this->CountActive($ThisProspect, 71),
            'PreVisitHomeActionCount' => $this->CountAction($ThisExcavationBehaviorLog, 'pre_visit_home_count'),
            'PreVisitRate' => 0,
            'PreTelActionCount' => $this->CountAction($ThisExcavationBehaviorLog, 'pre_TEL_home_count'),
            'PreTelActiveCount' => $this->CountActive($ThisProspect, 72),
            'PreTelRate' => 0,
            'PreSelfDiscoveryActiveCount' => $this->CountActive($ThisProspect, 73),
            'PreResponseActiveCount' => $this->CountActive($ThisProspect, 74),
            'PreOtherActiveCount' => $this->CountActive($ThisProspect, 75),
        ];

        $pre['PreVisitRate'] = $this->RateCalc($pre['PreVisitActionCount'], $pre['PreVisitActiveCount']);
        $pre['PreTelRate'] = $this->RateCalc($pre['PreTelActionCount'], $pre['PreTelActiveCount']);

        return $pre;
    }

    //反響算出
    private function generatehatRe($ThisProspect): array
    {
        $re = [
            'hpActiveCount' => $this->CountActive($ThisProspect, 67),
            'siteActiveCount' => $this->CountActive($ThisProspect, 68),
            'otherSalesOfficeActiveCount' => $this->CountActive($ThisProspect, 69),
            'otherGroupsActiveCount' => $this->CountActive($ThisProspect, 70),
        ];
        return  $re;
    }

    //その他算出
    private function generatehatOther($ThisProspect): array
    {
        $other = [
            'contractorInvolvementActiveCount' => $this->CountActive($ThisProspect, 76),
            'openRoomActiveCount' => $this->CountActive($ThisProspect, 77),
            'freeVisitActiveCount' => $this->CountActive($ThisProspect, 78),
            'otherActiveCount' => $this->CountActive($ThisProspect, 79),
        ];
        return  $other;
    }

    //グラフの事業所合計
    private function OfficeTotal($analysisData, $request): array
    {
        $CaretakerVisitActiveCount = 0;
        $PersonalVisitActiveCount = 0;
        $PostCheckActiveCount = 0;
        $CheckTheBuildingActiveCount = 0;
        $PatrolLocalInformationActiveCount = 0;
        $AreaDMActiveCount = 0;
        $AreaFlyerActiveCount = 0;
        $AreaLatterActiveCount = 0;
        $RandomActiveCount = 0;
        $CaretakerTelActiveCount = 0;
        $PersonalTelActiveCount = 0;
        $RandomTelActiveCount = 0;
        $CompanyLatterActiveCount = 0;
        $CompanyFlyerActiveCount = 0;
        $CompanyDMActiveCount = 0;
        $ReturnByMailActiveCount = 0;
        $RentalInformationActiveCount = 0;
        $RegistrationInformationActiveCount = 0;
        $BuildingConfirmationInformationActiveCount = 0;

        $PreVisitActiveCount = 0;
        $PreTelActiveCount = 0;
        $PreSelfDiscoveryActiveCount = 0;
        $PreResponseActiveCount = 0;
        $PreOtherActiveCount = 0;

        $hpActiveCount = 0;
        $siteActiveCount = 0;
        $otherSalesOfficeActiveCount = 0;
        $otherGroupsActiveCount = 0;

        $contractorInvolvementActiveCount = 0;
        $openRoomActiveCount = 0;
        $freeVisitActiveCount = 0;
        $otherActiveCount = 0;

        foreach ($analysisData['graph'] as $data){
            $CaretakerVisitActiveCount += $data['area']['CaretakerVisitActiveCount'];
            $PersonalVisitActiveCount += $data['area']['PersonalVisitActiveCount'];
            $PostCheckActiveCount += $data['area']['PostCheckActiveCount'];
            $CheckTheBuildingActiveCount += $data['area']['CheckTheBuildingActiveCount'];
            $PatrolLocalInformationActiveCount += $data['area']['PatrolLocalInformationActiveCount'];
            $AreaDMActiveCount += $data['area']['DMActiveCount'];
            $AreaFlyerActiveCount += $data['area']['FlyerActiveCount'];
            $AreaLatterActiveCount += $data['area']['LatterActiveCount'];
            $RandomActiveCount += $data['area']['RandomActiveCount'];
            $CaretakerTelActiveCount += $data['company']['CaretakerTelActiveCount'];
            $PersonalTelActiveCount += $data['company']['PersonalTelActiveCount'];
            $RandomTelActiveCount += $data['company']['RandomTelActiveCount'];
            $CompanyLatterActiveCount += $data['company']['LatterActiveCount'];
            $CompanyFlyerActiveCount += $data['company']['FlyerActiveCount'];
            $CompanyDMActiveCount  += $data['company']['DMActiveCount'];
            $ReturnByMailActiveCount +=$data['company']['ReturnByMailActiveCount'];
            $RentalInformationActiveCount +=$data['company']['RentalInformationActiveCount'];
            $RegistrationInformationActiveCount +=$data['company']['RegistrationInformationActiveCount'];
            $BuildingConfirmationInformationActiveCount +=$data['company']['BuildingConfirmationInformationActiveCount'];
            $PreVisitActiveCount += $data['pre']['PreVisitActiveCount'];
            $PreTelActiveCount += $data['pre']['PreTelActiveCount'];
            $PreSelfDiscoveryActiveCount += $data['pre']['PreSelfDiscoveryActiveCount'];
            $PreResponseActiveCount += $data['pre']['PreResponseActiveCount'];
            $PreOtherActiveCount += $data['pre']['PreOtherActiveCount'];
            $hpActiveCount += $data['re']['hpActiveCount'];
            $siteActiveCount += $data['re']['siteActiveCount'];
            $otherSalesOfficeActiveCount += $data['re']['otherSalesOfficeActiveCount'];
            $otherGroupsActiveCount += $data['re']['otherGroupsActiveCount'];
            $contractorInvolvementActiveCount += $data['other']['contractorInvolvementActiveCount'];
            $openRoomActiveCount += $data['other']['openRoomActiveCount'];
            $freeVisitActiveCount += $data['other']['freeVisitActiveCount'];
            $otherActiveCount += $data['other']['otherActiveCount'];

        }
        return [
            'OfficeName' => UserMaster::find($request->office_master_id)->name,
            'area' => [
                'CaretakerVisitActiveCount' => $CaretakerVisitActiveCount,
                'PersonalVisitActiveCount' => $PersonalVisitActiveCount,
                'PostCheckActiveCount' => $PostCheckActiveCount,
                'CheckTheBuildingActiveCount' => $CheckTheBuildingActiveCount,
                'PatrolLocalInformationActiveCount' => $PatrolLocalInformationActiveCount,
                'DMActiveCount' => $AreaDMActiveCount,
                'FlyerActiveCount' => $AreaFlyerActiveCount,
                'LatterActiveCount' => $AreaLatterActiveCount,
                'RandomActiveCount' => $RandomActiveCount,
                'areaTotal' => $CaretakerVisitActiveCount + $PersonalVisitActiveCount + $PostCheckActiveCount + $CheckTheBuildingActiveCount + $PatrolLocalInformationActiveCount + $AreaDMActiveCount + $AreaFlyerActiveCount + $AreaLatterActiveCount + $RandomActiveCount,
            ],
            'company' => [
                'CaretakerTelActiveCount' => $CaretakerTelActiveCount,
                'PersonalTelActiveCount' => $PersonalTelActiveCount,
                'RandomTelActiveCount' => $RandomTelActiveCount,
                'LatterActiveCount' => $CompanyLatterActiveCount,
                'FlyerActiveCount' => $CompanyFlyerActiveCount,
                'DMActiveCount' => $CompanyDMActiveCount,
                'ReturnByMailActiveCount' => $ReturnByMailActiveCount,
                'RentalInformationActiveCount' => $RentalInformationActiveCount,
                'RegistrationInformationActiveCount' => $RegistrationInformationActiveCount,
                'BuildingConfirmationInformationActiveCount' => $BuildingConfirmationInformationActiveCount,
                'companyTotal' => $CaretakerTelActiveCount + $PersonalTelActiveCount + $RandomTelActiveCount + $CompanyLatterActiveCount + $CompanyFlyerActiveCount + $CompanyDMActiveCount + $ReturnByMailActiveCount + $RentalInformationActiveCount + $RegistrationInformationActiveCount + $BuildingConfirmationInformationActiveCount,
            ],
            'pre' => [
                'PreVisitActiveCount' => $PreVisitActiveCount,
                'PreTelActiveCount' => $PreTelActiveCount,
                'PreSelfDiscoveryActiveCount' => $PreSelfDiscoveryActiveCount,
                'PreResponseActiveCount' => $PreResponseActiveCount,
                'PreOtherActiveCount' => $PreOtherActiveCount,
                'preTotal' => $PreVisitActiveCount + $PreTelActiveCount + $PreSelfDiscoveryActiveCount + $PreResponseActiveCount + $PreOtherActiveCount,
            ],
            're' => [
                'hpActiveCount' => $hpActiveCount,
                'siteActiveCount' => $siteActiveCount,
                'otherSalesOfficeActiveCount'  => $otherSalesOfficeActiveCount,
                'otherGroupsActiveCount' => $otherGroupsActiveCount,
                'reTotal' => $hpActiveCount + $siteActiveCount + $otherSalesOfficeActiveCount + $otherGroupsActiveCount,
            ],
            'other' => [
                'contractorInvolvementActiveCount' => $contractorInvolvementActiveCount,
                'openRoomActiveCount' => $openRoomActiveCount,
                'freeVisitActiveCount' => $freeVisitActiveCount,
                'otherActiveCount' => $otherActiveCount,
                'otherTotal' => $contractorInvolvementActiveCount + $openRoomActiveCount + $freeVisitActiveCount + $otherActiveCount,
            ],
        ];
    }
}