<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProspectActionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prospect_action_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index()->comment('ユーザーキー');
            $table->bigInteger('prospect_id')->index()->comment('見込みキー');
            $table->bigInteger('stage_action_master_id')->index()->comment('ステージアクションマスターキー');
            $table->bigInteger('status_action_master_id')->nullable()->index()->comment('ステータスアクションマスターキー');
            $table->date('date')->index()->nullable()->comment('アクション日付');
            $table->bigInteger('stage_stay_date')->index()->nullable()->comment('ステージ滞在日数');
            $table->boolean('TEL_home')->nullable()->index()->comment('見込みTEL在宅');
            $table->boolean('send_letter')->nullable()->index()->comment('手紙送付');
            $table->boolean('local_letter')->nullable()->index()->comment('現地手紙');
            $table->boolean('email')->nullable()->index()->comment('メール送信');
            $table->boolean('visit')->nullable()->index()->comment('戸別訪問');
            $table->boolean('pursuit_other')->nullable()->index()->comment('追客その他');
            $table->boolean('assessment_report_email')->nullable()->index()->comment('査定書メール');
            $table->boolean('send_assessment_report')->nullable()->index()->comment('査定書送付');
            $table->boolean('web_negotiation')->nullable()->index()->comment('web商談');
            $table->boolean('assessment_negotiation')->nullable()->index()->comment('査定・商談');
            $table->boolean('re-negotiation')->nullable()->index()->comment('再商談');
            $table->boolean('visit_caretaker')->nullable()->index()->comment('管理人訪問');
            $table->boolean('TEL_caretaker')->nullable()->index()->comment('管理人TEL');
            $table->boolean('on-site_check')->nullable()->index()->comment('現地チェック');
            $table->boolean('research_other')->nullable()->index()->comment('調査その他');
            $table->boolean('re_TEL')->nullable()->index()->comment('TEL');
            $table->boolean('re_email')->nullable()->index()->comment('メール');
            $table->boolean('re_letter')->nullable()->index()->comment('手紙・FAX');
            $table->boolean('re_hp')->nullable()->index()->comment('当社HP反響');
            $table->boolean('re_site')->nullable()->index()->comment('一括査定サイト反響');
            $table->boolean('re_other')->nullable()->index()->comment('お客様反応その他');
            $table->text('result')->nullable()->comment('追客結果');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prospect_action_logs');
    }
}
