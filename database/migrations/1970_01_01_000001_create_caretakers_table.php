<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaretakersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caretakers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('property_id')->index()->nullable()->comment('顧客キー');
            $table->string('caretaker_name', 30)->index()->comment('管理人名');
            $table->boolean('caretaler_method')->index()->comment('NULL:常駐,1:日勤');
            $table->boolean('sunday_flg')->index()->comment('日曜フラグ');
            $table->boolean('monday_flg')->index()->comment('月曜フラグ');
            $table->boolean('tuesday_flg')->index()->comment('火曜フラグ');
            $table->boolean('wednesday_flg')->index()->comment('水曜フラグ');
            $table->boolean('thursday_flg')->index()->comment('木曜フラグ');
            $table->boolean('friday_flg')->index()->comment('金曜フラグ');
            $table->boolean('satursay_flg')->index()->comment('土曜フラグ');
            $table->time('work_ start_time')->nullable()->comment('勤務開始時間');
            $table->time('Work_end_time')->nullable()->comment('勤務終了時間');
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
        Schema::dropIfExists('caretakers');
    }
}
