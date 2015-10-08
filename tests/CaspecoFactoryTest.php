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

use Schimpanz\Caspeco\Caspeco;
use Schimpanz\Caspeco\CaspecoFactory;

/**
 * This is the Caspeco factory test class.
 *
 * @author Vincent Klaiber <vincent@schimpanz.com>
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
