<?php


namespace App\UseCases\Analysis\Pursuit;


use App\Models\Prospect;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class RoomListAction
{
    public function __invoke($request): array
    {
        $this->dateConvert($request);
        //営業所の社員IDを取得
        $pairs = $this->searchPair($request);
        $PeriodProspects = $this->PeriodProspect($request);
        $withinTheMonthProspect =  $this->generateWithinTheMonthProspect($request);


        foreach ($pairs->sortBy('area_master_id') as $pair){
            $ThisProspects = $this->ThisUserModel($PeriodProspects, $pair);
            $thisWithinTheMonthProspect = $this->ThisUserModel($withinTheMonthProspect, $pair);

            $footerGraphDiscriminationRoomList = array_merge($this->StageUpCountPropertyRoomList($ThisProspects, 1, 'discrimination', $request), $this->NewCountStageUpPropertyRoomList(1, 'discrimination', $thisWithinTheMonthProspect));
            $footerGraphLatentRoomList = array_merge($this->StageUpCountPropertyRoomList($ThisProspects, 2, 'latent', $request), $this->NewCountStageUpPropertyRoomList(2, 'latent', $thisWithinTheMonthProspect));
            $footerGraphOvertRoomList = array_merge($this->StageUpCountPropertyRoomList($ThisProspects, 3, 'mediation', $request), $this->NewCountStageUpPropertyRoomList(3, 'mediation', $thisWithinTheMonthProspect));
            $analysisData[$pair->id] = array_merge(['discrimination' => $footerGraphDiscriminationRoomList], ['latent' => $footerGraphLatentRoomList], ['overt' => $footerGraphOvertRoomList]);
        }

        return $analysisData;
    }

    protected function dateConvert($request)
    {
        $month = $request->input('start_period');
        $request = $request->merge(['start_period' => Carbon::parse("${month}-01 00:00:00")]);
        $month = $request->input('end_period');
        $request = $request->merge(['end_period' => Carbon::parse("${month}-01 00:00:00")->endOfMonth()]);
        return $request;
    }

    //該当事業所の社員のIDを取得
    protected function searchPair($request): Collection
    {
        return Team::query()->where('office_master_id', $request->input('office_master_id'))->get();
    }

    protected function ThisUserModel($modelCollection, $pair)
    {
        return $modelCollection->where('area_master_id', $pair->area_master_id);
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

    //ステージアップした見込みを絞り込み
    protected function StageUpCountPropertyRoomList($prospects, $first_stage_id, $stage, $request)
    {
        $list = [];
        foreach ($prospects as $prospect) {
            $firstProspectActionLog = $prospect->prospectActionLogs
                ->where('date' , '<=', Carbon::create($request->input('end_period')->format('Y-m-d'))->subMonthNoOverflow()->lastOfMonth())
                ->sortBy('date')
                ->last();
            $lastProspectActionLog = $prospect->prospectActionLogs
                ->sortBy('date')
                ->last();
            if (empty($firstProspectActionLog)){
            } elseif($firstProspectActionLog->stage_action_master_id === $first_stage_id){
                $result = $this->stageUpJudgmentPropertyRoomList($lastProspectActionLog, $stage);
                if (!empty($result)){$list[] = $result;}
            }
        }
        return $list;
    }

    //月内新規発生のステージアップ
    protected function NewCountStageUpPropertyRoomList($first_stage_id, $last_stage_id, $prospects)
    {
        $list = [];

        if ($prospects->isEmpty())return $list;
        foreach ($prospects as $prospect){
            $firstProspectActionLog = $prospect->prospectActionLogs
                ->sortBy('date')
                ->first();
            $lastProspectActionLog = $prospect->prospectActionLogs
                ->sortBy('date')
                ->last();
            if (empty($firstProspectActionLog) || empty($lastProspectActionLog)){
            } elseif($firstProspectActionLog->stage_action_master_id === $first_stage_id){
                $result = $this->stageUpJudgmentPropertyRoomList($lastProspectActionLog, $last_stage_id);
                if (!empty($result)){$list[] = $result;}
            }
        }
        return $list;
    }

    protected function stageUpJudgmentPropertyRoomList($lastProspectActionLog, $stage)
    {
        switch ($stage){
            case 'discrimination':
                if (1 < $lastProspectActionLog->stage_action_master_id && $lastProspectActionLog->stage_action_master_id < 4 ){
                    return [
                        'id' => $lastProspectActionLog->prospect_id,
                        'PropertyName' => $lastProspectActionLog->prospect->propertyRoom->property->property_name,
                        'PropertyRoomName' => $lastProspectActionLog->prospect->propertyRoom->room_name,
                    ];
                }else{
                    return NULL;
                }
            case 'latent':
                if (2 < $lastProspectActionLog->stage_action_master_id && $lastProspectActionLog->stage_action_master_id < 4 ){
                    return [
                        'id' => $lastProspectActionLog->prospect_id,
                        'PropertyName' => $lastProspectActionLog->prospect->propertyRoom->property->property_name,
                        'PropertyRoomName' => $lastProspectActionLog->prospect->propertyRoom->room_name,
                    ];
                }else{
                    return NULL;
                }
            case 'overt':
                if ($lastProspectActionLog->stage_action_master_id && $lastProspectActionLog->stage_action_master_id < 4 ){
                    return [
                        'id' => $lastProspectActionLog->prospect_id,
                        'PropertyName' => $lastProspectActionLog->prospect->propertyRoom->property->property_name,
                        'PropertyRoomName' => $lastProspectActionLog->prospect->propertyRoom->room_name,
                    ];
                }else{
                    return NULL;
                }
            case 'mediation':
                if ($lastProspectActionLog->stage_action_master_id === 4){
                    return [
                        'id' => $lastProspectActionLog->prospect_id,
                        'PropertyName' => $lastProspectActionLog->prospect->propertyRoom->property->property_name,
                        'PropertyRoomName' => $lastProspectActionLog->prospect->propertyRoom->room_name,
                    ];
                }else{
                    return NULL;
                }
            case 'demoted':
                if ($lastProspectActionLog->stage_action_master_id === 103){
                    return [
                        'id' => $lastProspectActionLog->prospect_id,
                        'PropertyName' => $lastProspectActionLog->prospect->propertyRoom->property->property_name,
                        'PropertyRoomName' => $lastProspectActionLog->prospect->propertyRoom->room_name,
                    ];
                }else{
                    return NULL;
                }
            case 'demotedFromLatent':
                if ($lastProspectActionLog->stage_action_master_id === 103 || $lastProspectActionLog->stage_action_master_id === 1){
                    return [
                        'id' => $lastProspectActionLog->prospect_id,
                        'PropertyName' => $lastProspectActionLog->prospect->propertyRoom->property->property_name,
                        'PropertyRoomName' => $lastProspectActionLog->prospect->propertyRoom->room_name,
                    ];
                }else{
                    return NULL;
                }
            case 'demotedFromOvert':
                if ($lastProspectActionLog->stage_action_master_id === 103 || $lastProspectActionLog->stage_action_master_id < 3){
                    return [
                        'id' => $lastProspectActionLog->prospect_id,
                        'PropertyName' => $lastProspectActionLog->prospect->propertyRoom->property->property_name,
                        'PropertyRoomName' => $lastProspectActionLog->prospect->propertyRoom->room_name,
                    ];
                }else{
                    return NULL;
                }
            case 'latentFromDiscrimination':
                if ($lastProspectActionLog->stage_action_master_id === 1){
                    return [
                        'id' => $lastProspectActionLog->prospect_id,
                        'PropertyName' => $lastProspectActionLog->prospect->propertyRoom->property->property_name,
                        'PropertyRoomName' => $lastProspectActionLog->prospect->propertyRoom->room_name,
                    ];
                }else{
                    return NULL;
                }
            case 'overtFromLowerStage':
                if ($lastProspectActionLog->stage_action_master_id < 3){
                    return [
                        'id' => $lastProspectActionLog->prospect_id,
                        'PropertyName' => $lastProspectActionLog->prospect->propertyRoom->property->property_name,
                        'PropertyRoomName' => $lastProspectActionLog->prospect->propertyRoom->room_name,
                    ];
                }else{
                    return NULL;
                }
            default:
                return NULL;
        }
    }
}