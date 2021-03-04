<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMissedUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('missed_uploads', function (Blueprint $table) {
            $table->bigIncrements('missed_upload_id');
            $table->string('missed_upload_user_id', 64);
            $table->date('missed_upload_date');
            $table->integer('missed_upload_total');
            $table->timestamps();

            $table->foreign('missed_upload_user_id')->references('user_id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('missed_uploads', function (Blueprint $table) {
            $table->dropForeign('missed_uploads_missed_upload_user_id_foreign');
        });
        Schema::dropIfExists('missed_uploads');
    }
}
