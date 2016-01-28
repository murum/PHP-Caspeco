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

/**
 * This is the Caspeco factory test class.
 *
 * @author Vincent Klaiber <vincent@hoy.se>
 */
class CaspecoFactoryTest extends AbstractTestCase
{
    public function testMakeStandard()
    {
        $factory = $this->getCaspecoFactory();

        $return = $factory->make([
            'id' => 'your-client-id',
            'secret' => 'your-client-secret',
            'url' => 'https://testpay.caspeco.net',
        ]);

        $this->assertInstanceOf(Caspeco::class, $return);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testMakeWithoutId()
    {
        $factory = $this->getCaspecoFactory();

        $factory->make([
            'secret' => 'your-client-secret',
        ]);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testMakeWithoutSecret()
    {
        $factory = $this->getCaspecoFactory();

        $factory->make([
            'id' => 'your-client-id',
        ]);
    }

    protected function getCaspecoFactory()
    {
        return new CaspecoFactory();
    }
}
