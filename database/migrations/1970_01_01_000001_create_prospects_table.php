<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProspectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prospects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index()->comment('ユーザーキー');
            $table->unsignedBigInteger('office_master_id')->index()->comment('hat所キー');
            $table->unsignedBigInteger('area_master_id')->index()->comment('エリアキー');
            $table->unsignedBigInteger('input_person')->index()->comment('1:営業,2:hat');
            $table->timestamp('date')->index()->comment('発生日');
            $table->timestamp('latest_date')->index()->nullable()->comment('リレーション先の更新日');
            $table->unsignedBigInteger('usage_action_master_id')->index()->nullable()->comment('利用形態マスターキー');
            $table->unsignedBigInteger('generating_medium_master_id')->index()->comment('発生媒体キー');
            $table->unsignedBigInteger('source_media_site_master_id')->index()->nullable()->comment('発生媒体サイトキー');
            $table->text('remark')->nullable()->comment('備考');
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
        Schema::dropIfExists('prospects');
    }
}
