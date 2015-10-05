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

use Illuminate\Contracts\Config\Repository;
use Psr\Http\Message\RequestInterface;

/**
 * This is the signature middleware class.
 *
 * @author Vincent Klaiber <vincent@schimpanz.com>
 */
final class SignatureMiddleware
{
    /**
     * Create a new signature middleware.
     *
     * @param \Illuminate\Contracts\Config\Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->signature = new Signature($config);
    }

    /**
     * Handle the middleware.
     *
     * @param \Psr\Http\Message\RequestInterface $request
     *
     * @return void
     */
    private function onBefore(RequestInterface $request)
    {
        $uri = $request->getUri();
        $date = $this->signature->getDate();
        $digest = $this->signature->getDigest($uri);
        $host = $this->signature->getHost();

        $authorization = $this->signature->getAuthorization($uri, $date, $digest, $host);

        $request->withHeader('Accept', Signature::ACCEPT);
        $request->withHeader('Authorization', $authorization);
        $request->withHeader('Date', $date);
        $request->withHeader('Digest', $digest);
        $request->withHeader('Host', $host);
    }

    /**
     * Called when the middleware is handled.
     *
     * @param callable $handler
     *
     * @return \Closure
     */
    public function __invoke(callable $handler)
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            if (isset($options['auth']) && $options['auth'] === 'http-signatures') {
                $request = $this->onBefore($request);
            }

            return $handler($request, $options);
        };
    }
}
