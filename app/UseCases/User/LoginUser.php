<?php

namespace App\UseCases\User;

use App\Models\User;
use Auth;

class LoginUser
{
    public function __invoke($request)
    {
        return Auth::user();
    }
}