<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('对应管理员id');
            $table->string('name');
            $table->double('area')->comment('建筑总面积');
            $table->double('above_area')->comment('正负零以上建筑面积');
            $table->double('above_open_ratio')->comment('正负零以上展开系数');
            $table->double('below_area')->comment('正负零以下建筑面积');
            $table->double('below_open_ratio')->comment('正负零以下展开系数');
            $table->string('intro')->comment('项目简介');
            $table->double('reference_price')->comment('对比价');
            $table->string('attachment')->nullable()->comment('附件');

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
        Schema::dropIfExists('projects');
    }
}
