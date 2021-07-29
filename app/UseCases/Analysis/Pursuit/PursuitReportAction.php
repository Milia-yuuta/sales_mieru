<?php


namespace App\UseCases\Analysis\Pursuit;

use App\Models\ProspectActionLog;
use App\Models\Prospect;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class PursuitReportAction
{
    public function __invoke($request):array
    {
        $nowStart = Carbon::now()->startOfMonth();
        $nowEnd =  Carbon::now()->endOfMonth();

        //デフォルト画面でログインユーザーの事業所を表示するために
        if (empty($request->input('office_master_id'))){
            $request = $request->merge([
                'office_master_id' => User::find(Auth::user()->id)->office_master_id
            ]);
        }

        //デフォルトで当月初
        if (empty($request->input('start_period'))){
            $request = $request->merge([
                'start_period' => $nowStart
            ]);
        }else{
            $month = $request->input('start_period');
            $request = $request->merge(['start_period' => Carbon::parse("${month}-01 00:00:00")]);
        }

        //デフォルトで当月末
        if (empty($request->input('end_period'))){
            $request = $request->merge([
                'end_period' => $nowEnd
            ]);
        }else{
            $month = $request->input('end_period');
            $request = $request->merge(['end_period' => Carbon::parse("${month}-01 00:00:00")->endOfMonth()]);
        }

        //営業所の社員IDを取得
        $pairs = $this->searchPair($request);

        //期間と営業所のmodel
        $PeriodProspects = $this->PeriodProspect($request);
        $startOfMonthProspect = $this->generateStartOfMonthProspect($request);
        $withinTheMonthProspect =  $this->generateWithinTheMonthProspect($request);
        $withinTheMonthProspectActionLogs =  $this->generateWithinTheMonthProspectActionLogs($request);

        //max
        $discriminationMaxStageUpCount = 0;
        $discriminationMaxStageUpRate = 0;
        $latentMaxStageUpCount = 0;
        $latentMaxStageUpRate = 0;
        $overtMaxStageUpCount = 0;
        $overtMaxStageUpRate = 0;

        //該当営業所の社員毎の追客レポートを取得
        foreach ($pairs->sortBy('area_master_id') as $pair){
            unset($user, $discrimination, $latent, $overt, $FooterGraphDiscrimination, $FooterGraphLatent, $FooterGraphOvert);
            //UserIdで特定
            $ThisProspects = $this->ThisUserModel($PeriodProspects, $pair);
            $thisStartOfMonthProspect = $this->ThisUserModel($startOfMonthProspect, $pair);
            $thisWithinTheMonthProspect = $this->ThisUserModel($withinTheMonthProspect, $pair);
            $thisWithinTheMonthProspectActionLogs = $this->ThisUserModel($withinTheMonthProspectActionLogs, $pair);

            $hat_name = $pair->hat->sei ?? '';
            //userデータ
            $user = [
                'user_name' => "{$pair->sale->sei}/{$hat_name}"
            ];

            //グラフ用のuser配列データ
            $GraphUser[] = "{$pair->sale->sei}／{$hat_name}";

            //判別ステージのレポート取得
            $discrimination = [
                'StartMonthStockCount' => $this->StartMonthStageCount($thisStartOfMonthProspect, 1),
                'ToMonthNewCount' => $this->NewCount($thisWithinTheMonthProspect, 1),
                'StockTotalCount' => 0,
                'StageUpCount' => $this->StageUpCount($ThisProspects, 1, 'discrimination', $request) + $this->NewCountStageUp(1, 'discrimination', $thisWithinTheMonthProspect),
                'StageUpRate' => 0,
                'TelCount' => $this->ActionCount($withinTheMonthProspectActionLogs,1, 'TEL_home'),
                'LetterCount' => $this->ActionCount($withinTheMonthProspectActionLogs,1, 'send_letter'),
                'VisitCount' => $this->ActionCount($withinTheMonthProspectActionLogs,1, 'visit'),
                'VisitCaretakerCount' => $this->ActionCount($withinTheMonthProspectActionLogs, 1, 'visit_caretaker'),
                'TelCaretakerCount' => $this->ActionCount($withinTheMonthProspectActionLogs, 1, 'TEL_caretaker'),
                'OnSiteCheckCount' => $this->ActionCount($withinTheMonthProspectActionLogs,1, 'on-site_check'),
            ];
            $discrimination['StockTotalCount'] = $discrimination['StartMonthStockCount'] +  $discrimination['ToMonthNewCount'];
            $discrimination['StageUpRate'] = $this->division($discrimination['StageUpCount'], ($discrimination['StartMonthStockCount'] + $discrimination['ToMonthNewCount']) );

            //bodyグラフ用の判別データ配列
            $bodyGraphDiscrimination['user_name'][] = "{$pair->sale->sei}／{$hat_name}";
            $bodyGraphDiscrimination['StartMonthStockCount'][] = $discrimination['StartMonthStockCount'];
            $bodyGraphDiscrimination['ToMonthNewCount'][] = $discrimination['ToMonthNewCount'];

            //footerGraph
            $FooterGraphDiscrimination = [
                'user_id' => $pair->id,
                'user_name' => "{$pair->sale->sei}／{$hat_name}",
                'StageUpCount' => $discrimination['StageUpCount'],
                'StageUpRate' => $discrimination['StageUpRate'],
            ];

            $discriminationMaxStageUpCount = $discriminationMaxStageUpCount < $FooterGraphDiscrimination['StageUpCount'] ? $FooterGraphDiscrimination['StageUpCount'] : $discriminationMaxStageUpCount;
            $discriminationMaxStageUpRate = $discriminationMaxStageUpRate < $FooterGraphDiscrimination['StageUpRate'] ? $FooterGraphDiscrimination['StageUpRate'] : $discriminationMaxStageUpRate;

            //潜在ステージのレポート取得
            $latent = [
                'StartMonthStockCount' => $this->StartMonthStageCount($thisStartOfMonthProspect, 2),
                'ToMonthNewCount' => $this->NewCount($thisWithinTheMonthProspect, 2),
                'StockTotalCount' => 0,
                'StageUpCount' => $this->StageUpCount($ThisProspects, 2, 'latent', $request) + $this->NewCountStageUp(2, 'latent', $thisWithinTheMonthProspect),
                'StageUpRate' => 0,
                'TelCount' => $this->ActionCount($withinTheMonthProspectActionLogs,2, 'TEL_home'),
                'EmailCount' => $this->ActionCount($withinTheMonthProspectActionLogs,2, 'email'),
                'LetterCount' => $this->ActionCount($withinTheMonthProspectActionLogs,2, 'send_letter'),
                'VisitCount' => $this->ActionCount($withinTheMonthProspectActionLogs,2, 'visit'),
                'VisitCaretakerCount' => $this->ActionCount($withinTheMonthProspectActionLogs, 2, 'visit_caretaker'),
                'TelCaretakerCount' => $this->ActionCount($withinTheMonthProspectActionLogs,2, 'TEL_caretaker'),
                'OnSiteCheckCount' => $this->ActionCount($withinTheMonthProspectActionLogs,2, 'on-site_check'),
                'SendAssessmentReportCount' => $this->ActionCount($withinTheMonthProspectActionLogs,2, 'send_assessment_report'),
                'AssessmentReportEmailCount' => $this->ActionCount($withinTheMonthProspectActionLogs,2, 'assessment_report_email'),
                'AssessmentNegotiation' =>  $this->ActionCount($withinTheMonthProspectActionLogs,2, 'assessment_negotiation'),
                'ReNegotiation' => $this->ActionCount($withinTheMonthProspectActionLogs,2, 're-negotiation'),
            ];
            $latent['StockTotalCount'] = $latent['StartMonthStockCount'] +  $latent['ToMonthNewCount'];
            $latent['StageUpRate'] = $this->division($latent['StageUpCount'], ($latent['StartMonthStockCount'] + $latent['ToMonthNewCount']));

            //グラフ用の潜在データ配列
            $bodyGraphLatent['user_name'][] =  "{$pair->sale->sei}／{$hat_name}";
            $bodyGraphLatent['StartMonthStockCount'][] = $latent['StartMonthStockCount'];
            $bodyGraphLatent['ToMonthNewCount'][] =  $latent['ToMonthNewCount'];

            //footerGraph
            $FooterGraphLatent = [
                'user_id' => $pair->id,
                'user_name' => "{$pair->sale->sei}／{$hat_name}",
                'StageUpCount' => $latent['StageUpCount'],
                'StageUpRate' => $latent['StageUpRate'],
            ];

            $latentMaxStageUpCount = $latentMaxStageUpCount < $FooterGraphLatent['StageUpCount'] ? $FooterGraphLatent['StageUpCount'] : $latentMaxStageUpCount;
            $latentMaxStageUpRate = $latentMaxStageUpRate < $FooterGraphLatent['StageUpRate'] ? $FooterGraphLatent['StageUpRate'] : $latentMaxStageUpRate;

            //顕在ステージのレポート取得
            $overt = [
                'StartMonthStockCount' => $this->StartMonthStageCount($thisStartOfMonthProspect, 3),
                'ToMonthNewCount' => $this->NewCount($thisWithinTheMonthProspect, 3),
                'StockTotalCount' => 0,
                'StageUpCount' => $this->StageUpCount($ThisProspects, 3, 'mediation', $request) + $this->NewCountStageUp(3, 'mediation', $thisWithinTheMonthProspect),
                'OtherStagesMediatedFromCount' => $this->FromTheUpperStage($ThisProspects, 4, 'overtFromLowerStage', $request) + $this->NewCountFromTheUpperStage('mediation', $thisWithinTheMonthProspect),
                'StageUpTotal' => 0,
                'StageUpRate' => 0,
                'TelCount' => $this->ActionCount($withinTheMonthProspectActionLogs,3, 'TEL_home'),
                'EmailCount' => $this->ActionCount($withinTheMonthProspectActionLogs,3, 'email'),
                'LetterCount' => $this->ActionCount($withinTheMonthProspectActionLogs,3, 'send_letter'),
                'VisitCount' => $this->ActionCount($withinTheMonthProspectActionLogs,3, 'visit'),
                'VisitCaretakerCount' => $this->ActionCount($withinTheMonthProspectActionLogs,3, 'visit_caretaker'),
                'TelCaretakerCount' => $this->ActionCount($withinTheMonthProspectActionLogs,3, 'TEL_caretaker'),
                'OnSiteCheckCount' => $this->ActionCount($withinTheMonthProspectActionLogs,3, 'on-site_check'),
                'SendAssessmentReportCount' => $this->ActionCount($withinTheMonthProspectActionLogs,3, 'send_assessment_report'),
                'AssessmentReportEmailCount' => $this->ActionCount($withinTheMonthProspectActionLogs,3, 'assessment_report_email'),
                'AssessmentNegotiation' =>  $this->ActionCount($withinTheMonthProspectActionLogs,3, 'assessment_negotiation'),
                'ReNegotiation' => $this->ActionCount($withinTheMonthProspectActionLogs,3, 're-negotiation'),
            ];

            $overt['StockTotalCount'] = $overt['StartMonthStockCount'] +  $overt['ToMonthNewCount'];
            $overt['StageUpTotal'] = $overt['StageUpCount'] +  $overt['OtherStagesMediatedFromCount'];
            $overt['StageUpRate'] = $this->division($overt['StageUpCount'], $overt['StageUpTotal']);

            $bodyGraphOvert['user_name'][] = "{$pair->sale->sei}／{$hat_name}";
            $bodyGraphOvert['StartMonthStockCount'][] = $overt['StartMonthStockCount'];
            $bodyGraphOvert['ToMonthNewCount'][] = $overt['ToMonthNewCount'];

            $FooterGraphOvert = [
                'user_id' => $pair->id,
                'user_name' => "{$pair->sale->sei}／{$hat_name}",
                'StageUpCount' => $overt['StageUpCount'],
                'StageUpRate' => $this->division($overt['StageUpCount'], ($overt['StartMonthStockCount'] + $overt['ToMonthNewCount'])),
            ];

            $overtMaxStageUpCount = $overtMaxStageUpCount < $FooterGraphOvert['StageUpCount'] ? $FooterGraphOvert['StageUpCount'] : $overtMaxStageUpCount;
            $overtMaxStageUpRate = $overtMaxStageUpRate < $FooterGraphOvert['StageUpRate'] ? $FooterGraphOvert['StageUpRate'] : $overtMaxStageUpRate;

            $analysisData['list'][] = array_merge(['user' => $user],['discrimination' => $discrimination], ['latent' => $latent], ['overt' => $overt]);
            $analysisData['FooterGraph'][] = array_merge(['FooterGraphDiscrimination' => $FooterGraphDiscrimination], ['FooterGraphLatent' => $FooterGraphLatent], ['FooterGraphOvert' => $FooterGraphOvert]);
        }

        $analysisData['graph'] = array_merge(['discrimination' => $bodyGraphDiscrimination], ['latent' => $bodyGraphLatent], ['overt' => $bodyGraphOvert]);

        //footerマックス数値
        $analysisData['FooterMax'] = array_merge(
            ['discriminationMaxStageUpCount' => $discriminationMaxStageUpCount], ['discriminationMaxStageUpRate' => $discriminationMaxStageUpRate],
            ['latentMaxStageUpCount' => $latentMaxStageUpCount], ['latentMaxStageUpRate' => $latentMaxStageUpRate],
            ['overtMaxStageUpCount' => $overtMaxStageUpCount], ['overtMaxStageUpRate' => $overtMaxStageUpRate]
        );
        return $analysisData;
    }


    //該当事業所の社員のIDを取得
    protected function searchPair($request): Collection
    {
        return Team::query()->where('office_master_id', $request->input('office_master_id'))->get();
    }

    //期間内のProspectActionLogを取得
    protected function PeriodProspectActonLogs($request): array|\Illuminate\Database\Eloquent\Collection|Collection
    {
        return ProspectActionLog::query()
            ->whereBetween('created_at' , [$request->input('start_period'), $request->input('end_period')])->get();
    }

    //期間前のProspectと月末までのprospectActionLogを取得
    protected function PeriodProspect($request): \Illuminate\Database\Eloquent\Collection|array
    {
        return Prospect::with(['prospectActionLogs' => function($query) use ($request){
            $query->where('date' , '<',Carbon::create($request->input('end_period')->format('Y-m-d')));
        }])
            ->where('office_master_id', $request->office_master_id)
            ->where('date', '<=',Carbon::create($request->input('start_period')->format('Y-m-d'))->subMonthNoOverflow()->lastOfMonth())
            ->get();
    }

    protected function generateStartOfMonthProspect($request): \Illuminate\Database\Eloquent\Collection|array
    {
        return
            Prospect::with(['prospectActionLogs' => function($query) use ($request){
                $query->where('date' , '<', Carbon::create($request->input('start_period')->format('Y-m-d')));
            }])
                ->where('office_master_id', $request->input('office_master_id'))
                ->where('date', '<',Carbon::create($request->input('start_period')->format('Y-m-d')))
                ->get();
    }

    protected function generateWithinTheMonthProspect($request): \Illuminate\Database\Eloquent\Collection|array
    {
        return
            Prospect::with(['propertyRoom.property','prospectActionLogs' => function($query) use ($request){
                $query->whereBetween('date' , [Carbon::create($request->input('start_period')->format('Y-m-d')), Carbon::create($request->input('end_period')->format('Y-m-d'))]);
            }])
                ->whereBetween('date' , [Carbon::create($request->input('start_period')->format('Y-m-d')), Carbon::create($request->input('end_period')->format('Y-m-d'))])
                ->where('office_master_id', $request->input('office_master_id'))
                ->get();
    }

    protected function generateWithinTheMonthProspectActionLogs($request)
    {
        return
            Prospect::with(['prospectActionLogs' => function($query) use ($request){
                $query->whereBetween('date' , [Carbon::create($request->input('start_period')->format('Y-m-d')), Carbon::create($request->input('end_period')->format('Y-m-d'))]);
            }])
                ->where('date', '<',Carbon::create($request->end_period->format('Y-m-d')))
                ->where('area_master_id', $request->area_master_id)
                ->get();
    }

    protected function ThisUserModel($modelCollection, $pair)
    {
        return $modelCollection->where('area_master_id', $pair->area_master_id);
    }

    //月初のカウント
    protected function StartMonthStageCount($prospects, $target_stage_id): int
    {
        $name = [];

        if ($prospects->isEmpty())return 0;
        $count = 0;
        foreach ($prospects as $prospect){
            $prospectActionLog = $prospect->prospectActionLogs
                ->sortBy('date')
                ->last();

            if (empty($prospectActionLog)) {
                $count += 0;
            } elseif($prospectActionLog->stage_action_master_id === $target_stage_id){
//                dd($name += $prospectActionLog->prospect_id);
                array_push($name, $prospectActionLog->prospect_id);
                ++$count;
            }
        }
//        dump($name);
        return $count;
    }

    //月内新規発生数
    protected function NewCount($prospects, $target_stage_id): int
    {

        if ($prospects->isEmpty())return 0;
        $count = 0;
        foreach ($prospects as $prospect){
            $prospectActionLog = $prospect->prospectActionLogs
                ->sortBy('date')
                ->first();
            if (empty($prospectActionLog)) {
                $count += 0;
            } elseif($prospectActionLog->stage_action_master_id === $target_stage_id){
                ++$count;
            }
        }
        return $count;
    }

    //月内新規発生のステージアップ
    protected function NewCountStageUp($first_stage_id, $last_stage_id, $prospects): int
    {
//        $prospects = Prospect::with(['prospectActionLogs' => function($query) use ($request){
//            $query->whereBetween('date' , [Carbon::create($request->input('start_period')->format('Y-m-d')), Carbon::create($request->input('end_period')->format('Y-m-d'))]);
//        }])
//            ->whereBetween('date' , [Carbon::create($request->input('start_period')->format('Y-m-d')), Carbon::create($request->input('end_period')->format('Y-m-d'))])
//            ->where('office_master_id', $pair->office_master_id)
//            ->where('area_master_id', $pair->area_master_id)
//            ->get();

        if ($prospects->isEmpty())return 0;
        $count = 0;
        foreach ($prospects as $prospect){
            $firstProspectActionLog = $prospect->prospectActionLogs
                ->sortBy('date')
                ->first();
            $lastProspectActionLog = $prospect->prospectActionLogs
                ->sortBy('date')
                ->last();
            if (empty($lastProspectActionLog) || empty($firstProspectActionLog)) {
                $count += 0;
            } elseif($firstProspectActionLog->stage_action_master_id === $first_stage_id){
                $count += $this->stageUpJudgment($lastProspectActionLog, $last_stage_id);
            }
        }
        return $count;
    }

    protected function NewCountFromTheUpperStage($target_column , $prospects): int
    {
//        $prospects = Prospect::with(['prospectActionLogs' => function($query) use ($request){
//            $query->whereBetween('date' , [Carbon::create($request->input('start_period')->format('Y-m-d')), Carbon::create($request->input('end_period')->format('Y-m-d'))]);
//        }])
//            ->whereBetween('date' , [Carbon::create($request->input('start_period')->format('Y-m-d')), Carbon::create($request->input('end_period')->format('Y-m-d'))])
//            ->where('office_master_id', $pair->office_master_id)
//            ->where('area_master_id', $pair->area_master_id)
//            ->get();

        if ($prospects->isEmpty())return 0;
        $count = 0;
        foreach ($prospects as $prospect){
            $firstProspectActionLog = $prospect->prospectActionLogs
                ->sortBy('date')
                ->first();
            $lastProspectActionLog = $prospect->prospectActionLogs
                ->sortBy('date')
                ->last();
            if (empty($lastProspectActionLog) || empty($firstProspectActionLog)) {
                $count += 0;
            } elseif($firstProspectActionLog->stage_action_master_id === 1 || $firstProspectActionLog->stage_action_master_id === 2){
                $count += $this->stageUpJudgment($lastProspectActionLog, $target_column);
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
                ->where('date' , '<=', Carbon::create($request->input('end_period')->format('Y-m-d'))->subMonthNoOverflow()->lastOfMonth())
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
                if ($lastProspectActionLog?->stage_action_master_id < 3){
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
                ->where('date' , '<', Carbon::create($request->input('end_period')->format('Y-m-d'))->subMonthNoOverflow()->lastOfMonth())
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

    protected function ActionCount($prospects, $target_stage, $target_column): int
    {
//        $prospects = Prospect::with(['prospectActionLogs' => function($query) use ($request){
//            $query->whereBetween('date' , [Carbon::create($request->input('start_period')->format('Y-m-d')), Carbon::create($request->input('end_period')->format('Y-m-d'))]);
//        }])
//            ->where('date', '<',Carbon::create($request->end_period->format('Y-m-d')))
//            ->where('office_master_id', $pair->office_master_id)
//            ->where('area_master_id', $pair->area_master_id)
//            ->get();
        $count = 0;
        if ($prospects->isEmpty()){return $count;}
        foreach ($prospects as $prospect){
            $count += $prospect->prospectActionLogs
                ->where('stage_action_master_id', $target_stage)
                ->where($target_column, 1)
                ->count();
        }
        return $count;
    }

    protected function division($denominator, $numerator)
    {
        if ($numerator === 0 || $denominator === 0){return 0;}
        return  round($denominator / $numerator * 100, 1);
    }

}