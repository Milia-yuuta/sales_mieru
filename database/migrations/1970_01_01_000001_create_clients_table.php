<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type', 1)->nullable()->index()->comment('顧客区分(1：個人、2：法人)');
            $table->string('name', 30)->nullable()->index()->comment('顧客名');
            $table->string('zip_code', 8)->index()->nullable()->comment('郵便番号');
            $table->string('address1')->index()->nullable()->comment('住所');
            $table->string('address2')->index()->nullable()->comment('番地');
            $table->string('address3', 80)->index()->nullable()->comment('建物名');
            $table->string('address4', 10)->index()->nullable()->comment('担当者');
            $table->string('email')->index()->nullable()->comment('email(PC)');
            $table->string('s_mobile_email')->index()->nullable()->comment('email(スマホ)');
            $table->string('mobile_email')->index()->nullable()->comment('email(携帯)');
            $table->string('tel')->index()->nullable()->comment('電話番号');
            $table->string('mobile')->index()->nullable()->comment('携帯番号');
            $table->string('fax')->index()->nullable()->comment('fax');
            $table->string('address_check', 1)->index()->nullable()->comment('住所連絡可否');
            $table->string('tel_check', 1)->index()->nullable()->comment('電話連絡可否');
            $table->string('mobile_check', 1)->index()->nullable()->comment('携帯番号連絡可否');
            $table->string('email_check', 1)->index()->nullable()->comment('メール連絡可否');
            $table->string('s_mobile_email_check', 1)->index()->nullable()->comment('スマホメール連絡可否');
            $table->string('mobile_email_check', 1)->index()->nullable()->comment('携帯メール連絡可否');
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
        Schema::dropIfExists('clients');
    }
}
