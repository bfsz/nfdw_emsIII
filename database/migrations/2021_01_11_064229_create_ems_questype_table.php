<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmsQuestypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('ems_questype')) {
            Schema::create('ems_questype', function (Blueprint $table) {
                $table->increments('id');
                $table->string('type_name')->default('');
                $table->integer('sort');
                $table->integer('type_choice');
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
        Schema::dropIfExists('ems_questype');
    }
}
