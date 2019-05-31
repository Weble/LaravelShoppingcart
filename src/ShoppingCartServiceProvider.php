<?php

namespace Weble\LaravelShoppingCart;

use Illuminate\Auth\Events\Logout;
use Illuminate\Session\SessionManager;
use Illuminate\Support\ServiceProvider;

class ShoppingCartServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('cart', 'Weble\LaravelShoppingCart\Cart');

        $config = __DIR__ . '/../config/cart.php';
        $this->mergeConfigFrom($config, 'cart');

        $this->publishes([__DIR__ . '/../config/cart.php' => config_path('cart.php')], 'config');

        $this->app['events']->listen(Logout::class, function () {
            if ($this->app['config']->get('cart.destroy_on_logout')) {
                $this->app->make(SessionManager::class)->forget('cart');
            }
        });

        $migrations = [];
        if ( ! class_exists('CreateShoppingcartTable')) {
            // Publish the migration
            $timestamp = date('Y_m_d_His', time());

            $migrations = array_merge($migrations, [
                __DIR__.'/../database/migrations/0000_00_00_000000_create_shoppingcart_table.php' => database_path('migrations/'.$timestamp.'_create_shoppingcart_table.php'),
            ]);
        }

        if ( ! class_exists('AddMetadataToShoppingcartTable')) {
            // Publish the migration
            $timestamp = date('Y_m_d_His', time());

            $migrations = array_merge($migrations, [
                __DIR__.'/../database/migrations/0000_00_00_000000_add_metadata_to_shoppingcart_table.php' => database_path('migrations/'.$timestamp.'_add_metadata_to_shoppingcart_table.php'),
            ]);
        }

        if (count($migrations) > 0) {
            $this->publishes($migrations, 'migrations');
        }
    }
}
