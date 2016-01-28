<?php

/*
 * This file is part of Caspeco.
 *
 (c) HOY Multimedia AB <info@hoy.se>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hoy\Caspeco\Http;

use DateTime;
use DateTimeZone;
use Psr\Http\Message\RequestInterface;

/**
 * This is the signature middleware class.
 *
 * @author Vincent Klaiber <vincent@hoy.se>
 */
final class Signature
{
    /**
     * The client id.
     *
     * @var string
     */
    protected $id;

    /**
     * The client secret.
     *
     * @var string
     */
    protected $secret;

    /**
     * The client url.
     *
     * @var string
     */
    protected $url;

    /**
     * Create a new signature instance.
     *
     * @param string $id
     * @param string $secret
     * @param string $url
     */
    public function __construct($id, $secret, $url)
    {
        $this->id = $id;
        $this->secret = $secret;
        $this->url = $url;
    }

    /**
     * Sign given request.
     *
     * @param \Psr\Http\Message\RequestInterface $request
     *
     * @return \Psr\Http\Message\RequestInterface
     */
    public function sign(RequestInterface $request)
    {
        $request = $request->withHeader('Accept', 'application/json; charset=utf-8');

        $host = $this->getHostFromUrl($this->url);
        $request = $request->withHeader('Host', $host);

        $date = $this->formatDate(new DateTime('now', new DateTimeZone('GMT')));
        $request = $request->withHeader('Date', $date);

        $body = strtolower($request->getMethod()) === 'get' ? '' : $request->getBody()->getContents();
        $digest = $this->hashDigest($body);
        $request = $request->withHeader('Digest', $digest);

        $target = strtolower(sprintf('%s %s', $request->getMethod(), $request->getRequestTarget()));
        $signature = "(request-target): {$target}\nhost: {$host}\ndate: {$date}\ndigest: {$digest}";

        $request = $request->withHeader('Authorization', $this->authorizeSignature($signature));

        return $request;
    }

    /**
     * Get the authorization header.
     *
     * @param $signature
     *
     * @return string
     */
    protected function authorizeSignature($signature)
    {
        $hash = base64_encode(hash_hmac('sha256', $signature, base64_decode($this->secret), true));

        return sprintf('Signature keyId="%s",algorithm="hmac-sha256",headers="(request-target) host date digest",signature="%s"', $this->id, $hash);
    }

    /**
     * Get the date header.
     *
     * @param \DateTime $time
     *
     * @return string
     */
    protected function formatDate(DateTime $time)
    {
        return $time->format('D, d M Y H:i:s').' GMT';
    }

    /**
     * Get the hash header.
     *
     * @param string $body
     *
     * @return string
     */
    protected function hashDigest($body)
    {
        return 'SHA-256='.base64_encode(hash('sha256', $body, true));
    }

    /**
     * Get the host header.
     *
     * @param string $url
     *
     * @return string
     */
    protected function getHostFromUrl($url)
    {
        preg_match('/([a-z0-9\-]+\.){1,2}[a-z]{2,4}/', $url, $matches);

        return $matches[0];
    }
}
