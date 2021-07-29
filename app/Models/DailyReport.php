<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    protected $fillable = [
        'user_id', 'date', 'plan_check', 'result_check', 'created_at', 'updated_at'
    ];

    protected $dates = ['date'];

    /*
   |--------------------------------------------------------------------------
   | Relations
   |--------------------------------------------------------------------------
   */

    public function dailyReportActionLogs()
    {
        return $this->hasMany(DailyReportActionLog::class);
    }

    public function resultDailyReportActionLogs()
    {
        return $this->hasMany(ResultDailyReportActionLog::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
