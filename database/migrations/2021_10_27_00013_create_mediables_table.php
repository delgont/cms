<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('mediables')){
            Schema::create('mediables', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('media_id');
                $table->bigInteger('mediable_id');
                $table->string('mediable_type');
                $table->foreign('media_id')->references('id')->on('media')->onDelete('cascade');
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
        Schema::dropIfExists('mediables');
    }
}
