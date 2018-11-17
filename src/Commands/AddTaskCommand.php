<?php

namespace Chester\BackgroundMission\Commands;

use Chester\BackgroundMission\Queue;
use Illuminate\Console\Command;

class AddTaskCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mission:add';

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
        /** @var $queue Queue */
        $queue = $this->laravel->make('chester.bg.queue');
        try {
            $queue->withoutRepeatMethod()->push(['method' => 'helloWorld']);
        } catch (\Exception $exception) {
            $this->output->writeln($exception->getMessage());
        }
    }
}
