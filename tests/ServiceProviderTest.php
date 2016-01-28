<?php

/*
 * This file is part of Caspeco.
 *
 (c) HOY Multimedia AB <info@hoy.se>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hoy\Tests\Caspeco;

use GrahamCampbell\TestBenchCore\ServiceProviderTrait;
use Hoy\Caspeco\Caspeco;
use Hoy\Caspeco\CaspecoFactory;
use Hoy\Caspeco\CaspecoManager;

/**
 * This is the service provider test class.
 *
 * @author Vincent Klaiber <vincent@hoy.se>
 */
class ServiceProviderTest extends AbstractTestCase
{
    use ServiceProviderTrait;

    public function testCaspecoFactoryIsInjectable()
    {
        $this->assertIsInjectable(CaspecoFactory::class);
    }

    public function testCaspecoManagerIsInjectable()
    {
        $this->assertIsInjectable(CaspecoManager::class);
    }

    public function testBindings()
    {
        $this->assertIsInjectable(Caspeco::class);

        $original = $this->app['caspeco.connection'];
        $this->app['caspeco']->reconnect();
        $new = $this->app['caspeco.connection'];

        $this->assertNotSame($original, $new);
        $this->assertEquals($original, $new);
    }
}
