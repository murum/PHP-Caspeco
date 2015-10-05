<?php

/*
 * This file is part of Caspeco.
 *
 (c) Schimpanz Solutions <info@schimpanz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Schimpanz\Tests\Caspeco;

use DateTime;
use DateTimeZone;
use Schimpanz\Caspeco\Config;
use Schimpanz\Caspeco\Http\Signature;

/**
 * This is the signature test class.
 *
 * @author Vincent Klaiber <vincent@schimpanz.com>
 */
class SignatureTest extends AbstractTestCase
{
    protected $signature;

    /**
     * @before
     */
    public function registerConfig()
    {
        $this->signature = new Signature(new Config([
            'id' => 'your-client-id',
            'key' => 'your-client-key',
        ]));
    }

    public function testDate()
    {
        $date = $this->signature->getDate(new DateTime('21 Oct 2015 04:29:00', new DateTimeZone('GMT')));
        $this->assertSame('Wed, 21 Oct 2015 04:29:00 GMT\n', $date);
    }

    public function testDigest()
    {
        $digest = $this->signature->getDigest('123');
        $this->assertSame('SHA-256=a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', $digest);
    }

    public function testHost()
    {
        $this->assertSame('pay.caspeco.net', $this->signature->getHost());
    }

    public function testAuthorization()
    {
        $uri = '123';
        $date = $this->signature->getDate(new DateTime('21 Oct 2015 04:29:00', new DateTimeZone('GMT')));
        $digest = $this->signature->getDigest($uri);
        $host = $this->signature->getHost();
        $authorization = $this->signature->getAuthorization($uri, $date, $digest, $host);
        $this->assertSame('Signature keyId="your-client-id",algorithm="hmac-sha256",headers="(request-target) host date digest",signature="ZDI2NmU4Njc5M2IzMGRmNGYwYTVjNTFmZjViNTQyODdlZWQ0ZWNmZmYxMDRjZjZkNzJlYjRhZjU3ODE2MThkYQ=="', $authorization);
    }
}
