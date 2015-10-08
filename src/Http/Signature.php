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

use DateTime;
use DateTimeZone;

/**
 * This is the signature middleware class.
 *
 * @author Vincent Klaiber <vincent@schimpanz.com>
 */
final class Signature
{
    /**
     * The config array.
     *
     * @var array
     */
    protected $config;

    /**
     * Create a new signature middleware.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Get the headers.
     *
     * @param string $method
     * @param string $uri
     * @param array $body
     *
     * @return array
     */
    public function getHeaders($method, $uri, $body)
    {
        $host = $this->getHost();
        $date = $this->getDate();
        $digest = $this->getDigest($method !== 'get' ? json_encode($body) : '');
        $signature = $this->getSignature($date, $digest, $host, $method, $uri);
        $authorization = $this->getAuthorization($signature);

        echo 'Signature:'.$signature."\n";

        return [
            'Accept' => 'application/json; charset=utf-8',
            'Authorization' => $authorization,
            'Date' => $date,
            'Digest' => $digest,
            'Host' => $host,
        ];
    }

    /**
     * Get the authorization header.
     *
     * @param $signature
     *
     * @return string
     */
    protected function getAuthorization($signature)
    {
        $hash = base64_encode(hash_hmac('sha256', $signature, base64_decode($this->config['secret']), true));

        return sprintf('Signature keyId="%s",algorithm="hmac-sha256",headers="(request-target) host date digest",signature="%s"', $this->config['id'], $hash);
    }

    /**
     * @param \DateTime $date
     * @param string $digest
     * @param string $host
     * @param string $method
     * @param string $uri
     *
     * @return string
     */
    protected function getSignature($date, $digest, $host, $method, $uri)
    {
        return preg_replace('/\s+/', ' ', implode('\n', [
            strtolower(sprintf('(request-target): %s %s', $method, $uri)),
            sprintf('host: %s', $host),
            sprintf('date: %s', $date),
            sprintf('digest: %s', $digest),
        ]));
    }

    /**
     * Get the date header.
     *
     * @param \DateTime $time
     *
     * @return string
     */
    protected function getDate(DateTime $time = null)
    {
        if (!$time) {
            $time = new DateTime('now', new DateTimeZone('GMT'));
        }

        return $time->format('D, d M Y H:i:s').' GMT';
    }

    /**
     * Get the digest hash header.
     *
     * @param string $body
     *
     * @return string
     */
    protected function getDigest($body)
    {
        return 'SHA-256='.base64_encode(hash('sha256', $body, true));
    }

    /**
     * Get the host header.
     *
     * @return string
     */
    protected function getHost()
    {
        return preg_replace('#^https?://#', '', $this->config['url']);
    }
}
