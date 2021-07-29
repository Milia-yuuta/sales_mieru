<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_masters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_masters_id')->index()->nullable()->comment('ユーザーマスターキー');
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
        Schema::dropIfExists('user_masters');
    }
}
