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

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Schimpanz\Caspeco\Exceptions\HttpException;

/**
 * This is the abstract client class.
 *
 * @author Vincent Klaiber <vincent@schimpanz.com>
 */
abstract class AbstractClient
{
    /**
     * Create a new abstract api instance.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->client = new Client(['base_uri' => $config['url']]);

        $this->signature = new Signature(
            $config['id'],
            $config['secret'],
            $config['url']
        );
    }

    /**
     * Make a get request.
     *
     * @param string $uri
     * @param array $options
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function get($uri, array $options = [])
    {
        return $this->request(__FUNCTION__, $uri, $options);
    }

    /**
     * Make a post request.
     *
     * @param string $uri
     * @param array $options
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function post($uri, array $options = [])
    {
        return $this->request(__FUNCTION__, $uri, $options);
    }

    /**
     * Make a put request.
     *
     * @param string $uri
     * @param array $options
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function put($uri, array $options = [])
    {
        return $this->request(__FUNCTION__, $uri, $options);
    }

    /**
     * Sign and send request.
     *
     * @param string $method
     * @param string $uri
     * @param array $options
     *
     * @throws \Schimpanz\Caspeco\Exceptions\HttpException
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    protected function request($method, $uri, $options)
    {
        try {
            $request = new Request(
                $method,
                $this->buildUriFromString($uri),
                isset($options['headers']) ? $options['headers'] : [],
                json_encode(isset($options['form_params']) ? $options['form_params'] : [])
            );

            $request = $this->signature->sign($request);

            return $this->client->send($request);
        } catch (RequestException $exception) {
            throw new HttpException(
                $exception->getResponse()->getStatusCode(),
                $exception->getMessage(),
                $exception->getPrevious(),
                $exception->getResponse()->getHeaders(),
                $exception->getCode()
            );
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
