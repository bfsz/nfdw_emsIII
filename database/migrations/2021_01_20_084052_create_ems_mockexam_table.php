<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmsMockexamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ems_mockexam', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mkems_byid')->nullable()->comment('考生ID');
            $table->string('mkems_name')->nullable()->comment('模拟考试名');
            $table->integer('mkems_declaration_id')->nullable()->comment('种类');
            $table->integer('mkems_major_id')->nullable()->comment('专业');
            $table->longText('mkems_question')->nullable()->comment('试题');
            $table->text('mkems_answer')->nullable()->comment('答案');
            $table->longText('mkems_analysis')->nullable()->comment('试题分析');
            $table->timestamp('mkems_startdate')->nullable()->comment('开始时间');
            $table->timestamp('mkems_enddate')->nullable()->comment('结束时间');
            $table->string('mkems_timespent')->nullable()->comment('总用时');
            $table->string('mkems_url')->nullable()->comment('模拟考试地址');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ems_mockexam');
    }
}
