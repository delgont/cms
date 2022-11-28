<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       if(!Schema::hasTable('categories')){
            Schema::create('categories', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name')->unique();
                $table->string('type')->nullable();
                $table->string('description')->nullable();
                $table->unsignedBigInteger('parent_id')->nullable();
                $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
                $table->timestamps();

            });
       }

       if(!Schema::hasTable('categorables') && Schema::hasTable('categories')){
        Schema::create('categorables', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('categorable_id');
            $table->string('categorable_type');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();

            $table->primary(['category_id', 'categorable_id', 'categorable_type'], 'categorable_category_id_categorable_id_categorable_type_primary');

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
        Schema::dropIfExists('categories');
    }
}
