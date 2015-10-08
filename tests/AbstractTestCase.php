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

use GrahamCampbell\TestBench\AbstractPackageTestCase;
use Schimpanz\Caspeco\CaspecoServiceProvider;

/**
 * This is the abstract test case class.
 *
 * @author Vincent Klaiber <vincent@schimpanz.com>
 */
abstract class AbstractTestCase extends AbstractPackageTestCase
{
    /**
     * Get the service provider class.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return string
     */
    protected function getServiceProviderClass($app)
    {
        return CaspecoServiceProvider::class;
    }
}
