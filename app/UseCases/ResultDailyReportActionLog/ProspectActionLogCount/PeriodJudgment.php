<?php


namespace App\UseCases\ResultDailyReportActionLog\ProspectActionLogCount;

use Carbon\Carbon;
use App\Models\ProspectActionLog;
use Illuminate\Support\Facades\Auth;

class PeriodJudgment
{
    protected function Period()
    {
        $now = new Carbon();
        if (3 > $now->month && $now->month > 10){
            $ProspectActionLogInstance = ProspectActionLog::query()
                ->where('user_id', Auth::user()->id)
                ->whereYear('created_at', $now->year)
                ->whereMonth('created_at', 4)
                ->orWhereMonth('created_at', 5)
                ->orWhereMonth('created_at', 6)
                ->orWhereMonth('created_at', 7)
                ->orWhereMonth('created_at', 8)
                ->orWhereMonth('created_at', 9);

            return $ProspectActionLogInstance;
        }else{
            $ProspectActionLogInstance = ProspectActionLog::query()
                ->where('user_id', Auth::user()->id)
                ->whereYear('created_at', $now->year)
                ->whereMonth('created_at', 1)
                ->orWhereMonth('created_at', 2)
                ->orWhereMonth('created_at', 3)
                ->orWhereMonth('created_at', 10)
                ->orWhereMonth('created_at', 11)
                ->orWhereMonth('created_at', 12);

            return $ProspectActionLogInstance;
        }
    }

    protected function ToMonth()
    {
        $now = new Carbon();
        $ProspectActionLogInstance = ProspectActionLog::query()
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->where('user_id', Auth::user()->id);
        return $ProspectActionLogInstance;
    }

    protected function ToDay()
    {
        $ProspectActionLogInstance = ProspectActionLog::query()
            ->where('created_at', Carbon::now()->format('Y-m-d'))
            ->where('user_id', Auth::user()->id);
        return $ProspectActionLogInstance;
    }
    
    protected function ArrayInsert($Today, $ToMonth, $ToPeriod): array
    {
        return [
            'TELHomeToday' => $Today->sum('TEL_home'),
            'TELHomeToMonth' => $ToMonth->sum('TEL_home'),
            'TELHomeToPeriod' => $ToPeriod->sum('TEL_home'),

            'SendLetterToday' => $Today->sum('send_letter'),
            'SendLetterToMonth' => $ToMonth->sum('send_letter'),
            'SendLetterToPeriod' => $ToPeriod->sum('send_letter'),

            'LocalLetterToday' => $Today->sum('local_letter'),
            'LocalLetterToMonth' => $ToMonth->sum('local_letter'),
            'LocalLetterToPeriod' => $ToPeriod->sum('local_letter'),

            'EmailToday' => $Today->sum('email'),
            'EmailToMonth' => $ToMonth->sum('email'),
            'EmailToPeriod' => $ToPeriod->sum('email'),

            'VisitToday' => $Today->sum('visit'),
            'VisitToMonth' => $ToMonth->sum('visit'),
            'VisitToPeriod' => $ToPeriod->sum('visit'),

            'PursuitOtherToday' => $Today->sum('pursuit_other'),
            'PursuitOtherMonth' => $ToMonth->sum('pursuit_other'),
            'PursuitOtherPeriod' => $ToPeriod->sum('pursuit_other'),

            'AssessmentReportEmailToday' => $Today->sum('assessment_report_email'),
            'AssessmentReportEmailToMonth' => $ToMonth->sum('assessment_report_email'),
            'AssessmentReportEmailToPeriod' => $ToPeriod->sum('assessment_report_email'),

            'SendAssessmentReportToday' => $Today->sum('send_assessment_report'),
            'SendAssessmentReportToMonth' => $ToMonth->sum('send_assessment_report'),
            'SendAssessmentToPeriod' => $ToPeriod->sum('send_assessment_report'),

            'WebNegotiationToday' => $Today->sum('web_negotiation'),
            'WebNegotiationToMonth' => $ToMonth->sum('web_negotiation'),
            'WebNegotiationToPeriod' => $ToPeriod->sum('web_negotiation'),

            'AssessmentNegotiationToday' => $Today->sum('assessment_negotiation'),
            'AssessmentNegotiationToMonth' => $ToMonth->sum('assessment_negotiation'),
            'AssessmentNegotiationToPeriod' => $ToPeriod->sum('assessment_negotiation'),

            'ReNegotiationToday' => $Today->sum('re-negotiation'),
            'ReNegotiationToMonth' => $ToMonth->sum('re-negotiation'),
            'ReNegotiationToPeriod' => $ToPeriod->sum('re-negotiation'),

            'VisitCaretakerToday' => $Today->sum('visit_caretaker'),
            'VisitCaretakerToMonth' => $ToMonth->sum('visit_caretaker'),
            'VisitCaretakerToPeriod' => $ToPeriod->sum('visit_caretaker'),

            'TELCaretakerToday' => $Today->sum('TEL_caretaker'),
            'TELCaretakerToMonth' => $ToMonth->sum('TEL_caretaker'),
            'TELCaretakerToPeriod' => $ToPeriod->sum('TEL_caretaker'),

            'OnSiteCheckToday' => $Today->sum('on-site_check'),
            'OnSiteCheckToMonth' => $ToMonth->sum('on-site_check'),
            'OnSiteCheckToPeriod' => $ToPeriod->sum('on-site_check'),

            'ResearchOtherToday' => $Today->sum('research_other'),
            'ResearchOtherToMonth' => $ToMonth->sum('research_other'),
            'ResearchOtherToPeriod' => $ToPeriod->sum('research_other'),

            'ReTELToday' => $Today->sum('re_TEL'),
            'ReTELToMonth' => $ToMonth->sum('re_TEL'),
            'ReTELToPeriod' => $ToPeriod->sum('re_TEL'),

            'ReEmailToday' => $Today->sum('re_email'),
            'ReEmailToMonth' => $ToMonth->sum('re_email'),
            'ReEmailToPeriod' => $ToPeriod->sum('re_email'),

            'ReLetterToday' => $Today->sum('re_letter'),
            'ReLetterToMonth' => $ToMonth->sum('re_letter'),
            'ReLetterToPeriod' => $ToPeriod->sum('re_letter'),

            'ReHpToday' => $Today->sum('re_hp'),
            'ReHpToMonth' => $ToMonth->sum('re_hp'),
            'ReHpToPeriod' => $ToPeriod->sum('re_hp'),

            'ReSiteToday' => $Today->sum('re_site'),
            'ReSiteToMonth' => $ToMonth->sum('re_site'),
            'ReSiteToPeriod' => $ToPeriod->sum('re_site'),

            'ReOtherToday' => $Today->sum('re_other'),
            'ReOtherToMonth' => $ToMonth->sum('re_other'),
            'ReOtherToPeriod' => $ToPeriod->sum('re_other'),
        ];
    }
}