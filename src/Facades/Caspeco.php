<?php

/*
 * This file is part of Caspeco.
 *
 (c) Schimpanz Solutions <info@schimpanz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Schimpanz\Caspeco\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * This is the Caspeco facade class.
 *
 * @author Vincent Klaiber <vincent@schimpanz.com>
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
