<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('type')->nullable(); /// The model class for which this group is assigned
            $table->text('description')->nullable();
            $table->timestamps();
           
        });

        Schema::create('groupables', function (Blueprint $table) {
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('groupable_id');
            $table->string('groupable_type');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
            $table->timestamps();

            $table->primary(['group_id', 'groupable_id', 'groupable_type'], 'groupable_key_primary');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups');
    }
}
