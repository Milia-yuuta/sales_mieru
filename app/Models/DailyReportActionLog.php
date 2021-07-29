<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyReportActionLog extends Model
{
    protected $fillable = [
        'daily_report_id', 'action_master_id', 'start_time', 'end_time','created_at', 'updated_at'
    ];



    /*
   |--------------------------------------------------------------------------
   | Relations
   |--------------------------------------------------------------------------
   */

    public function dailyReport()
    {
        return $this->belongsTo(DailyReport::class);
    }

    public function actionMaster()
    {
        return $this->belongsTo(ActionMaster::class);
    }

}
