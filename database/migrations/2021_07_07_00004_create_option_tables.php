<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {
            $table->increments('id');
            $table->string('option_key')->unique();
            $table->text('option_value')->nullable();
            $table->text('description')->nullable();
            $table->enum('disabled', ['0','1'])->default('0');
            $table->timestamps();
        });

        Schema::create('model_options', function (Blueprint $table) {
            $table->string('key');
            $table->text('value');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');

            $table->timestamps();

            $table->index(['model_type', 'model_id'], 'model_has_options_model_id_model_type_index');

            $table->primary(['key','model_id', 'model_type'],
            'model_has_options_option_model_type_primary');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('options');
    }
}
