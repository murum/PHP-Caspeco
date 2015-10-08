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

use InvalidArgumentException;
use Schimpanz\Caspeco\Http\Api\Cards;
use Schimpanz\Caspeco\Http\Api\Charges;
use Schimpanz\Caspeco\Http\Api\Customers;
use Schimpanz\Caspeco\Http\Api\Merchants;

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
            $config['url'] = 'https://pay.caspeco.net';
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
     * Get the cards endpoint.
     *
     * @return \Schimpanz\Caspeco\Http\Api\Cards
     */
    public function cards()
    {
        return new Cards($this->config);
    }

    /**
     * Get the charges endpoint.
     *
     * @return \Schimpanz\Caspeco\Http\Api\Charges
     */
    public function charges()
    {
        return new Charges($this->config);
    }

    /**
     * Get the customers endpoint.
     *
     * @return \Schimpanz\Caspeco\Http\Api\Customers
     */
    public function customers()
    {
        return new Customers($this->config);
    }

    /**
     * Get the merchants endpoint.
     *
     * @return \Schimpanz\Caspeco\Http\Api\Merchants
     */
    public function merchants()
    {
        return new Merchants($this->config);
    }
}
