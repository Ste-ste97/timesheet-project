<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        LogViewer::auth(function ($request) {
            return $request->user()->hasPermissionTo('logs.view');
        });
    }
}
