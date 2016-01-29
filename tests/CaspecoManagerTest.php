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

use Hoy\Caspeco\Caspeco;
use Hoy\Caspeco\CaspecoFactory;
use Hoy\Caspeco\CaspecoManager;
use Illuminate\Contracts\Config\Repository;
use Mockery;

/**
 * This is the Caspeco manager test class.
 *
 * @author Vincent Klaiber <vincent@hoy.se>
 */
class CaspecoManagerTest extends AbstractTestCase
{
    public function testCreateConnection()
    {
        $config = ['path' => __DIR__];

        $manager = $this->getManager($config);

        $manager->getConfig()->shouldReceive('get')->once()
            ->with('caspeco.default')->andReturn('caspeco');

        $this->assertSame([], $manager->getConnections());

        $return = $manager->connection();

        $this->assertInstanceOf(Caspeco::class, $return);

        $this->assertArrayHasKey('caspeco', $manager->getConnections());
    }

    protected function getManager(array $config)
    {
        $repository = Mockery::mock(Repository::class);
        $factory = Mockery::mock(CaspecoFactory::class);

        $manager = new CaspecoManager($repository, $factory);

        $manager->getConfig()->shouldReceive('get')->once()
            ->with('caspeco.connections')->andReturn(['caspeco' => $config]);

        $config['name'] = 'caspeco';

        $manager->getFactory()->shouldReceive('make')->once()
            ->with($config)->andReturn(Mockery::mock(Caspeco::class));

        return $manager;
    }
}
