<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('area_master_id')->nullable()->index()->comment('エリアマスターキー');
            $table->unsignedInteger('office_master_id')->nullable()->index()->comment('オフィスマスターキー');
            $table->unsignedInteger('status_id')->nullable()->index()->comment('ユーザーマスターキー(職位)');
            $table->unsignedInteger('gender_id')->nullable()->index()->comment('ユーザーマスターキー(性別)');
            $table->string('employee_code')->nullable()->comment('社員番号');
            $table->string('sei', 30)->nullable()->index()->comment('姓');
            $table->string('mei', 30)->nullable()->index()->comment('名');
            $table->string('sei_kana', 30)->nullable()->index()->comment('姓(カナ)');
            $table->string('mei_kana', 30)->nullable()->index()->comment('名(カナ)');
            $table->date('birthday')->nullable()->index()->comment('生年月日');
            $table->string('email')->unique()->index()->comment('email');
            $table->string('tel')->index()->nullable()->comment('電話番号');
            $table->string('password');
            $table->rememberToken();
            $table->string('zip_code', 7)->index()->nullable()->comment('郵便番号');
            $table->string('prefecture')->index()->nullable()->comment('都道府県');
            $table->string('address1')->index()->nullable()->comment('市区町村');
            $table->string('address2')->nullable()->index()->comment('番地');
            $table->string('address3')->index()->nullable()->comment('建物名');
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
        Schema::dropIfExists('users');
    }
}
