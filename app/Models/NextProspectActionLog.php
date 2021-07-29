<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NextProspectActionLog extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'prospect_id', 'prospect_action_log_id','stage_action_master_id', 'status_action_master_id',
        'TEL_home', 'send_letter', 'local_letter', 'email', 'visit', 'pursuit_other', 'assessment_report_email', 'send_assessment_report', 'web_negotiation',
        'assessment_negotiation', 're-negotiation', 'visit_caretaker', 'TEL_caretaker', 'on-site_check', 'research_other',
        're_TEL', 're_email', 're_letter', 're_hp', 're_site', 're_other', 'next_action_date', 'result',
        'created_at', 'updated_at'
    ];

    protected $dates = ['deleted_at'];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function ProspectActionLog()
    {
        return $this->belongsTo(ProspectActionLog::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Custum Methods
    |--------------------------------------------------------------------------
    */

    //登録した追客行動一覧を配列でreturn
    public function getActionListAttribute()
    {
        $actionArray = $this->toarray();
        $actionList = [];
        unset($actionArray['user_id'], $actionArray['id'], $actionArray['prospect_id'], $actionArray['stage_action_master_id'], $actionArray['status_action_master_id'],$actionArray['created_at'], $actionArray['updated_at'], $actionArray['result']);
        $actionArray = array_filter($actionArray);
        foreach ($actionArray as $key => $value){
            switch ($key){
                case "TEL_home":
                    $actionList[] = "見込TEL";
                    continue 2;
                case "send_letter":
                    $actionList[] = "手紙送付";
                    continue 2;
                case "local_letter":
                    $actionList[] = "現地手紙";
                    continue 2;
                case "email":
                    $actionList[] = "メール送信";
                    continue 2;
                case "visit":
                    $actionList[] = "戸別訪問";
                    continue 2;
                case "pursuit_other":
                    $actionList[] = "追客その他";
                    continue 2;
                case "assessment_report_email":
                    $actionList[] = "査定書メール";
                    continue 2;
                case "send_assessment_report":
                    $actionList[] = "査定書送付";
                    continue 2;
                case "web_negotiation":
                    $actionList[] = "web商談";
                    continue 2;
                case "assessment_negotiation":
                    $actionList[] = "査定・商談";
                    continue 2;
                case "re-negotiation":
                    $actionList[] = "再商談";
                    continue 2;
                case "visit_caretaker":
                    $actionList[] = "管理人訪問";
                    continue 2;
                case "TEL_caretaker":
                    $actionList[] = "管理人TEL";
                    continue 2;
                case "on-site_check":
                    $actionList[] = "現地チェック";
                    continue 2;
                case "research_other":
                    $actionList[] = "調査その他";
                    continue 2;
                case "re_TEL":
                    $actionList[] = "TEL";
                    continue 2;
                case "re_email":
                    $actionList[] = "メール";
                    continue 2;
                case "re_letter":
                    $actionList[] = "手紙・FAX";
                    continue 2;
                case "re_hp":
                    $actionList[] = "当社HP反響";
                    continue 2;
                case "re_site":
                    $actionList[] = "一括査定サイト反響";
                    continue 2;
                case "re_other":
                    $actionList[] = "お客様反応その他";
                    continue 2;
            }
        }
        return $actionList;
    }

    //次回アクション判定
    public function getNextActionJudgeAttribute(): bool
    {
        if ($this->TEL_home == 1 ||
            $this->send_letter == 1 ||
            $this->local_letter == 1 ||
            $this->email == 1 ||
            $this->visit == 1 ||
            $this->pursuit_other == 1 ||
            $this->assessment_report_email == 1 ||
            $this->send_assessment_report == 1 ||
            $this->web_negotiation == 1 ||
            $this->assessment_negotiation == 1 ||
            $this['re-negotiation'] == 1 ||
            $this->visit_caretaker == 1 ||
            $this->TEL_caretaker == 1 ||
            $this['on-site_check'] == 1 ||
            $this->research_other == 1 ||
            $this->re_TEL == 1 ||
            $this->re_email == 1 ||
            $this->re_letter == 1 ||
            $this->re_hp == 1 ||
            $this->re_site == 1 ||
            $this->re_other == 1){
            return true;
        }else{
            return false;
        }
    }
}
