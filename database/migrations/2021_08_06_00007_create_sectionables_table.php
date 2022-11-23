<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sectionables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sort')->default(1);
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('sectionable_id')->nullable();
            $table->string('sectionable_type')->nullable();
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');

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
        Schema::dropIfExists('template_sections');
    }
}
