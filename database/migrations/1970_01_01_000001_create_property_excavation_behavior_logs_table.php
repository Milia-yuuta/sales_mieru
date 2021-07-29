<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyExcavationBehaviorLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_excavation_behavior_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index()->comment('ユーザーキー');
            $table->unsignedBigInteger('property_id')->index()->nullable()->comment('顧客キー');
            $table->date('action_date')->index()->comment('行動日');
            $table->unsignedBigInteger('manager_visit_count')->index()->default(0)->comment('管理人訪問');
            $table->unsignedBigInteger('check_building_count')->index()->default(0)->comment('一棟チェック');
            $table->unsignedBigInteger('manager_TEL_count')->index()->default(0)->comment('管理人TEL');
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
        Schema::dropIfExists('property_excavation_behavior_logs');
    }
}
