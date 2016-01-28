<?php

/*
 * This file is part of Caspeco.
 *
 (c) HOY Multimedia AB <info@hoy.se>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hoy\Caspeco;

use InvalidArgumentException;

/**
 * This is the Caspeco factory class.
 *
 * @author Vincent Klaiber <vincent@hoy.se>
 */
class CaspecoFactory
{
    /**
     * Make a new Caspeco client.
     *
     * @param array $config
     *
     * @return \Hoy\Caspeco\Caspeco
     */
    public function make(array $config)
    {
        $config = $this->getConfig($config);

        return $this->getClient($config);
    }

    /**
     * Get the configuration data.
     *
     * @param array $config
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    protected function getConfig(array $config)
    {
        $keys = ['id', 'secret'];

        foreach ($keys as $key) {
            if (!array_key_exists($key, $config)) {
                throw new InvalidArgumentException('The Caspeco client requires configuration.');
            }
        }

        return array_only($config, ['id', 'secret', 'url']);
    }

    /**
     * Get the Caspeco client.
     *
     * @param array $config
     *
     * @return \Hoy\Caspeco\Caspeco
     */
    protected function getClient(array $config)
    {
        return new Caspeco($config);
    }
}
