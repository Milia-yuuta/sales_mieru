<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\ActionMaster
 *
 * @property int $id
 * @property int|null $action_master_id アクションマスターキー
 * @property int|null $group_num グループナンバー
 * @property string $name アクション名
 * @property int|null $val val_number
 * @property int|null $seq 並び順
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|ActionMaster[] $actionMaster
 * @property-read int|null $action_master_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DailyReportActionLog[] $dailyReportActionLogs
 * @property-read int|null $daily_report_action_logs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ExcavationBehaviorLog[] $excavationBehaviorLogs
 * @property-read int|null $excavation_behavior_logs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProspectActionLog[] $prospectActionLogs
 * @property-read int|null $prospect_action_logs_count
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMaster newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMaster newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMaster query()
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMaster whereActionMasterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMaster whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMaster whereGroupNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMaster whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMaster whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMaster whereSeq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMaster whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMaster whereVal($value)
 */
	class ActionMaster extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Admin
 *
 * @property int $id
 * @property string|null $sei 姓
 * @property string|null $mei 名
 * @property string|null $sei_kana 姓(カナ)
 * @property string|null $mei_kana 名(カナ)
 * @property string|null $birthday 生年月日
 * @property string $email email
 * @property string $password パスワード
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereMei($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereMeiKana($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereSei($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereSeiKana($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUpdatedAt($value)
 */
	class Admin extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Caretaker
 *
 * @property int $id
 * @property int|null $property_id 顧客キー
 * @property string $caretaker_name 管理人名
 * @property int $caretaler_method NULL:常駐,1:日勤
 * @property int $sunday_flg 日曜フラグ
 * @property int $monday_flg 月曜フラグ
 * @property int $tuesday_flg 火曜フラグ
 * @property int $wednesday_flg 水曜フラグ
 * @property int $thursday_flg 木曜フラグ
 * @property int $friday_flg 金曜フラグ
 * @property int $satursay_flg 土曜フラグ
 * @property string|null $work_ start_time 勤務開始時間
 * @property string|null $Work_end_time 勤務終了時間
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Caretaker newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Caretaker newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Caretaker query()
 * @method static \Illuminate\Database\Eloquent\Builder|Caretaker whereCaretakerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Caretaker whereCaretalerMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Caretaker whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Caretaker whereFridayFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Caretaker whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Caretaker whereMondayFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Caretaker wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Caretaker whereSatursayFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Caretaker whereSundayFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Caretaker whereThursdayFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Caretaker whereTuesdayFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Caretaker whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Caretaker whereWednesdayFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Caretaker whereWorkEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Caretaker whereWorkStartTime($value)
 */
	class Caretaker extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CompanyMaster
 *
 * @property int $id
 * @property string $name 企業名
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyMaster newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyMaster newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyMaster query()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyMaster whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyMaster whereName($value)
 */
	class CompanyMaster extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DailyReport
 *
 * @property int $id
 * @property int $user_id ユーザーキー
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DailyReportActionLog[] $dailyReportActionLogs
 * @property-read int|null $daily_report_action_logs_count
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReport query()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReport whereUserId($value)
 */
	class DailyReport extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DailyReportActionLog
 *
 * @property int $id
 * @property int $daily_report_id 日報キー
 * @property int $action_master_id アクションマスタキー
 * @property string $start_time 開始時間
 * @property string $end_time 終了時間
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ActionMaster $actionMaster
 * @property-read \App\Models\DailyReport $dailyReport
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReportActionLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReportActionLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReportActionLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReportActionLog whereActionMasterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReportActionLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReportActionLog whereDailyReportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReportActionLog whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReportActionLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReportActionLog whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailyReportActionLog whereUpdatedAt($value)
 */
	class DailyReportActionLog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ExcavationBehaviorLog
 *
 * @property int $id
 * @property int $user_id ユーザーキー
 * @property int $manager_visit_count 管理人訪問
 * @property int $personal_visit_count 個人訪問
 * @property int $DM_distribution_count DM手まき
 * @property int $flyer_distribution_count 売却チラシ手まき
 * @property int $letter_distribution_count 手紙・封書手まき
 * @property int $random_visit_implementation_count ランダム戸別訪問/実施数
 * @property int $random_visit_at_home_count ランダム戸別訪問/在宅数
 * @property int $manager_TEL_count 管理人TEL
 * @property int $personal_TEL_count 個人TEL
 * @property int $random_TEL_implementation_count ランダムTEL実施
 * @property int $random_TEL_at_home_count ランダムTEL在宅
 * @property int $flyer_delivery_count 売却チラシ宅配依頼
 * @property int $DM_mail_count DM郵送
 * @property int $pre_visit_preliminary_count 前取訪問 実施
 * @property int $pre_visit_home_count 前取訪問 在宅
 * @property int $pre_TEL_home_count 前取TEL 在宅
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ActionMaster $actionMaster
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|ExcavationBehaviorLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExcavationBehaviorLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExcavationBehaviorLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExcavationBehaviorLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExcavationBehaviorLog whereDMDistributionCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExcavationBehaviorLog whereDMMailCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExcavationBehaviorLog whereFlyerDeliveryCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExcavationBehaviorLog whereFlyerDistributionCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExcavationBehaviorLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExcavationBehaviorLog whereLetterDistributionCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExcavationBehaviorLog whereManagerTELCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExcavationBehaviorLog whereManagerVisitCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExcavationBehaviorLog wherePersonalTELCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExcavationBehaviorLog wherePersonalVisitCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExcavationBehaviorLog wherePreTELHomeCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExcavationBehaviorLog wherePreVisitHomeCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExcavationBehaviorLog wherePreVisitPreliminaryCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExcavationBehaviorLog whereRandomTELAtHomeCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExcavationBehaviorLog whereRandomTELImplementationCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExcavationBehaviorLog whereRandomVisitAtHomeCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExcavationBehaviorLog whereRandomVisitImplementationCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExcavationBehaviorLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExcavationBehaviorLog whereUserId($value)
 */
	class ExcavationBehaviorLog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Favorite
 *
 * @property int $id
 * @property int $user_id ユーザーキー
 * @property int $prospect_id 見込みリストキー
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectFavorite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectFavorite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectFavorite query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectFavorite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectFavorite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectFavorite whereProspectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectFavorite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectFavorite whereUserId($value)
 */
	class Favorite extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Property
 *
 * @property int $id
 * @property int|null $management_company_master_id 施主キー
 * @property int|null $construction_company_master_id 施工キー
 * @property int|null $client_company_master_id 管理会社キー
 * @property int $structure_property_master_id 建物構造キー
 * @property int $right_property_master_id 土地権利マスターキー
 * @property int $classification_property_master_id 耐震マスターキー
 * @property int $pet_property_master_id 耐震マスターキー
 * @property string $code 顧客コード
 * @property string $name 顧客名
 * @property string $prefecture 都道府県
 * @property string $address1 市区町村
 * @property string $address2 番地
 * @property string $parcel_number 地番
 * @property string|null $nearest_station 最寄駅
 * @property int|null $Nearest_station_walk_time 最寄駅徒歩(分)
 * @property string|null $bus_stop バス停留所
 * @property int|null $bus_stop_walk_time バス停留所徒歩(分)
 * @property int $number_building 棟数
 * @property int|null $number_unit 戸数(棟戸数)
 * @property int|null $total_unit 総戸数
 * @property int|null $number_floor 地上階数
 * @property string|null $date_completion 竣工年月日
 * @property string $date_completion_japan 竣工年月日(和暦)
 * @property int|null $customer_list_flg 顧客リストフラグ
 * @property int|null $Pamphlet_flg パンフレットフラグ
 * @property string|null $liquidity_judgment 流通性判定
 * @property string|null $property_judgment 物件判定
 * @property string|null $approach_judgment アプローチ判定
 * @property int|null $posting_flg 投函フラグ
 * @property int|null $warning_flg 注意フラグ
 * @property string|null $remark 備考
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Caretaker[] $caretakers
 * @property-read int|null $caretakers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CompanyMaster[] $companyMasters
 * @property-read int|null $company_masters_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PropertyMaster[] $propertyMasters
 * @property-read int|null $property_masters_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PropertyRoom[] $propertyRooms
 * @property-read int|null $property_rooms_count
 * @method static \Illuminate\Database\Eloquent\Builder|Property newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Property newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Property query()
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereApproachJudgment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereBusStop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereBusStopWalkTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereClassificationPropertyMasterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereClientCompanyMasterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereConstructionCompanyMasterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereCustomerListFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereDateCompletion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereDateCompletionJapan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereLiquidityJudgment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereManagementCompanyMasterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereNearestStation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereNearestStationWalkTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereNumberBuilding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereNumberFloor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereNumberUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property wherePamphletFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereParcelNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property wherePetPropertyMasterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property wherePostingFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property wherePrefecture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property wherePropertyJudgment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereRightPropertyMasterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereStructurePropertyMasterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereTotalUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereWarningFlg($value)
 */
	class Property extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PropertyMaster
 *
 * @property int $id
 * @property int|null $property_master_id 顧客マスターキー
 * @property int|null $group_num グループナンバー
 * @property string $name アクション名
 * @property int|null $val val_number
 * @property int|null $seq 並び順
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyMaster newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyMaster newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyMaster query()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyMaster whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyMaster whereGroupNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyMaster whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyMaster whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyMaster wherePropertyMasterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyMaster whereSeq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyMaster whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyMaster whereVal($value)
 */
	class PropertyMaster extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PropertyRoom
 *
 * @property int $id
 * @property int|null $property_id 顧客キー
 * @property int $name 担当者
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Property|null $property
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyRoom newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyRoom newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyRoom query()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyRoom whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyRoom whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyRoom whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyRoom wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyRoom whereUpdatedAt($value)
 */
	class PropertyRoom extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Prospect
 *
 * @property int $id
 * @property int $user_id ユーザーキー
 * @property int $property_id 顧客キー
 * @property int $usage_action_master_id 利用形態マスターキー
 * @property int $stage_action_master_id ステージアクションマスターキー
 * @property string|null $remark 備考
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProspectFavorite[] $favorites
 * @property-read int|null $favorites_count
 * @property-read \App\Models\Property $property
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProspectActionLog[] $prospectActionLogs
 * @property-read int|null $prospect_action_logs_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Prospect newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Prospect newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Prospect query()
 * @method static \Illuminate\Database\Eloquent\Builder|Prospect whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prospect whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prospect wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prospect whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prospect whereStageActionMasterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prospect whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prospect whereUsageActionMasterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prospect whereUserId($value)
 */
	class Prospect extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProspectActionLog
 *
 * @property int $id
 * @property int $prospect_id ユーザーキー
 * @property int $property_id 顧客キー
 * @property int $status_action_master_id ステータスアクションマスターキー
 * @property int $TEL_home 見込みTEL在宅
 * @property int $send_letter 手紙送付
 * @property int $local_letter 現地手紙
 * @property int $email メール送信
 * @property int $visit 戸別訪問
 * @property int $pursuit_other 追客その他
 * @property int $assessment_report_email 査定書メール
 * @property int $send_assessment_report 査定書送付
 * @property int $web_negotiation web商談
 * @property int $assessment_negotiation 査定・商談
 * @property int $re-negotiation 再商談
 * @property int $visit_caretaker 管理人訪問
 * @property int $TEL_caretaker 管理人TEL
 * @property int $on-site_check 現地チェック
 * @property int $research_other 調査その他
 * @property int $re_TEL TEL
 * @property int $re_email メール
 * @property int $re_letter 手紙・FAX
 * @property int $re_hp 当社HP反響
 * @property int $re_site 一括査定サイト反響
 * @property int $re_other お客様反応その他
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Prospect $prospect
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectActionLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectActionLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectActionLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectActionLog whereAssessmentNegotiation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectActionLog whereAssessmentReportEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectActionLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectActionLog whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectActionLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectActionLog whereLocalLetter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectActionLog whereOnSiteCheck($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectActionLog wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectActionLog whereProspectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectActionLog wherePursuitOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectActionLog whereReEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectActionLog whereReHp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectActionLog whereReLetter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectActionLog whereReNegotiation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectActionLog whereReOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectActionLog whereReSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectActionLog whereReTEL($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectActionLog whereResearchOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectActionLog whereSendAssessmentReport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectActionLog whereSendLetter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectActionLog whereStatusActionMasterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectActionLog whereTELCaretaker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectActionLog whereTELHome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectActionLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectActionLog whereVisit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectActionLog whereVisitCaretaker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProspectActionLog whereWebNegotiation($value)
 */
	class ProspectActionLog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Team
 *
 * @property int $id
 * @property int $user_id ユーザーキー
 * @property int $user_id2 ユーザーキー
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Team newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team query()
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereUserId2($value)
 */
	class Team extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property int|null $area_master_id エリアマスターキー
 * @property int|null $office_master_id オフィスマスターキー
 * @property int|null $status_id ユーザーマスターキー(職位)
 * @property int|null $gender_id ユーザーマスターキー(性別)
 * @property string|null $sei 姓
 * @property string|null $mei 名
 * @property string|null $sei_kana 姓(カナ)
 * @property string|null $mei_kana 名(カナ)
 * @property string|null $birthday 生年月日
 * @property string $email email
 * @property string|null $tel 電話番号
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $zip_code 郵便番号
 * @property string|null $prefecture 都道府県
 * @property string|null $address1 市区町村
 * @property string|null $address2 番地
 * @property string|null $address3 建物名
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DailyReport[] $dailyReports
 * @property-read int|null $daily_reports_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ExcavationBehaviorLog[] $excavationBehaviorLogs
 * @property-read int|null $excavation_behavior_logs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProspectFavorite[] $favorites
 * @property-read int|null $favorites_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Prospect[] $prospects
 * @property-read int|null $prospects_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Team[] $teams
 * @property-read int|null $teams_count
 * @property-read \App\Models\UserMaster $userMaster
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAddress3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAreaMasterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMei($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMeiKana($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereOfficeMasterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePrefecture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSei($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSeiKana($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereZipCode($value)
 */
	abstract class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

namespace App\Models{
/**
 * App\Models\UserMaster
 *
 * @property int $id
 * @property int|null $user_masters_id ユーザーマスターキー
 * @property int|null $group_num グループナンバー
 * @property string $name アクション名
 * @property int|null $val val_number
 * @property int|null $seq 並び順
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|UserMaster[] $userMaster
 * @property-read int|null $user_master_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|UserMaster newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserMaster newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserMaster query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserMaster whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMaster whereGroupNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMaster whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMaster whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMaster whereSeq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMaster whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMaster whereUserMastersId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMaster whereVal($value)
 */
	class UserMaster extends \Eloquent {}
}

