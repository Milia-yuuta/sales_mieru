<?php


namespace App\UseCases\ProspectActionLog;


use Carbon\Carbon;
use App\Models\ProspectActionLog;

class analysisUsedInDailyReports
{
    public function __invoke($request, $date): array
    {
        $TodayProspectActionLog = $this->TodayProspectActionLog($request, $date);
        $ToMonthProspectActionLog = $this->ToMonthProspectActionLog($request, $date);
        $HalfPeriodProspectActionLog = $this->HalfPeriodProspectActionLog($request, $date);
        $discrimination = $this->checkCount($TodayProspectActionLog->where('stage_action_master_id', 1), $ToMonthProspectActionLog->where('stage_action_master_id', 1), $HalfPeriodProspectActionLog->where('stage_action_master_id', 1));
        $latent = $this->checkCount($TodayProspectActionLog->where('stage_action_master_id', 2), $ToMonthProspectActionLog->where('stage_action_master_id', 2), $HalfPeriodProspectActionLog->where('stage_action_master_id', 2));
        $overt = $this->checkCount($TodayProspectActionLog->where('stage_action_master_id', 3), $ToMonthProspectActionLog->where('stage_action_master_id', 3), $HalfPeriodProspectActionLog->where('stage_action_master_id', 3));
        return array_merge(['discrimination' => $discrimination], ['latent' => $latent], ['overt' => $overt]);
    }


    private function TodayProspectActionLog($request, $date)
    {
        return
            ProspectActionLog::where('user_id', $request->input('SearchUser'))
                ->whereDate('date',$date)
                ->get();
    }

    private function ToMonthProspectActionLog($request, $date)
    {
        return
            ProspectActionLog::where('user_id', $request->input('SearchUser'))
                ->whereYear('date', $date->year)
                ->whereMonth('date', $date->month)
                ->whereDay('date', '<',$date->day)
                ->get();
    }

    private function HalfPeriodProspectActionLog($request, $date)
    {
        $prospectBase = ProspectActionLog::where('user_id', $request->input('SearchUser'));
        if (4 <= $date->month && $date->month <= 9){
            $StartPeriod = Carbon::createMidnightDate($date->year, 4, 1);
            $EndPeriod = $date;
            return $prospectBase->whereBetween('date', [$StartPeriod, $EndPeriod])->get();
        }elseif (10 <= $date->month){
            $StartPeriod = Carbon::createMidnightDate($date->year, 10, 1);
            $EndPeriod = $date;
            return $prospectBase->whereBetween('date', [$StartPeriod, $EndPeriod])->get();
        }elseif ($date->month <= 3) {
            $StartPeriod = Carbon::createMidnightDate($date->year, 10, 1)->subYear();
            $EndPeriod = $date;
            return $prospectBase->whereBetween('date', [$StartPeriod, $EndPeriod])->get();
        }
    }

