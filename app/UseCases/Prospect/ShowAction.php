<?php


namespace App\UseCases\Prospect;

use App\Models\Prospect;
use App\Models\User;
use App\Models\ProspectActionLog;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ShowAction
{
    public function __invoke($request): array
    {
        $prospects = Prospect::query()
            ->leftJoin('prospect_action_logs', 'prospects.id', '=', 'prospect_action_logs.prospect_id')
            ->leftJoin('next_prospect_action_logs', 'prospect_action_logs.id', '=', 'next_prospect_action_logs.prospect_action_log_id')
            ->select([
                DB::raw('prospect_action_logs.id as id'),
                'prospects.office_master_id',
                'prospects.area_master_id',
                'prospects.date',
                'prospects.generating_medium_master_id',
                'prospects.source_media_site_master_id',
                'prospects.remark',
                'prospect_action_logs.prospect_id',
                'prospect_action_logs.user_id',
                'prospect_action_logs.stage_action_master_id',
                'prospect_action_logs.status_action_master_id',
                'prospect_action_logs.date as prospect_action_logs_date',
                'prospect_action_logs.stage_stay_date',
                'prospect_action_logs.TEL_home',
                'prospect_action_logs.send_letter',
                'prospect_action_logs.local_letter',
                'prospect_action_logs.email',
                'prospect_action_logs.visit',
                'prospect_action_logs.pursuit_other',
                'prospect_action_logs.assessment_report_email',
                'prospect_action_logs.send_assessment_report',
                'prospect_action_logs.web_negotiation',
                'prospect_action_logs.assessment_negotiation',
                'prospect_action_logs.re-negotiation',
                'prospect_action_logs.visit_caretaker',
                'prospect_action_logs.TEL_caretaker',
                'prospect_action_logs.on-site_check',
                'prospect_action_logs.research_other',
                'prospect_action_logs.re_TEL',
                'prospect_action_logs.re_email',
                'prospect_action_logs.re_letter',
                'prospect_action_logs.re_hp',
                'prospect_action_logs.re_site',
                'prospect_action_logs.re_other',
                'prospect_action_logs.result',
                'next_prospect_action_logs.id as next_prospect_action_logs_id',
                'next_prospect_action_logs.next_action_date',
                'next_prospect_action_logs.TEL_home as next_TEL_home',
                'next_prospect_action_logs.send_letter as next_send_letter',
                'next_prospect_action_logs.local_letter as next_local_letter',
                'next_prospect_action_logs.email as next_email',
                'next_prospect_action_logs.visit as next_visit',
                'next_prospect_action_logs.pursuit_other as next_pursuit_other',
                'next_prospect_action_logs.assessment_report_email as next_assessment_report_email',
                'next_prospect_action_logs.send_assessment_report as next_send_assessment_report',
                'next_prospect_action_logs.web_negotiation as next_web_negotiation',
                'next_prospect_action_logs.assessment_negotiation as next_assessment_negotiation',
                'next_prospect_action_logs.re-negotiation as next_re-negotiation',
                'next_prospect_action_logs.visit_caretaker as next_visit_caretaker',
                'next_prospect_action_logs.TEL_caretaker as next_TEL_caretaker',
                'next_prospect_action_logs.on-site_check as next_on-site_check',
                'next_prospect_action_logs.research_other as next_research_other',
                'next_prospect_action_logs.deleted_at as next_deleted_at',
            ])
            ->where('prospect_action_logs.prospect_id', $request->id)
            ->where('next_prospect_action_logs.deleted_at', NULL)
            ->orderBy('id', 'DESC')
            ->get()->toArray();

        foreach ($prospects as $index => $prospect){
            $prospects[$index] = array_merge(
                $prospects[$index],
                ['action' => $this->ActionList($prospect)],
                ['next_action' => $this->NextActionList($prospect)],
                ['CssStage' => $this->CssStage($prospect)],
                ['UserName' => User::find($prospect['user_id'])?->sei.User::find($prospect['user_id'])?->mei]
            );
        }
        return $prospects;
    }

    //登録した追客行動一覧を配列でreturn
    private function ActionList($prospect)
    {
        $actionList = [];
        unset($prospect['user_id'], $prospect['id'], $prospect['prospect_id'], $prospect['stage_action_master_id'], $prospect['status_action_master_id'],$prospect['created_at'], $prospect['updated_at'], $prospect['result']);
        $actionArray = array_filter($prospect);
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
                    $actionList[] = "戸別訪問在宅";
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
                    $actionList[] = "お客様よりTEL";
                    continue 2;
                case "re_email":
                    $actionList[] = "お客様よりメール";
                    continue 2;
                case "re_letter":
                    $actionList[] = "お客様より手紙・FAX";
                    continue 2;
                case "re_hp":
                    $actionList[] = "お客様より当社HP反響";
                    continue 2;
                case "re_site":
                    $actionList[] = "お客様より一括査定サイト";
                    continue 2;
                case "re_other":
                    $actionList[] = "お客様よりその他";
                    continue 2;
            }
        }
        return $actionList;
    }

    //登録した追客行動一覧を配列でreturn
    private function NextActionList($prospect)
    {
        $actionList = [];
        unset($prospect['user_id'], $prospect['id'], $prospect['prospect_id'], $prospect['stage_action_master_id'], $prospect['status_action_master_id'],$prospect['created_at'], $prospect['updated_at'], $prospect['result']);
        $actionArray = array_filter($prospect);
        foreach ($actionArray as $key => $value){
            switch ($key){
                case "next_TEL_home":
                    $actionList[] = "見込TEL";
                    continue 2;
                case "next_send_letter":
                    $actionList[] = "手紙送付";
                    continue 2;
                case "next_local_letter":
                    $actionList[] = "現地手紙";
                    continue 2;
                case "next_email":
                    $actionList[] = "メール送信";
                    continue 2;
                case "next_visit":
                    $actionList[] = "戸別訪問";
                    continue 2;
                case "next_pursuit_other":
                    $actionList[] = "追客その他";
                    continue 2;
                case "next_assessment_report_email":
                    $actionList[] = "査定書メール";
                    continue 2;
                case "next_send_assessment_report":
                    $actionList[] = "査定書送付";
                    continue 2;
                case "next_web_negotiation":
                    $actionList[] = "web商談";
                    continue 2;
                case "next_assessment_negotiation":
                    $actionList[] = "査定・商談";
                    continue 2;
                case "next_re-negotiation":
                    $actionList[] = "再商談";
                    continue 2;
                case "next_visit_caretaker":
                    $actionList[] = "管理人訪問";
                    continue 2;
                case "next_TEL_caretaker":
                    $actionList[] = "管理人TEL";
                    continue 2;
                case "next_on-site_check":
                    $actionList[] = "現地チェック";
                    continue 2;
                case "next_research_other":
                    $actionList[] = "調査その他";
                    continue 2;
                case "next_re_TEL":
                    $actionList[] = "TEL";
                    continue 2;
                case "next_re_email":
                    $actionList[] = "メール";
                    continue 2;
                case "next_re_letter":
                    $actionList[] = "手紙・FAX";
                    continue 2;
                case "next_re_hp":
                    $actionList[] = "当社HP反響";
                    continue 2;
                case "next_re_site":
                    $actionList[] = "一括査定サイト";
                    continue 2;
                case "next_re_other":
                    $actionList[] = "お客様反応その他";
                    continue 2;
            }
        }
        return $actionList;
    }

    private function CssStage($prospect)
    {
        $stage_id = $prospect['stage_action_master_id'];
        switch ($stage_id){
            case 1:
                return "discrimination";
            case 2:
                return "latent";
            case 3:
                return "overt";
            case 4:
                return "mediation";
            case 5:
                return "ExcavationDemotion";
        }
    }
}
