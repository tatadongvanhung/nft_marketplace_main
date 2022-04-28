<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BackEndServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $models = [
            'User',
            'NFT',
            'Album',
            'Genre',
            'TransactionLog',
            'Comment'
        ];

        foreach ($models as $model) {
            $this->app->bind("App\Repositories\Interfaces\\" . $model . "Repository", "App\Repositories\Eloquents\Db" . $model . "Repository");
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
