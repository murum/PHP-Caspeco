<?php

/*
 * This file is part of Caspeco.
 *
 (c) Schimpanz Solutions <info@schimpanz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Schimpanz\Tests\Caspeco;

use Illuminate\Contracts\Config\Repository;
use Mockery;
use Schimpanz\Caspeco\Caspeco;
use Schimpanz\Caspeco\CaspecoFactory;
use Schimpanz\Caspeco\CaspecoManager;

/**
 * This is the Caspeco manager test class.
 *
 * @author Vincent Klaiber <vincent@schimpanz.com>
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
