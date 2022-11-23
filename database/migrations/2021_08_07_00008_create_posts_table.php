<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('post_title')->unique();
            $table->text('extract_text')->nullable();
            $table->longText('post_content')->nullable();
            $table->text('post_featured_image')->nullable();
            $table->enum('published', ['0','1'])->default('1');
            $table->enum('commentable', ['1', '0'])->default('0');
            $table->string('slug')->unique()->nullable();
            $table->string('url')->unique()->nullable();
            $table->enum('type', ['1', '2'])->default('1');
            $table->unsignedBigInteger('post_type_id')->nullable();
            $table->unsignedBigInteger('template_id')->nullable();
            $table->unsignedBigInteger('menu_id')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('post_type_id')->references('id')->on('post_types')->onDelete('set null');
            $table->foreign('template_id')->references('id')->on('templates')->onDelete('set null');
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('set null');
            $table->foreign('parent_id')->references('id')->on('posts')->onDelete('set null');

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
