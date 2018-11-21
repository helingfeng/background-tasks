<?php

namespace Chester\BackgroundMission\Providers;

use Chester\BackgroundMission\Managers\DataBaseMission;
use Chester\BackgroundMission\Queue;
use Illuminate\Support\ServiceProvider;

class MissionProvider extends ServiceProvider
{

    protected $commands = [
        'Chester\BackgroundMission\Commands\ExecuteCommand',
        'Chester\BackgroundMission\Commands\RecordsCommand',
        'Chester\BackgroundMission\Commands\AddTaskCommand',
        'Chester\BackgroundMission\Commands\TestMethodCommand',
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('chester.bg.db_manager', function () {
            return new DataBaseMission();
        });

        $this->app->singleton('chester.bg.logic', function () {
            $class_name = config('const.background_logic', '\Chester\BackgroundMission\Logic');
            return new $class_name();
        });

        $this->app->singleton('chester.bg.queue', function () {
            return new Queue(
                $this->app['chester.bg.db_manager'],
                $this->app['chester.bg.logic']
            );
        });

        $this->commands($this->commands);
    }
}
