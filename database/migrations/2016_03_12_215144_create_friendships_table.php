<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFriendshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('friendships', function (Blueprint $table) {
            $table->increments('id');// 主键 自增
            $table->integer('user1_id')->unsigned()->index();
            $table->foreign('user1_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('user2_id')->unsigned()->index();
            $table->foreign('user2_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps(); // 自动创建的两个字段：created_at 和 updated_at

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('friendships');
    }
}
