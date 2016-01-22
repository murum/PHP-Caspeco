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

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use Schimpanz\Caspeco\Exceptions\AuthenticationException;
use Schimpanz\Caspeco\Exceptions\HtmlException;
use Schimpanz\Caspeco\Exceptions\HttpException;
use Schimpanz\Caspeco\Exceptions\ValidationException;
use Stringy\Stringy;

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
        $this->signature = new Signature($config['id'], $config['secret'], $config['url']);
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
     * @return mixed
     */
    protected function request($method, $uri, array $options = [])
    {
        $uri = $this->buildUriFromString($uri);

        $body = isset($options['json']) ? json_encode($options['json']) : null;

        $request = new Request($method, $uri, [], $body);
        $request = $this->signature->sign($request);

        $options['headers'] = $request->getHeaders();

        return $this->send($request, $options);
    }

    /**
     * Send the given request.
     *
     * @param \Psr\Http\Message\RequestInterface $request
     * @param array $options
     *
     * @throws \GuzzleHttp\Exception\RequestException
     * @throws \Schimpanz\Caspeco\Exceptions\HttpException
     *
     * @return mixed
     */
    protected function send(RequestInterface $request, array $options = [])
    {
        try {
            $response = $this->client->send($request, $options);

            $body = json_decode($response->getBody()->getContents());

            if (property_exists($body, 'Message')) {
                throw new ValidationException(400, $this->formatJsonError($response->getBody()->getContents()));
            }

            return $body;
        } catch (RequestException $exception) {
            $this->handleException($exception);
        }
    }

    /**
     * Handle Guzzle exception.
     *
     * @param \GuzzleHttp\Exception\RequestException $exception
     *
     * @throws \Schimpanz\Caspeco\Exceptions\HttpException
     */
    protected function handleException(RequestException $exception)
    {
        $code = $exception->getResponse()->getStatusCode();
        $message = $exception->getResponse()->getBody()->getContents();

        if (Stringy::create($message)->isJson()) {
            throw new HttpException($exception->getResponse()->getStatusCode(), $this->formatJsonError($message));
        }

        if (Stringy::create($message)->contains('html')) {
            throw new HtmlException($exception->getResponse()->getStatusCode(), $message);
        }

        throw new AuthenticationException($code, $message);
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

    /**
     * Format JSON error message.
     *
     * @param string $json
     *
     * @return string
     */
    protected function formatJsonError($json)
    {
        $error = json_decode($json);

        return sprintf('%s (%s)', $error->Message, $error->Code);
    }
}
