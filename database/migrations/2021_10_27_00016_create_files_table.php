<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('files')){
            Schema::create('files', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('label')->nullable();
                $table->text('url');
                $table->string('mime_type');
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        if(!Schema::hasTable('model_has_files') && Schema::hasTable('files')){
            Schema::create('model_has_files', function (Blueprint $table) {
                $table->unsignedBigInteger('file_id');
                $table->string('model_type');
                $table->unsignedBigInteger('model_id');
                $table->timestamps();

                $table->foreign('file_id')
                ->references('id')
                ->on('files')
                ->onDelete('cascade');

                $table->primary(['file_id', 'model_id', 'model_type'], 'model_has_files_file_model_model_type_primary');

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
        Schema::dropIfExists('downloads');
    }
}
