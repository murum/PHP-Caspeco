<?php

/*
 * This file is part of Caspeco.
 *
 (c) Schimpanz Solutions <info@schimpanz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Schimpanz\Caspeco\Http;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\HandlerStack;
use Illuminate\Contracts\Config\Repository;

/**
 * This is client class.
 *
 * @author Vincent Klaiber <vincent@schimpanz.com>
 */
class Client extends HttpClient
{
    /**
     * Create a new client instance.
     *
     * @param \Illuminate\Contracts\Config\Repository $config
     */
    public function __construct(Repository $config)
    {
        parent::__construct();

        $handler = HandlerStack::create();
        $handler->push(new SignatureMiddleware($config));

        $config['handler'] = $handler;
    }
}
