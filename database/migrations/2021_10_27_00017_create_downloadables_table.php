<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDownloadablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('downloadables') && Schema::hasTable('downloads')){
            Schema::create('downloadables', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('download_id');
                $table->unsignedBigInteger('attachedto_id');
                $table->string('attachedto_type');
                $table->foreign('download_id')->references('id')->on('downloads')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('downloadables');
    }
}
