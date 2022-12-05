<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
// use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Schema::defaultStringLength(191);

    
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        Paginator::useBootstrap();
        Blade::directive('money', function ($amount) {
            // list($amo, $name) = explode(', ', $expression);
            // if (!$decimal) {
            //     // $number = number_format($amount, 2);
            // }
            return "<?php echo '৳' . number_format($amount, 0); ?>";
        });

        Blade::directive('money_tag', function ($amount) {
            return "<?php echo '<bdi><span class=\"price-currency-symbol\">৳&nbsp;</span>' . number_format($amount, 0) . '</bdi>'; ?>";
        });

        // sql log
        // session_start();
        // $_SESSION['x'] = 0;
        // Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {

        //     echo '<pre>';
        //     print_r([$_SESSION['x']+=1, $query->sql, $query->bindings, $query->time]);
        //     echo '</pre>';
        // });
        
    }
}
