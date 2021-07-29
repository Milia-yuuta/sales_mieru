<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultDailyReportActionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('result_daily_report_action_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('daily_report_id')->index()->comment('予定キー');
            $table->unsignedBigInteger('action_master_id')->index()->comment('アクションマスタキー');
            $table->time('start_time')->index()->comment('開始時間');
            $table->time('end_time')->index()->comment('終了時間');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('result_daily_report_action_logs');
    }
}
