<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('social_links')){
            Schema::create('social_links', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('platform');
                $table->text('description')->nullable();
                $table->MediumText('link');
                $table->nullableMorphs('sociable');
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
        Schema::dropIfExists('social_links');
    }
}