    private function checkCount($TodayProspectActionLog, $ToMonthProspectActionLog, $HalfPeriodProspectActionLog): array
    {
        return [
            'TELHomeToday' => $TodayProspectActionLog->sum('TEL_home'),
            'TELHomeToMonth' => $ToMonthProspectActionLog->sum('TEL_home'),
            'TELHomeToPeriod' => $HalfPeriodProspectActionLog->sum('TEL_home'),

            'SendLetterToday' => $TodayProspectActionLog->sum('send_letter'),
            'SendLetterToMonth' => $ToMonthProspectActionLog->sum('send_letter'),
            'SendLetterToPeriod' => $HalfPeriodProspectActionLog->sum('send_letter'),

            'LocalLetterToday' => $TodayProspectActionLog->sum('local_letter'),
            'LocalLetterToMonth' => $ToMonthProspectActionLog->sum('local_letter'),
            'LocalLetterToPeriod' => $HalfPeriodProspectActionLog->sum('local_letter'),

            'EmailToday' => $TodayProspectActionLog->sum('email'),
            'EmailToMonth' => $ToMonthProspectActionLog->sum('email'),
            'EmailToPeriod' => $HalfPeriodProspectActionLog->sum('email'),

            'VisitToday' => $TodayProspectActionLog->sum('visit'),
            'VisitToMonth' => $ToMonthProspectActionLog->sum('visit'),
            'VisitToPeriod' => $HalfPeriodProspectActionLog->sum('visit'),

            'PursuitOtherToday' => $TodayProspectActionLog->sum('pursuit_other'),
            'PursuitOtherMonth' => $ToMonthProspectActionLog->sum('pursuit_other'),
            'PursuitOtherPeriod' => $HalfPeriodProspectActionLog->sum('pursuit_other'),

            'AssessmentReportEmailToday' => $TodayProspectActionLog->sum('assessment_report_email'),
            'AssessmentReportEmailToMonth' => $ToMonthProspectActionLog->sum('assessment_report_email'),
            'AssessmentReportEmailToPeriod' => $HalfPeriodProspectActionLog->sum('assessment_report_email'),

            'SendAssessmentReportToday' => $TodayProspectActionLog->sum('send_assessment_report'),
            'SendAssessmentReportToMonth' => $ToMonthProspectActionLog->sum('send_assessment_report'),
            'SendAssessmentToPeriod' => $HalfPeriodProspectActionLog->sum('send_assessment_report'),

            'WebNegotiationToday' => $TodayProspectActionLog->sum('web_negotiation'),
            'WebNegotiationToMonth' => $ToMonthProspectActionLog->sum('web_negotiation'),
            'WebNegotiationToPeriod' => $HalfPeriodProspectActionLog->sum('web_negotiation'),

            'AssessmentNegotiationToday' => $TodayProspectActionLog->sum('assessment_negotiation'),
            'AssessmentNegotiationToMonth' => $ToMonthProspectActionLog->sum('assessment_negotiation'),
            'AssessmentNegotiationToPeriod' => $HalfPeriodProspectActionLog->sum('assessment_negotiation'),

            'ReNegotiationToday' => $TodayProspectActionLog->sum('re-negotiation'),
            'ReNegotiationToMonth' => $ToMonthProspectActionLog->sum('re-negotiation'),
            'ReNegotiationToPeriod' => $HalfPeriodProspectActionLog->sum('re-negotiation'),

            'VisitCaretakerToday' => $TodayProspectActionLog->sum('visit_caretaker'),
            'VisitCaretakerToMonth' => $ToMonthProspectActionLog->sum('visit_caretaker'),
            'VisitCaretakerToPeriod' => $HalfPeriodProspectActionLog->sum('visit_caretaker'),

            'TELCaretakerToday' => $TodayProspectActionLog->sum('TEL_caretaker'),
            'TELCaretakerToMonth' => $ToMonthProspectActionLog->sum('TEL_caretaker'),
            'TELCaretakerToPeriod' => $HalfPeriodProspectActionLog->sum('TEL_caretaker'),

            'OnSiteCheckToday' => $TodayProspectActionLog->sum('on-site_check'),
            'OnSiteCheckToMonth' => $ToMonthProspectActionLog->sum('on-site_check'),
            'OnSiteCheckToPeriod' => $HalfPeriodProspectActionLog->sum('on-site_check'),

            'ResearchOtherToday' => $TodayProspectActionLog->sum('research_other'),
            'ResearchOtherToMonth' => $ToMonthProspectActionLog->sum('research_other'),
            'ResearchOtherToPeriod' => $HalfPeriodProspectActionLog->sum('research_other'),

            'ReTELToday' => $TodayProspectActionLog->sum('re_TEL'),
            'ReTELToMonth' => $ToMonthProspectActionLog->sum('re_TEL'),
            'ReTELToPeriod' => $HalfPeriodProspectActionLog->sum('re_TEL'),

            'ReEmailToday' => $TodayProspectActionLog->sum('re_email'),
            'ReEmailToMonth' => $ToMonthProspectActionLog->sum('re_email'),
            'ReEmailToPeriod' => $HalfPeriodProspectActionLog->sum('re_email'),

            'ReLetterToday' => $TodayProspectActionLog->sum('re_letter'),
            'ReLetterToMonth' => $ToMonthProspectActionLog->sum('re_letter'),
            'ReLetterToPeriod' => $HalfPeriodProspectActionLog->sum('re_letter'),

            'ReHpToday' => $TodayProspectActionLog->sum('re_hp'),
            'ReHpToMonth' => $ToMonthProspectActionLog->sum('re_hp'),
            'ReHpToPeriod' => $HalfPeriodProspectActionLog->sum('re_hp'),

            'ReSiteToday' => $TodayProspectActionLog->sum('re_site'),
            'ReSiteToMonth' => $ToMonthProspectActionLog->sum('re_site'),
            'ReSiteToPeriod' => $HalfPeriodProspectActionLog->sum('re_site'),

            'ReOtherToday' => $TodayProspectActionLog->sum('re_other'),
            'ReOtherToMonth' => $ToMonthProspectActionLog->sum('re_other'),
            'ReOtherToPeriod' => $HalfPeriodProspectActionLog->sum('re_other'),
        ];
    }
}