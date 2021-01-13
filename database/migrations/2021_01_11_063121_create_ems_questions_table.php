<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmsQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasTable('ems_questions')) {
            Schema::create('ems_questions', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('questype_id')->nullable()->comment('题型ID');
                $table->text('que_index')->nullable()->comment('题型');
                $table->integer('que_create_byid')->nullable()->comment('创建人ID');
                $table->string('que_create_byname')->nullable()->comment('创建人');
                $table->integer('que_last_byid')->nullable()->comment('修改人ID');
                $table->string('que_last_byname')->nullable()->comment('修改人');
                $table->text('que_select')->nullable()->comment('选项');
                $table->tinyInteger('que_selectnum')->nullable()->comment('选项数量');
                $table->text('que_answer')->nullable()->comment('答案');
                $table->text('que_describe')->nullable()->comment('解析');
                $table->integer('que_status')->default('1')->nullable()->comment('试题状态');
                $table->integer('que_level')->nullable()->comment('难度');
                $table->integer('que_sequence')->nullable()->comment('权重');
                $table->text('declaration_id')->nullable()->comment('申报种类');
                $table->text('major_id')->nullable()->comment('申报专业');
                $table->integer('que_head_id')->nullable()->comment('题冒ID');
                $table->integer('que_head_satuts')->default('0')->nullable()->comment('是否是题冒题');
                $table->integer('que_son_num')->nullable()->comment('子题数量');
                $table->text('que_son_value')->nullable();
                $table->integer('que_sure_count')->default('0')->nullable()->comment('答对次数');
                $table->integer('que_error_count')->default('0')->nullable()->comment('答错次数');
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
        Schema::dropIfExists('ems_questions');
    }
}
