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

/**
 * This is the Caspeco class.
 *
 * @author Vincent Klaiber <vincent@schimpanz.com>
 */
class Caspeco
{
    /**
     * The config repository instance.
     *
     * @var \Schimpanz\Caspeco\Config
     */
    protected $config;

    /**
     * Create a new Caspeco instance.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = new Config($config);
    }
}
