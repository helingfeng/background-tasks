<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tasks extends Migration
{
    public function up()
    {
        Schema::create('admin_background_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unique_id', 30)->comment('任务标识');
            $table->string('method', 50)->comment('方法名称');
            $table->string('params', 250)->comment('参数');
            $table->string('type', 20)->default('system')->comment('任务类型');
            $table->string('state', 20)->comment('任务状态');
            $table->string('content', 500)->comment('内容');
            $table->dateTime('created_date');
            $table->dateTime('modified_date');
        });
    }

    public function down()
    {
        Schema::drop('admin_background_tasks');
    }
}
