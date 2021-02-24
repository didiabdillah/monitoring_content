<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_files', function (Blueprint $table) {
            $table->bigIncrements('content_file_id');
            $table->unsignedBigInteger('content_file_content_id');
            $table->string('content_file_original_name', 255);
            $table->string('content_file_hash_name', 255);
            $table->string('content_file_base_name', 255);
            $table->string('content_file_extension', 50);

            $table->timestamps();

            $table->foreign('content_file_content_id')->references('content_id')->on('contents')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('content_files', function (Blueprint $table) {
            $table->dropForeign('content_files_content_user_id_foreign');
        });
        Schema::dropIfExists('content_files');
    }
}
