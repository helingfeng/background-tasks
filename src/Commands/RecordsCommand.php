<?php

namespace Chester\BackgroundMission\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\Table;

class RecordsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mission:records';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '后台任务管理工具，查询任务列表';

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
        $records = $this->laravel->make('chester.bg.queue')->records();

        $heading = ['unique_id', 'method', 'type', 'state', 'params', 'content'];

        $table = new Table($this->output);
        $table->setHeaders($heading)->setRows(collect($records)->only($heading)->toArray());
        $table->render();
    }
}
