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

/**
 * This is the charges class.
 *
 * @author Vincent Klaiber <vincent@schimpanz.com>
 */
final class Charges extends AbstractClient
{
    /**
     * Capture a charge by their id.
     *
     * @param int $id
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function capture($id)
    {
        return $this->post('charges/'.$id.'/capture');
    }

    /**
     * Create a new charge.
     *
     * @param array $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function create($params = [])
    {
        return $this->post('charges', ['form_params' => $params]);
    }

    /**
     * Get a charge by their id.
     *
     * @param int $id
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function find($id)
    {
        return $this->get('charges/'.$id);
    }

    /**
     * Refund a charge by their id.
     *
     * @param int $id
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function refund($id)
    {
        return $this->post('charges/'.$id.'/refund');
    }
}
