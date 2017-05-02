<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //交通業者
        Schema::create('admin', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('name_en');
        });
        //路線
        Schema::create('route', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin');
            $table->string('name');
            $table->string('name_en');
        });
        //車站
        Schema::create('station', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin');
            $table->integer('route');
            $table->string('name');
            $table->string('name_en');
            $table->string('code');
        });
        //車站順序
        Schema::create('sequence', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin');
            $table->integer('route');
            $table->integer('station');
            $table->integer('sequence');
        });
        //轉乘對應
        Schema::create('transfer', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('station_a');
            $table->integer('station_b');
            $table->string('type');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admin');
        Schema::drop('route');
        Schema::drop('station');
        Schema::drop('sequence');
        Schema::drop('transfer');
    }
}
