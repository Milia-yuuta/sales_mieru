<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index()->comment('ユーザーキー');
            $table->timestamp('date')->index()->comment('日報日付');
            $table->boolean('plan_check')->nullable()->index()->comment('0:予定未提出,1:予定提出済');
            $table->boolean('result_check')->nullable()->index()->comment('0:結果未提出,1:結果提出済');
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
        Schema::dropIfExists('daily_reports');
    }
}
