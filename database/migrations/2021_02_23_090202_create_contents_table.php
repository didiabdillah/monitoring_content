<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->bigIncrements('content_id');
            $table->string('content_user_id', 64);
            $table->string('content_title', 255);
            $table->text('content_note')->nullable();
            $table->text('content_comment')->nullable();
            $table->enum('content_type', ['file', 'link']);
            $table->enum('content_status', ['received', 'processing', 'rejected']);
            $table->string('content_file', 255)->nullable();
            $table->string('content_link', 255)->nullable();

            $table->timestamps();

            $table->foreign('content_user_id')->references('user_id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->dropForeign('contents_content_user_id_foreign');
        });
        Schema::dropIfExists('contents');
    }
}
