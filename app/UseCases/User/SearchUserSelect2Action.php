<?php

namespace App\UseCases\User;

use App\Models\User;

use Auth;
use Illuminate\Support\Facades\DB;

class SearchUserSelect2Action
{
    public function __invoke()
    {
        $users = User::select('id',DB::raw('CONCAT(sei,mei) as name'))->get()->toArray();
        $UserListSelect2 = [];
        foreach ($users as $value){
            $UserListSelect2 += [$value['id'] => $value['name']];
        }
        return $UserListSelect2;
    }
}