<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('setting_id');
            $table->string('setting_api_whatsapp', 255)->nullable();
            $table->string('setting_api_telegram', 255)->nullable();
            $table->string('setting_smtp_host', 255)->nullable();
            $table->string('setting_smtp_port', 5)->nullable();
            $table->string('setting_smtp_user', 255)->nullable();
            $table->string('setting_smtp_password', 255)->nullable();
            $table->string('setting_logo', 255)->nullable();
            $table->string('setting_favicon', 255)->nullable();

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
        Schema::dropIfExists('settings');
    }
}
