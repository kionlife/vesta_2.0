<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
		//Schema::defaultStringLength(200);
        Blade::directive('money', function ($money) {
            return "<?php echo number_format($money, 2, ',', ' '); ?>";
        });

        Blade::directive('date', function ($date) {
            return "<?php echo \Carbon\Carbon::parse($date)->format('d.m.Y H:i:s'); ?>";
        });
    }
}
