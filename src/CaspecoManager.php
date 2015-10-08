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

use GrahamCampbell\Manager\AbstractManager;
use Illuminate\Contracts\Config\Repository;

/**
 * This is the Caspeco manager class.
 *
 * @author Vincent Klaiber <vincent@schimpanz.com>
 */
class CaspecoManager extends AbstractManager
{
    /**
     * The factory instance.
     *
     * @var \Schimpanz\Caspeco\CaspecoFactory
     */
    private $factory;

    /**
     * Create a new Caspeco manager instance.
     *
     * @param \Illuminate\Contracts\Config\Repository $config
     * @param \Schimpanz\Caspeco\CaspecoFactory $factory
     *
     * @return void
     */
    public function __construct(Repository $config, CaspecoFactory $factory)
    {
        parent::__construct($config);

        $this->factory = $factory;
    }

    /**
     * Create the connection instance.
     *
     * @param array $config
     *
     * @return mixed
     */
    protected function createConnection(array $config)
    {
        return $this->factory->make($config);
    }

    /**
     * Get the configuration name.
     *
     * @return string
     */
    protected function getConfigName()
    {
        return 'caspeco';
    }

    /**
     * Get the factory instance.
     *
     * @return \Schimpanz\Caspeco\CaspecoFactory
     */
    public function getFactory()
    {
        return $this->factory;
    }
}
