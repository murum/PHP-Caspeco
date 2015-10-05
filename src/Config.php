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

use Illuminate\Config\Repository;
use Illuminate\Contracts\Config\Repository as RepositoryInterface;
use InvalidArgumentException;

/**
 * This is the config class.
 *
 * @author Vincent Klaiber <vincent@schimpanz.com>
 */
class Config extends Repository implements RepositoryInterface
{
    /**
     * The Caspeco API url.
     */
    const URL = 'https://pay.caspeco.net';

    /**
     * Create a new config instance.
     *
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        if (!array_key_exists('url', $items)) {
            $items['url'] = self::URL;
        }

        if (!array_key_exists('id', $items)) {
            throw new InvalidArgumentException('The Caspeco client configuration is missing the "id" parameter.');
        }

        if (!array_key_exists('key', $items)) {
            throw new InvalidArgumentException('The Caspeco client configuration is missing the "key" parameter.');
        }

        parent::__construct($items);
    }
}
