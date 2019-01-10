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
            $table->string('name');
            $table->decimal('area',12,2)->comment('建筑总面积');
            $table->decimal('above_area',12,2)->comment('正负零以上建筑面积');
            $table->decimal('above_open_ratio',12,2)->comment('正负零以上展开系数');
            $table->decimal('below_area',12,2)->comment('正负零以下建筑面积');
            $table->decimal('below_open_ratio',12,2)->comment('正负零以下展开系数');
            $table->string('intro')->comment('项目简介');
            $table->string('attachment')->comment('附件');
            $table->decimal('win_bid_price',20,2)->comment('中标价格');
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
