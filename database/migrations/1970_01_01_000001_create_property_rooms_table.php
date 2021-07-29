<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_rooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('property_id')->index()->nullable()->comment('顧客キー');
            $table->unsignedBigInteger('prospect_id')->index()->nullable()->comment('見込みリストキー');
            $table->unsignedBigInteger('client_id')->index()->nullable()->comment('見込顧客キー');
            $table->unsignedBigInteger('occupied_area')->nullable()->comment('専有面積');
            $table->string('room_name', 30)->comment('担当者');
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
        Schema::dropIfExists('property_rooms');
    }
}
