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

use GrahamCampbell\TestBench\AbstractPackageTestCase;
use Hoy\Caspeco\CaspecoServiceProvider;

/**
 * This is the abstract test case class.
 *
 * @author Vincent Klaiber <vincent@hoy.se>
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
