<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class Tasks extends Migration
{
    public function up()
    {
        Schema::create('admin_background_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unique_id', 30)->default('')->comment('任务标识');
            $table->string('method', 50)->default('')->comment('方法名称');
            $table->string('params', 250)->default('')->comment('参数');
            $table->string('type', 20)->default('system')->comment('任务类型');
            $table->string('state', 20)->default('')->comment('任务状态');
            $table->string('content', 500)->default('')->comment('内容');
            $table->string('creator', 50)->default('admin')->comment('任务创建者');
            $table->dateTime('created_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('modified_date')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    public function down()
    {
        Schema::drop('admin_background_tasks');
    }
}
