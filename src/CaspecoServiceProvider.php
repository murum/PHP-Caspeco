<?php

/*
 * This file is part of Caspeco.
 *
 (c) Schimpanz Solutions <info@schimpanz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Schimpanz\Caspeco;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

/**
 * This is the Caspeco service provider class.
 *
 * @author Vincent Klaiber <vincent@schimpanz.com>
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
        $this->setupConfig($this->app);
    }

    /**
     * Setup the config.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function setupConfig(Application $app)
    {
        $source = realpath(__DIR__.'/../config/caspeco.php');

        if (class_exists('Illuminate\Foundation\Application', false) && $app->runningInConsole()) {
            $this->publishes([$source => config_path('caspeco.php')]);
        } elseif (class_exists('Laravel\Lumen\Application', false)) {
            $app->configure('caspeco');
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
        $this->registerFactory($this->app);
        $this->registerManager($this->app);
        $this->registerBindings($this->app);
    }

    /**
     * Register the factory class.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function registerFactory(Application $app)
    {
        $app->singleton('caspeco.factory', function () {
            return new CaspecoFactory();
        });

        $app->alias('caspeco.factory', CaspecoFactory::class);
    }

    /**
     * Register the manager class.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function registerManager(Application $app)
    {
        $app->singleton('caspeco', function ($app) {
            $config = $app['config'];
            $factory = $app['caspeco.factory'];

            return new CaspecoManager($config, $factory);
        });

        $app->alias('caspeco', CaspecoManager::class);
    }

    /**
     * Register the bindings.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function registerBindings(Application $app)
    {
        $app->bind('caspeco.connection', function ($app) {
            $manager = $app['caspeco'];

            return $manager->connection();
        });

        $app->alias('caspeco.connection', Caspeco::class);
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
