<?php

namespace Chester\BackgroundMission\Providers;

use Chester\BackgroundMission\Logic;
use Chester\BackgroundMission\Managers\DataBaseMission;
use Chester\BackgroundMission\Queue;
use Illuminate\Support\ServiceProvider;

class MissionProvider extends ServiceProvider
{
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
            return new Logic();
        });

        $this->app->singleton('chester.bg.queue', function () {
            return new Queue(
                $this->app['chester.bg.db_manager'],
                $this->app['chester.bg.logic']
            );
        });
    }
}
