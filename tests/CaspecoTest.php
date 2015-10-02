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

/**
 * This is the Caspeco test class.
 *
 * @author Vincent Klaiber <vincent@schimpanz.com>
 */
class CaspecoTest extends AbstractTestCase
{
    public function testCaspeco()
    {
        $this->assertInstanceOf(Caspeco::class, new Caspeco());
    }
}
