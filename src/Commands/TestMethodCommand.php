<?php

namespace Chester\BackgroundMission\Commands;

use Chester\BackgroundMission\Logic;
use Illuminate\Console\Command;

class TestMethodCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mission:test {--method=helloWorld}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '测试添加一个任务到后台执行';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $method = $this->option('method');

        /** @var $logic Logic */
        $logic = $this->laravel->make('chester.bg.logic');
        $logic->$method();

    }
}
