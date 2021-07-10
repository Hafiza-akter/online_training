<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBbsEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bbs_entries', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->dateTime("date");   //開始時刻
            $table->integer("count");   //回数
            $table->double("time");     //時間
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
        Schema::dropIfExists('bbs_entries');
    }
}
