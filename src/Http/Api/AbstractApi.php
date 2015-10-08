<?php

/*
 * This file is part of Caspeco.
 *
 (c) Schimpanz Solutions <info@schimpanz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Schimpanz\Caspeco\Http\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Contracts\Config\Repository;
use InvalidArgumentException;
use Schimpanz\Caspeco\Http\Signature;

/**
 * This is the abstract api class.
 *
 * @method ResponseInterface get($uri, array $options = [])
 * @method ResponseInterface head($uri, array $options = [])
 * @method ResponseInterface put($uri, array $options = [])
 * @method ResponseInterface post($uri, array $options = [])
 * @method ResponseInterface patch($uri, array $options = [])
 * @method ResponseInterface delete($uri, array $options = [])
 *
 * @author Vincent Klaiber <vincent@schimpanz.com>
 */
abstract class AbstractApi
{
    /**
     * The config array.
     *
     * @var array
     */
    protected $config;

    /**
     * Create a new abstract api instance.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->client = new Client(['base_uri' => $config['url']]);
        $this->signature = new Signature($config);
    }

    /**
     * Call the client methods.
     *
     * @param string $method
     * @param array $args
     *
     * @throws \InvalidArgumentException
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function __call($method, $args)
    {
        if (count($args) < 1) {
            throw new InvalidArgumentException('Magic request methods require a URI and optional options array');
        }

        $uri = $this->buildUriFromString($args[0]);
        $options = isset($args[1]) ? $args[1] : [];
        $params = isset($options['form_params']) ? $options['form_params'] : [];

        $options['headers'] = $this->signature->getHeaders($method, $uri, $params);

        try {
            return $this->client->request($method, $uri, $options);
        } catch (ClientException $e) {
            die(var_dump('Request:', $e->getRequest()->getHeaders(), 'Response:', $e->getResponse()->getHeaders(), $e->getMessage()));
        }
    }

    /**
     * Build API uri from string.
     *
     * @param string $uri
     *
     * @return string
     */
    protected function buildUriFromString($uri)
    {
        return $uri = '/v1/'.$uri.'/';
    }
}
