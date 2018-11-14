<?php

namespace Chester\BackgroundMission;


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBackgroundTaskTable extends Migration
{
    public function up()
    {
        Schema::create('admin_background_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unique_id', 30)->comment('任务标识');
            $table->string('method', 20)->comment('方法名称');
            $table->string('params', 250)->comment('参数');
            $table->string('type', 20)->default('system')->comment('任务类型');
            $table->string('state', 20)->comment('任务状态');
            $table->dateTime('created_date');
            $table->dateTime('modified_date');
        });
    }

    public function down()
    {
        Schema::drop('admin_background_tasks');
    }
}
