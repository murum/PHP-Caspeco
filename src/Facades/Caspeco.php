<?php

/*
 * This file is part of Caspeco.
 *
 (c) HOY Multimedia AB <info@hoy.se>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hoy\Caspeco\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * This is the Caspeco facade class.
 *
 * @author Vincent Klaiber <vincent@hoy.se>
 * @see Hoy\Caspeco\Caspeco
 */
class Caspeco extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'caspeco';
    }
}
