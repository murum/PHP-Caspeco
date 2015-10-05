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

use Illuminate\Config\Repository;
use Schimpanz\Caspeco\Config;

/**
 * This is the config test class.
 *
 * @author Vincent Klaiber <vincent@schimpanz.com>
 */
class ConfigTest extends AbstractTestCase
{
    public function testMakeStandard()
    {
        $config = new Config([
            'id' => 'your-client-id',
            'key' => 'your-client-key',
            'url' => 'http://testpay.caspeco.net',
        ]);

        $this->assertInstanceOf(Repository::class, $config);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testMakeWithoutId() {
        new Config(['key' => 'your-client-key']);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testMakeWithoutKey() {
        new Config(['id' => 'your-client-id']);
    }

    public function testMissingUrl()
    {
        $config = new Config([
            'id' => 'your-client-id',
            'key' => 'your-client-key',
        ]);

        $this->assertSame(Config::URL, $config->get('url'));
    }
}
