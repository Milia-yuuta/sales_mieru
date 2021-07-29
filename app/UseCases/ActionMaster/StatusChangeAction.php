<?php


namespace App\UseCases\ActionMaster;
use App\Models\ActionMaster;

class StatusChangeAction
{
    public function __invoke($stage): array
    {
        switch ($stage){
            case 1:
                return $this->ArrayGenerate(2);
            case 2:
                return $this->ArrayGenerate(3);
            case 3:
                return $this->ArrayGenerate(4);
            case 4:
                return $this->ArrayGenerate(5);
            case 103:
                return $this->ArrayGenerate(22);

        }
    }

    protected function ArrayGenerate($group_num)
    {
        $StatusList = [];
        foreach (ActionMaster::where('group_num', $group_num)->select('id','action_name')->get()->toArray() as $value){
            $StatusList += [$value['id'] => $value['action_name']];
        }
        return $StatusList;
    }
}