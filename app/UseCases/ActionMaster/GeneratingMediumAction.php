<?php


namespace App\UseCases\ActionMaster;
use App\Models\ActionMaster;

class GeneratingMediumAction
{
    public function __invoke($medium): array
    {
        switch ($medium){
            case 43:
                //エリア発掘が親の媒体
                $area = [0 => '---'];
                foreach (ActionMaster::whereIn('group_num', [9])->select('id','action_name')->get()->toArray() as $value){
                    $area += [$value['id'] => $value['action_name']];
                }
                return $area;
            case 44:
                //社内発掘が親の媒体
                $company = [0 => '---'];
                foreach (ActionMaster::whereIn('group_num', [10, 11, 12])->select('id','action_name')->get()->toArray() as $value){
                    $company += [$value['id'] => $value['action_name']];
                }
                return $company;
            case 45:
                //反響が親の媒体
                $response = [0 => '---'];
                foreach (ActionMaster::where('group_num', 13)->select('id','action_name')->get()->toArray() as $value){
                    $response += [$value['id'] => $value['action_name']];
                }
                return $response;
            case 46:
                //前取りが親の媒体
                $Re = [0 => '---'];
                foreach (ActionMaster::where('group_num', 14)->select('id','action_name')->get()->toArray() as $value){
                    $Re += [$value['id'] => $value['action_name']];
                }
                return $Re;
            case 47:
                //その他が親の媒体
                $other = [0 => '---'];
                foreach (ActionMaster::where('group_num', 15)->select('id','action_name')->get()->toArray() as $value){
                    $other += [$value['id'] => $value['action_name']];
                }
                return $other;
        }
    }
}