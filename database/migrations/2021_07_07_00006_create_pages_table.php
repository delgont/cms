<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('page_key')->unique();
            $table->string('page_title')->unique();
            $table->text('extract_text')->nullable();
            $table->longText('page_content')->nullable();
            $table->enum('published', ['0','1'])->default('1');
            $table->enum('commentable', ['1', '0'])->default('0');
            $table->text('page_featured_image')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('parent_id')->references('id')->on('pages')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post');
    }
}
