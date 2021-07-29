<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExcavationBehaviorLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('excavation_behavior_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index()->default(0)->comment('ユーザーキー');
            $table->unsignedBigInteger('office_master_id')->index()->default(0)->comment('事業所キー');
            $table->unsignedBigInteger('area_master_id')->index()->default(0)->comment('エリアキー');
            $table->unsignedBigInteger('status_id')->index()->default(0)->comment('1:sale,2:hat');
            $table->date('action_date')->index()->comment('行動日');
            $table->unsignedBigInteger('manager_visit_count')->index()->default(0)->comment('管理人訪問');
            $table->unsignedBigInteger('personal_visit_count')->index()->default(0)->comment('個人訪問');
            $table->unsignedBigInteger('check_post_count')->index()->default(0)->comment('ポストチェック');
            $table->unsignedBigInteger('check_building_count')->index()->default(0)->comment('一棟チェック');
            $table->unsignedBigInteger('patrol_local_information')->index()->default(0)->comment('巡回現地情報');
            $table->unsignedBigInteger('DM_distribution_count')->index()->default(0)->comment('DM手まき');
            $table->unsignedBigInteger('flyer_distribution_count')->index()->comment('売却チラシ手まき');
            $table->unsignedBigInteger('letter_distribution_count')->index()->default(0)->comment('手紙・封書手まき');
            $table->unsignedBigInteger('random_visit_implementation_count')->index()->default(0)->comment('ランダム戸別訪問/実施数');
            $table->unsignedBigInteger('random_visit_at_home_count')->index()->default(0)->comment('ランダム戸別訪問/在宅数');
            $table->unsignedBigInteger('manager_TEL_count')->index()->default(0)->comment('管理人TEL');
            $table->unsignedBigInteger('personal_TEL_count')->index()->default(0)->comment('個人TEL');
            $table->unsignedBigInteger('random_TEL_implementation_count')->index()->default(0)->comment('ランダムTEL実施');
            $table->unsignedBigInteger('random_TEL_at_home_count')->index()->default(0)->comment('ランダムTEL在宅');
            $table->unsignedBigInteger('mail_letter_count')->index()->default(0)->comment('手紙・封書郵送');
            $table->unsignedBigInteger('flyer_delivery_count')->index()->default(0)->comment('売却チラシ宅配依頼');
            $table->unsignedBigInteger('DM_mail_count')->index()->default(0)->comment('DM郵送');
            $table->unsignedBigInteger('return_to_mail')->nullable()->index()->default(0)->comment('郵送物戻');
            $table->unsignedBigInteger('rental_information')->nullable()->default(0)->comment('賃貸情報');
            $table->unsignedBigInteger('registration_information')->nullable()->default(0)->comment('登記情報');
            $table->unsignedBigInteger('building_confirmation_information')->nullable()->default(0)->comment('建築確認情報');
            $table->unsignedBigInteger('pre_visit_preliminary_count')->nullable()->default(0)->comment('前取訪問 実施');
            $table->unsignedBigInteger('pre_visit_home_count')->nullable()->default(0)->index()->comment('前取訪問 在宅');
            $table->unsignedBigInteger('pre_TEL_home_count')->nullable()->default(0)->comment('前取TEL 在宅');
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
        Schema::dropIfExists('excavation_behavior_logs');
    }
}
