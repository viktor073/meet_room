<?php

namespace App\Providers;

use App\Interface\Meet\Data\MeetInterface;
use App\Interface\Meet\MeetRepositoryInterface;
use App\Interface\User\Data\UserInterface;
use App\Models\Meet\Meet;
use App\Models\User;
use App\Repositories\MeetRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserInterface::class, User::class);
        $this->app->bind(MeetInterface::class, \App\Models\Meet\Meet::class);
        $this->app->bind(MeetRepositoryInterface::class, MeetRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
