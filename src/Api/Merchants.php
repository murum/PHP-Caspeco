<?php

/*
 * This file is part of Caspeco.
 *
 (c) Schimpanz Solutions <info@schimpanz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Schimpanz\Caspeco\Api;

/**
 * This is the merchants class.
 *
 * @author Vincent Klaiber <vincent@schimpanz.com>
 */
final class Merchants extends AbstractApi
{
    /**
     * Create a new merchant.
     *
     * @param array $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function create($params = [])
    {
        return $this->post('merchants', ['form_params' => $params]);
    }

    /**
     * Get a merchant by their id.
     *
     * @param int $id
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function find($id)
    {
        return $this->get('merchants/'.$id);
    }
}
