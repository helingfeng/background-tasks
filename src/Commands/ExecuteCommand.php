<?php

namespace Chester\BackgroundMission\Commands;

use Illuminate\Console\Command;

class ExecuteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mission:execute';

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
        $this->output->writeln('chester.queue.start');
        $this->laravel->make('chester.bg.queue')->frequencyRun();
        $this->output->writeln('chester.queue.end');
    }
}
