<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_masters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('action_master_id')->nullable()->index()->comment('アクションマスターキー');
            $table->unsignedBigInteger('group_num')->nullable()->index()->comment('グループナンバー');
            $table->string('action_name', 30)->index()->comment('アクション名');
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
        Schema::dropIfExists('action_masters');
    }
}
