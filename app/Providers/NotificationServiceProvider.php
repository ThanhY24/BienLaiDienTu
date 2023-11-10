<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\NotificationModel;
use Illuminate\Support\Facades\Auth;
use View;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $dataNotification = NotificationModel::all();
        View::share('dataNotification', $dataNotification);
    }
}
