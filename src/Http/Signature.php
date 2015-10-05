<?php

namespace Schimpanz\Caspeco\Http;

use DateTime;
use DateTimeZone;
use Illuminate\Contracts\Config\Repository;

class Signature
{
    /**
     * The acceptance header.
     *
     * @var string
     */
    const ACCEPT = 'application/json; charset=utf-8';

    /**
     * The config repository instance.
     *
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * Create a new signature instance.
     *
     * @param \Illuminate\Contracts\Config\Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * Get the authorization header.
     *
     * @param string $uri
     * @param string $host
     * @param string $date
     * @param string $digest
     *
     * @return string
     */
    public function getAuthorization($uri, $date, $digest, $host)
    {
        $signature = sprintf('(request-target): %s\nhost: %s\ndate: %s\ndigest: %s', $uri, $host, $date, $digest);

        $hash = base64_encode(hash_hmac('sha256', $this->config->get('key'), $signature));

        return sprintf('Signature keyId="%s",algorithm="hmac-sha256",headers="(request-target) host date digest",signature="%s"', $this->config->get('id'), $hash);
    }

    /**
     * Get the date header.
     *
     * @param \DateTime $time
     *
     * @return string
     */
    public function getDate(DateTime $time = null)
    {
        if (!$time) {
            $time = new DateTime('now', new DateTimeZone('GMT'));
        }

        return $time->format('D, d M Y H:i:s').' GMT\n';
    }

    /**
     * Get the digest hash header.
     *
     * @param string $uri
     *
     * @return string
     */
    public function getDigest($uri)
    {
        return 'SHA-256='.hash('sha256', $uri);
    }

    /**
     * Get the host header.
     *
     * @return string
     */
    public function getHost()
    {
        return preg_replace('#^https?://#', '', $this->config->get('url'));
    }
}
