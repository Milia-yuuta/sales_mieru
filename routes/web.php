<?php

use App\Http\Controllers\ActionMasterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DailyReportActionLogController;
use App\Http\Controllers\DailyReportController;
use App\Http\Controllers\ExactionReportController;
use App\Http\Controllers\ExcavationBehaviorLogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MonthlyResultController;
use App\Http\Controllers\NextProspectActionLogController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertyExcavationBehaviorLogController;
use App\Http\Controllers\ProspectActionLogController;
use App\Http\Controllers\ProspectController;
use App\Http\Controllers\PursuitReportController;
use App\Http\Controllers\ResultDailyReportActionLogController;
use App\Http\Controllers\ShippingInformationController;
use App\Http\Controllers\StageTrendController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TodayStockController;
use App\Http\Controllers\WebResponseController;
use App\Http\Controllers\YieldController;
use Illuminate\Support\Facades\Route;

//ログイン処理
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Auth::routes();

Route::group(['middleware' => ['auth']], function (){
//Home
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/home/damy', [HomeController::class, 'damy'])->name('damy');

//見込みリスト
    Route::get('/prospect', [ProspectController::class, 'index'])->name('prospect');

    Route::post('/prospect/stage/{id}', [ProspectController::class, 'stage'])->name('prospect.stage');
    Route::get('/prospect/{id}', [ProspectController::class, 'show'])->name('prospect.show');
    Route::get('/prospect/label/clients', [ShippingInformationController::class, 'index'])->name('prospect.label');
    Route::get('/prospect/label/export/csv', [ShippingInformationController::class, 'csv'])->name('prospect.label.export.csv');
    Route::get('/prospect/label/export/pdf', [ShippingInformationController::class, 'pdf'])->name('prospect.label.export.pdf');
    Route::group(['middleware' => ['areaCheck']], function (){
        Route::post('/prospect', [ProspectController::class, 'store'])->name('prospect.store');
        Route::post('/prospect/update', [ProspectController::class, 'update'])->name('prospect.update');
        Route::post('client/store', [ClientController::class, 'store'])->name('client.store');
        Route::delete('prospect/delete/{id}', [ProspectController::class, 'delete'])->name('prospect.delete');
    });

//ラベル・CSV発行
    Route::get('/shippingInformation', [ShippingInformationController::class, 'index'])->name('shippingInformation');

//次回追客行動
    Route::group(['middleware' => ['areaCheck']], function () {
        Route::post('/nextProspectActionLog/result/Update', [NextProspectActionLogController::class, 'resultUpdate'])->name('nextProspectActionLog.resultUpdate');

//発掘
        Route::post('/excavationBehaviorLog/store', [ExcavationBehaviorLogController::class, 'store'])->name('excavationBehaviorLog.store');

//追客
        Route::post('/prospectActionLog/store', [ProspectActionLogController::class, 'store'])->name('prospectActionLog.store');
        Route::post('/prospectActionLog/update', [ProspectActionLogController::class, 'update'])->name('prospectActionLog.update');
        Route::delete('/prospectActionLog/delete', [ProspectActionLogController::class, 'delete'])->name('prospectActionLog.delete');
    });

//顧客
    Route::get('/property', [PropertyController::class, 'index'])->name('property');
    Route::group(['middleware' => ['areaCheck']], function () {
        Route::post('/property', [PropertyController::class, 'store'])->name('property.store');
        Route::get('/property/nameList', [PropertyController::class, 'nameList']);
        Route::get('/property/codeList', [PropertyController::class, 'codeList']);
        Route::get('/property/codeList/search/{property_id}',  [PropertyController::class, 'SearchByCode']);
    });

//日報
    Route::get('/dailyReport', [DailyReportController::class, 'index'])->name('dailyReport');
    Route::get('dailyReport/create', [DailyReportController::class, 'create'])->name('dailyReport.create');
    Route::group(['middleware' => ['areaCheck']], function () {
        Route::post('dailyReport/store', [DailyReportController::class, 'store'])->name('dailyReport.store');
        Route::post('dailyReport/edit', [DailyReportController::class, 'edit'])->name('dailyReport.edit');
        Route::post('dailyReport/update', [DailyReportController::class, 'update'])->name('dailyReport.update');
    });
    Route::get('dailyReport/{id}', [DailyReportController::class, 'show'])->name('dailyReport.show');

//日報予定作成
    Route::group(['middleware' => ['areaCheck']], function () {
        Route::post('dailyReport/PlanStore', [DailyReportController::class, 'PlanStore'])->name('dailyReport.PlanStore');
        Route::post('dailyReport/PlanUpdate', [DailyReportController::class, 'PlanUpdate'])->name('dailyReport.PlanUpdate');
        Route::post('dailyReport/PlanDelete', [DailyReportController::class, 'PlanDelete'])->name('dailyReport.PlanDelete');
        Route::post('dailyReport/ResultStore', [DailyReportController::class, 'ResultStore'])->name('dailyReport.ResultStore');
        Route::post('dailyReport/ResultUpdate', [DailyReportController::class, 'ResultUpdate'])->name('dailyReport.ResultUpdate');
        Route::post('dailyReport/ResultDelete', [DailyReportController::class, 'ResultDelete'])->name('dailyReport.ResultDelete');
    });
    Route::get('/dailyReport/user/{office_id}', [DailyReportController::class, 'userSearch'])->name('dailyReport.userSearch');
    Route::get('/dailyReport/plan/{id}', [DailyReportActionLogController::class, 'index'])->name('dailyReportActionLog.index');
    Route::get('/dailyReport/result/{id}', [ResultDailyReportActionLogController::class, 'index'])->name('resultDailyReportActionLog.index');


    // 分析
    // ストック
    Route::get('/analysis/todayStock/index', [TodayStockController::class, 'index'])->name('todayStock');
    Route::get('/analysis/todayStock/getRooms/{office_id}', [TodayStockController::class, 'getRooms'])->name('todayStock.search');
    Route::get('/analysis/todayStock/home/getRooms/{office_id}', [TodayStockController::class, 'homeGetRooms'])->name('todayStock.view');
    Route::get('/analysis/todayStock/getRooms/view/{office_id}', [TodayStockController::class, 'view'])->name('todayStock.view');
    Route::get('/analysis/todayStock/getRooms/show/{prospect_id}', [TodayStockController::class, 'show'])->name('todayStock.show');

    // ステージ
    Route::get('/analysis/stageTrend', [StageTrendController::class, 'index'])->name('stageTrend');
    Route::post('/analysis/stageTrend/roomList', [StageTrendController::class, 'roomList'])->name('stageTrend.roomList');
    Route::get('/analysis/stageTrend/roomList/show/{prospect_id}', [StageTrendController::class, 'show']);

    // 発掘レポート
    Route::get('/analysis/exactionReport', [ExactionReportController::class, 'index'])->name('exactionReport');
    // 追客レポート
    Route::get('/analysis/pursuitReport', [PursuitReportController::class, 'index'])->name('pursuitReport');
    Route::post('/analysis/pursuitReport/roomList', [PursuitReportController::class, 'roomList'])->name('pursuitReport.roomList');
    // 歩留まり集計
    Route::get('analysis/yield', [YieldController::class, 'index'])->name('yield');
    // 月次結果一覧
    Route::get('analysis/monthlyResult', [MonthlyResultController::class, 'index'])->name('monthlyResult');
    // ネット反響各指標
    Route::get('analysis/webResponse', [WebResponseController::class, 'index'])->name('webResponse');
    Route::get('stats')->name('stats');

//非同期イベント
    Route::group(['middleware' => ['areaCheck']], function () {
        Route::post('/propertyExcavationBehaviorLog/store', [PropertyExcavationBehaviorLogController::class, 'store'])->name('propertyExcavationBehaviorLog.store');
        Route::post('/propertyExcavationBehaviorLog/CountDown', [PropertyExcavationBehaviorLogController::class, 'CountDown'])->name('propertyExcavationBehaviorLog.CountDown');
        Route::post('/dailyReport/ajax/PlanUpdate', [DailyReportController::class, 'ajaxPlanUpdate'])->name('dailyReport.ajaxPlanUpdate');
        Route::post('/dailyReport/ajax/resultUpdate', [DailyReportController::class, 'ajaxResultUpdate'])->name('dailyReport.ajaxResultUpdate');
    });
    Route::post('/property/pin', [PropertyController::class, 'pin'])->name('property.pin');
    Route::post('/property/pin/delete', [PropertyController::class, 'pinDelete'])->name('property.pin.delete');
    Route::post('/prospect/pin', [ProspectController::class, 'pin'])->name('prospect.pin');
    Route::post('/prospect/pin/delete', [ProspectController::class, 'pinDelete'])->name('prospect.pin.delete');
    Route::post('/property/stage/search', [PropertyController::class, 'StageSearch'])->name('property.stage.search');
    Route::post('/excavationBehaviorLog/search', [ExcavationBehaviorLogController::class, 'search'])->name('ExcavationBehaviorLogController.search');
    Route::get('/propertyExcavationBehaviorLog/search', [PropertyExcavationBehaviorLogController::class, 'search'])->name('propertyExcavationBehaviorLog.search');
    Route::get('/ActionMaster/GenerateMedium/{medium}', [ActionMasterController::class, 'GeneratingMedium'])->name('GeneratingMedium');
    Route::get('/ActionMaster/prospect/{stage}', [ActionMasterController::class, 'StatusChange'])->name('StatusChange');
    Route::get('/ActionMaster/dailyReportAction', [ActionMasterController::class, 'dailyReportAction'])->name('ActionMaster.dailyReportAction');
//user検索
    Route::get('/team/search/office/{office_master_id}', [TeamController::class, 'teamSearchForOffice'])->name('team.search.office');
});
