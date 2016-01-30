<?php

/*
 * This file is part of Caspeco.
 *
 (c) HOY Multimedia AB <info@hoy.se>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hoy\Caspeco;

use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;

/**
 * This is the Caspeco service provider class.
 *
 * @author Vincent Klaiber <vincent@hoy.se>
 */
class CaspecoServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig();
    }

    /**
     * Setup the config.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $source = realpath(__DIR__.'/../config/caspeco.php');

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('caspeco.php')]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('caspeco');
        }

        $this->mergeConfigFrom($source, 'caspeco');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFactory();
        $this->registerManager();
        $this->registerBindings();
    }

    /**
     * Register the factory class.
     *
     * @return void
     */
    protected function registerFactory()
    {
        $this->app->singleton('caspeco.factory', function () {
            return new CaspecoFactory();
        });

        $this->app->alias('caspeco.factory', CaspecoFactory::class);
    }

    /**
     * Register the manager class.
     *
     * @return void
     */
    protected function registerManager()
    {
        $this->app->singleton('caspeco', function (Container $app) {
            $config = $app['config'];
            $factory = $app['caspeco.factory'];

            return new CaspecoManager($config, $factory);
        });

        $this->app->alias('caspeco', CaspecoManager::class);
    }

    /**
     * Register the bindings.
     *
     * @return void
     */
    protected function registerBindings()
    {
        $this->app->bind('caspeco.connection', function (Container $app) {
            $manager = $app['caspeco'];

            return $manager->connection();
        });

        $this->app->alias('caspeco.connection', Caspeco::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            'caspeco',
            'caspeco.factory',
            'caspeco.connection',
        ];
    }
}
