<?php

namespace App\Http\Controllers;

use App\UseCases\User\UserSearchByOfficeAction;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userSearch($office_id, UserSearchByOfficeAction $UserSearchByOfficeAction): \Illuminate\Http\JsonResponse
    {
        return response()->json($UserSearchByOfficeAction($office_id));
    }
}
