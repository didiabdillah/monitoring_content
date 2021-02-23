<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelegramDataSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telegram_data_sources', function (Blueprint $table) {
            $table->bigIncrements('data_id');
            $table->string('chat_id');
            $table->enum('chat_type', ['group', 'private']);
            $table->boolean('chat_mute');

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
        Schema::dropIfExists('telegram_data_sources');
    }
}
