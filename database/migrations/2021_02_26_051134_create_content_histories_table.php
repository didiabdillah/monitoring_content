<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_histories', function (Blueprint $table) {
            $table->bigIncrements('content_history_id');
            $table->unsignedBigInteger('content_history_content_id');
            $table->text('content_history_note')->nullable();
            $table->enum('content_history_status', ['accepted', 'rejected', 'process']);

            $table->timestamps();

            $table->foreign('content_history_content_id')->references('content_id')->on('contents')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('content_histories', function (Blueprint $table) {
            $table->dropForeign('content_histories_content_history_content_id_foreign');
        });
        Schema::dropIfExists('content_histories');
    }
}
