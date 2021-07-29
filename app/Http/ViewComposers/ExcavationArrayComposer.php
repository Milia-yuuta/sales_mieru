<?php

namespace App\Http\ViewComposers;

use Auth;
use App\Models\ExcavationBehaviorLog;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\PrefectureMaster;

/**
 * Class LayoutComposer
 * @package App\Http\ViewComposers\User\Worker
 */
class ExcavationArrayComposer
{
    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with([
            'AreaTypeList' => [
                '管理人訪問' => 'manager_visit_count',
                '個人訪問' => 'personal_visit_count',
                '一棟チェック' => 'check_building_count',
                'DM手まき' => 'DM_distribution_count',
                '売却チラシ手まき' => 'flyer_distribution_count',
                '手紙・封書手まき' => 'letter_distribution_count',
                'ランダム戸別訪問実施数' => 'random_visit_implementation_count',
                'ランダム戸別訪問在宅数' => 'random_visit_at_home_count',
            ],
            'CompanyTypeList' => [
                '管理人TEL' => 'manager_TEL_count',
                '個人TEL' => 'personal_TEL_count',
                'ランダムTEL 実施' => 'random_TEL_implementation_count',
                'ランダムTEL 在宅' => 'random_TEL_at_home_count',
                '手紙・封書郵送' => 'mail_letter_count',
                '売却チラシ宅配依頼' => 'flyer_delivery_count',
                'DM郵送' => 'DM_mail_count',
            ],
            'PreTypeList' => [
                '前取訪問 実施' => 'pre_visit_preliminary_count',
                '前取訪問 在宅' => 'pre_visit_home_count',
                '前取TEL 在宅' => 'pre_TEL_home_count',
            ],
        ]);
    }

}