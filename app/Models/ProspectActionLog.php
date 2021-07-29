<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProspectActionLog extends Model
{
    use Sortable;
    use SoftDeletes;


    protected $fillable = [
            'user_id',
            'prospect_id',
            'stage_action_master_id',
            'status_action_master_id',
            'date',
            'stage_stay_date',
            'TEL_home',
            'send_letter',
            'local_letter',
            'email',
            'visit',
            'pursuit_other',
            'assessment_report_email',
            'send_assessment_report',
            'web_negotiation',
            'assessment_negotiation',
            're-negotiation',
            'visit_caretaker',
            'TEL_caretaker',
            'on-site_check',
            'research_other',
            're_TEL',
            're_email',
            're_letter',
            're_hp',
            're_site',
            're_other',
            'result',
            'created_at',
            'updated_at',
    ];

    protected $dates = ['deleted_at'];

    public $sortable = ['stage_action_master_id'];


    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */
    public function stage()
    {
        return $this->belongsTo(ActionMaster::class, 'stage_action_master_id');
    }


    public function status()
    {
        return $this->belongsTo(ActionMaster::class, 'status_action_master_id');
    }


    public function prospect(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Prospect::class);
    }


    public function NextProspectActionLogs(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(NextProspectActionLog::class);
    }


    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Custum Methods
    |--------------------------------------------------------------------------
    */
    //最終追客経過日数取得
    public function DaysElapsed($request): int
    {
        return Carbon::now()->diffInDays($request);
    }


    //stage滞在日数
    public function StageLengthStay($request)
    {
        $ProspectActionLogInstance = ProspectActionLog::where('prospect_id', $request)->orderByDesc('updated_at')
                                                      ->select('updated_at', 'stage_action_master_id')->get();
        $now = Carbon::now();
        $stage = $ProspectActionLogInstance[0]->stage_action_master_id;
        $stage_date = null;
        foreach ($ProspectActionLogInstance as $ProspectActionLog) {
            if ($stage !== $ProspectActionLog['stage_action_master_id']) {
                return $stage_date;
            }
            $stage_date = $now->diffInDays($ProspectActionLog['updated_at']);
            $stage = $ProspectActionLog['stage_action_master_id'];
        }

        return $now->diffInDays($ProspectActionLogInstance->sortBy('updated_at')->first()->updated_at);
    }


    public function getCssStageNameAttribute()
    {
        $stage_id = $this->stage_action_master_id;
        switch ($stage_id) {
            case 1:
                return "discrimination";
            case 2:
                return "latent";
            case 3:
                return "overt";
            case 4:
                return "mediation";
        }
    }


    public function getLogStageNameAttribute()
    {
        $prospect_id = $this->prospect_id;
        $date = $this->date;
        $time = $this->created_at;
        $now_stage_id = $this->stage_action_master_id;
        $last_stage_id = ProspectActionLog::where('prospect_id', $prospect_id)->where('date', $date)
                                          ->where('created_at', '<', $time)->get()->sortByDesc('created_at')->first();
        empty($last_stage_id) ? $last_stage_id = $now_stage_id : $last_stage_id = $last_stage_id->stage_action_master_id;

        switch ($last_stage_id) {
            case 1:
                if ($now_stage_id === 1) {
                    $stage_name = "discrimination";
                } elseif ($now_stage_id === 2) {
                    $stage_name = "report_discrimination_up";
                } elseif ($now_stage_id === 3) {
                    $stage_name = "report_latent_up";
                }

                return $stage_name;
            case 2:
                if ($now_stage_id === 1) {
                    $stage_name = "report_latent_down";
                } elseif ($now_stage_id === 2) {
                    $stage_name = "latent";
                } elseif ($now_stage_id === 3) {
                    $stage_name = "report_overt_up";
                }

                return $stage_name;
            case 3:
                if ($now_stage_id === 1) {
                    $stage_name = "report_overt_w_down";
                } elseif ($now_stage_id === 2) {
                    $stage_name = "report_overt_down";
                } elseif ($now_stage_id === 3) {
                    $stage_name = "overt";
                }

                return $stage_name;
        }
    }


    //登録した追客行動一覧を配列でreturn
    public function getActionListAttribute()
    {
        $actionArray = $this->toarray();
        $actionList = [];
        unset($actionArray['user_id'], $actionArray['id'], $actionArray['prospect_id'], $actionArray['stage_action_master_id'], $actionArray['status_action_master_id'], $actionArray['created_at'], $actionArray['updated_at'], $actionArray['result']);
        $actionArray = array_filter($actionArray);
        foreach ($actionArray as $key => $value) {
            switch ($key) {
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
                    $actionList[] = "一括査定サイト";
                    continue 2;
                case "re_other":
                    $actionList[] = "お客様反応その他";
                    continue 2;
            }
        }

        return $actionList;
    }


    //過去に反応が追客登録されているかチェック
    public function ResponseCheck($prospect_id): bool
    {
        $prospectActionLogs = $this->where('prospect_id', $prospect_id)->get();

        if (
                $prospectActionLogs->where('re_TEL', 1)->isNotEmpty() ||
                $prospectActionLogs->where('re_email', 1)->isNotEmpty() ||
                $prospectActionLogs->where('re_letter', 1)->isNotEmpty() ||
                $prospectActionLogs->where('re_hp', 1)->isNotEmpty() ||
                $prospectActionLogs->where('re_site', 1)->isNotEmpty() ||
                $prospectActionLogs->where('re_other', 1)->isNotEmpty() ||
                $prospectActionLogs->where('TEL_home', 1)->isNotEmpty() ||
                $prospectActionLogs->where('visit', 1)->isNotEmpty()
        ) {
            return true;
        }

        return false;
    }


    //過去に査定が追客登録されているかチェック
    public function AssessmentCheck($prospect_id): bool
    {
        if ($this->where('prospect_id', $prospect_id)->get()->where('assessment_negotiation', 1)->isNotEmpty()) {
            return true;
        } else {
            return false;
        }
    }


    //アクションがチェックされていないか
    public function getJudgeActionAttribute()
    {
        if (
                $this['TEL_home'] === 0 &&
                $this['send_letter'] === 0 &&
                $this['local_letter'] === 0 &&
                $this['email'] === 0 &&
                $this['visit'] === 0 &&
                $this['pursuit_other'] === 0 &&
                $this['assessment_report_email'] === 0 &&
                $this['send_assessment_report'] === 0 &&
                $this['web_negotiation'] === 0 &&
                $this['assessment_negotiation'] === 0 &&
                $this['re-negotiation'] === 0 &&
                $this['visit_caretaker'] === 0 &&
                $this['TEL_caretaker'] === 0 &&
                $this['on-site_check'] === 0 &&
                $this['research_other'] === 0 &&
                $this['re_TEL'] === 0 &&
                $this['re_email'] === 0 &&
                $this['re_letter'] === 0 &&
                $this['re_hp'] === 0 &&
                $this['re_site'] === 0 &&
                $this['re_other'] === 0 &&
                $this['result'] === null) {
            return true;
        } else {
            return false;
        }

    }
}
