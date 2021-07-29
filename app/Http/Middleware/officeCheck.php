<?php

namespace App\Http\Middleware;

use App\Models\Team;
use Closure;

class officeCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->office_master_id){
            $checkTeam = Team::where('office_master_id', $request->office_master_id)->get();
            if ($checkTeam->isEmpty()){
                return redirect()->route('home')->withInput()->with('flash_error', '該当事業所にエリア担当者が不在です。');
            }
        }

        return $next($request);
    }
}
