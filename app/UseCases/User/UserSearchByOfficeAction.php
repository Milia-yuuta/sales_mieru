<?php


namespace App\UseCases\User;


use App\Models\User;

class UserSearchByOfficeAction
{
    public function __invoke($office_id): array
    {
        $userList = [];
        foreach (User::where('office_master_id', $office_id)->get() as $user){
            $userList += [$user->id => $user->FullName];
        }
        return $userList;
    }
}