<?php

namespace Chester\BackgroundMission\Commands;

use Illuminate\Console\Command;

class AddTaskCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mission:test-add-task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '后台任务管理工具，执行任务';

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
        $queue = $this->laravel->make('chester.bg.queue');
        $queue->push(['method' => 'helloWorld']);
        $queue->push(['method' => 'helloWorldAfter15Seconds']);
    }
}
