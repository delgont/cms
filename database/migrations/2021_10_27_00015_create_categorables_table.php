<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategorablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('categorables') && Schema::hasTable('categories')){
            Schema::create('categorables', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('category_id');
                $table->unsignedBigInteger('categorable_id');
                $table->string('categorable_type');
                $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::dropIfExists('categorables');
    }
}
