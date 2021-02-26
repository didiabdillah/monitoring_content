<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_links', function (Blueprint $table) {
            $table->bigIncrements('content_link_id');
            $table->unsignedBigInteger('content_link_content_id');
            $table->string('content_link_url', 255);

            $table->timestamps();

            $table->foreign('content_link_content_id')->references('content_id')->on('contents')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('content_links', function (Blueprint $table) {
            $table->dropForeign('content_links_content_link_content_id_foreign');
        });
        Schema::dropIfExists('content_links');
    }
}
