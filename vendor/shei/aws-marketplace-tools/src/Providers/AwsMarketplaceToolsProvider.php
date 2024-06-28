<?php

namespace Shei\AwsMarketplaceTools\Providers;

use Illuminate\Support\ServiceProvider;

class AwsMarketplaceToolsProvider extends ServiceProvider
{
    public function boot () : void {
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
