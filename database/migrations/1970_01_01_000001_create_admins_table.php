<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sei', 30)->nullable()->index()->comment('姓');
            $table->string('mei', 30)->nullable()->index()->comment('名');
            $table->string('sei_kana', 30)->nullable()->index()->comment('姓(カナ)');
            $table->string('mei_kana', 30)->nullable()->index()->comment('名(カナ)');
            $table->date('birthday')->nullable()->index()->comment('生年月日');
            $table->string('email')->unique()->index()->comment('email');
            $table->string('password')->comment('パスワード');
            $table->rememberToken();
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
        Schema::dropIfExists('admins');
    }
}
