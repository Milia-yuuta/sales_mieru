<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sales_id')->nullable()->index()->comment('営業ユーザーキー');
            $table->unsignedBigInteger('hat_id')->nullable()->index()->comment('hatユーザーキー');
            $table->unsignedInteger('office_master_id')->nullable()->index()->comment('オフィスマスターキー');
            $table->unsignedInteger('area_master_id')->nullable()->index()->comment('エリアマスターキー');
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
        Schema::dropIfExists('teams');
    }
}
