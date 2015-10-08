<?php

/*
 * This file is part of Caspeco.
 *
 (c) Schimpanz Solutions <info@schimpanz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Schimpanz\Caspeco;

use BadMethodCallException;
use InvalidArgumentException;

/**
 * This is the Caspeco class.
 *
 * @author Vincent Klaiber <vincent@schimpanz.com>
 */
class Caspeco
{
    /**
     * The config array.
     *
     * @var array
     */
    protected $config;

    /**
     * Create a new Caspeco instance.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        if (!array_key_exists('url', $config)) {
            $config['url'] =  'https://pay.caspeco.net';
        }

        if (!array_key_exists('id', $config)) {
            throw new InvalidArgumentException('The Caspeco client configuration is missing the "id" parameter.');
        }

        if (!array_key_exists('secret', $config)) {
            throw new InvalidArgumentException('The Caspeco client configuration is missing the "secret" parameter.');
        }

        $this->config = $config;
    }

    /**
     * Dynamically handle missing methods.
     *
     * @param string $method
     * @param array $parameters
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, array $parameters = [])
    {
        $class = '\\Schimpanz\\Caspeco\\Http\\Api\\'.ucwords($method);

        if (!class_exists($class)) {
            throw new BadMethodCallException("Undefined method [{$method}] called.");
        }

        return new $class($this->config);
    }
}
