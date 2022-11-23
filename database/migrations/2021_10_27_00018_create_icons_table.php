<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIconsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('icons')){
            Schema::create('icons', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name')->unique()->nullable();
                $table->string('description')->nullable();
                $table->mediumText('url');
                $table->string('icon_format')->nullable();
                $table->string('mime_type')->nullable();
                $table->nullableMorphs('iconable');
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
        Schema::dropIfExists('icons');
    }
}
