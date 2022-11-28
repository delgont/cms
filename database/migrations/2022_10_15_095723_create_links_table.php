<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('url');
            $table->string('label');
            $table->string('title')->nulable();
            $table->enum('target', ['_blank','_self', '_top', '_parent']);
            $table->timestamps();
        });

        Schema::create('model_has_links', function (Blueprint $table) {
            $table->unsignedBigInteger('link_id');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->timestamps();

            $table->foreign('link_id')->references('id')->on('links')->onDelete('cascade');
            $table->primary(['link_id', 'model_id', 'model_type'], 'linkable_primary_key');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
