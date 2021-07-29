<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_masters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('property_master_id')->index()->nullable()->comment('顧客マスターキー');
            $table->unsignedTinyInteger('group_num')->index()->nullable()->comment('グループナンバー');
            $table->string('name', 30)->index()->comment('アクション名');
            $table->unsignedTinyInteger('val')->index()->nullable()->comment('val_number');
            $table->unsignedTinyInteger('seq')->index()->nullable()->comment('並び順');
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
        Schema::dropIfExists('property_masters');
    }
}
