<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('item_id')->comment('分项id');
            $table->string('unit')->nullable()->comment('单位');
            $table->string('mea_mode')->nullable()->comment('计量方式');
            $table->double('tax_ratio')->nullable()->comment('税率');
            $table->double('fees_ratio')->nullable()->comment('规费费率');
            $table->string('remark_one')->nullable()->comment('备注1');
            $table->string('remark_two')->nullable()->comment('备注2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalogs');
    }
}
