<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index()->comment('ユーザーキー');
            $table->unsignedBigInteger('office_master_id')->index()->nullable()->comment('事業所キー');
            $table->unsignedBigInteger('area_master_id')->index()->nullable()->comment('エリアキー');
            $table->unsignedBigInteger('client_id')->index()->nullable()->comment('顧客キー');
            $table->unsignedBigInteger('management_company_master_id')->index()->nullable()->comment('施主キー');
            $table->unsignedBigInteger('construction_company_master_id')->index()->nullable()->comment('施工キー');
            $table->unsignedBigInteger('client_company_master_id')->index()->nullable()->comment('管理会社キー');
            $table->unsignedBigInteger('structure_property_master_id')->index()->nullable()->comment('建物構造キー');
            $table->unsignedBigInteger('right_property_master_id')->index()->nullable()->comment('土地権利マスターキー');
            $table->unsignedBigInteger('earthquake_property_master_id')->index()->nullable()->comment('耐震マスターキー');
            $table->unsignedBigInteger('pet_property_master_id')->index()->nullable()->comment('ペットマスタキー');
            $table->string('code')->index()->nullable()->comment('顧客コード');
            $table->string('property_name', 30)->nullable()->comment('顧客名');
            $table->unsignedBigInteger('prefecture_master_id')->index()->nullable()->comment('都道府県id');
            $table->string('address1')->index()->nullable()->comment('市区町村');
            $table->string('address2')->index()->nullable()->comment('番地');
            $table->string('parcel_number')->index()->nullable()->comment('地番');
            $table->string('nearest_station')->index()->nullable()->comment('最寄駅');
            $table->unsignedTinyInteger('nearest_station_walk_time')->index()->nullable()->comment('最寄駅徒歩(分)');
            $table->string('bus_stop')->index()->nullable()->comment('バス停留所');
            $table->unsignedTinyInteger('bus_stop_walk_time')->index()->nullable()->comment('バス停留所徒歩(分)');
            $table->unsignedBigInteger('number_building')->index()->nullable()->comment('棟数');
            $table->unsignedBigInteger('number_unit')->index()->nullable()->comment('戸数(棟戸数)');
            $table->unsignedBigInteger('total_unit')->index()->nullable()->comment('総戸数');
            $table->unsignedTinyInteger('number_floor')->index()->nullable()->comment('地上階数');
            $table->date('date_completion')->index()->nullable()->comment('竣工年月日');
            $table->string('date_completion_japan')->index()->nullable()->comment('竣工年月日(和暦)');
            $table->boolean('customer_list_flg')->index()->nullable()->comment('顧客リストフラグ');
            $table->boolean('Pamphlet_flg')->index()->nullable()->comment('パンフレットフラグ');
            $table->string('liquidity_judgment', 1)->nullable()->index()->comment('流通性判定');
            $table->string('property_judgment', 1)->nullable()->index()->comment('物件判定');
            $table->string('approach_judgment', 1)->nullable()->index()->comment('アプローチ判定');
            $table->boolean('posting_flg')->nullable()->index()->comment('投函フラグ');
            $table->boolean('warning_flg')->nullable()->index()->comment('注意フラグ');
            $table->text('remark')->nullable()->comment('備考');
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
        Schema::dropIfExists('properties');
    }
}
