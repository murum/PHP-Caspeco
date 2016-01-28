<?php

/*
 * This file is part of Caspeco.
 *
 (c) HOY Multimedia AB <info@hoy.se>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hoy\Tests\Caspeco\Facades;

use GrahamCampbell\TestBenchCore\FacadeTrait;
use Hoy\Caspeco\CaspecoManager;
use Hoy\Caspeco\Facades\Caspeco;
use Hoy\Tests\Caspeco\AbstractTestCase;

/**
 * This is the Caspeco test class.
 *
 * @author Vincent Klaiber <vincent@hoy.se>
 */
class CaspecoTest extends AbstractTestCase
{
    use FacadeTrait;

    /**
     * Get the facade accessor.
     *
     * @return string
     */
    protected function getFacadeAccessor()
    {
        return 'caspeco';
    }

    /**
     * Get the facade class.
     *
     * @return string
     */
    protected function getFacadeClass()
    {
        return Caspeco::class;
    }

    /**
     * Get the facade root.
     *
     * @return string
     */
    protected function getFacadeRoot()
    {
        return CaspecoManager::class;
    }
}
