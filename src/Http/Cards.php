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
 * This is the cards class.
 *
 * @author Vincent Klaiber <vincent@schimpanz.com>
 */
final class Cards extends AbstractApi
{
    /**
     * Create a customer card.
     *
     * @param int $customerId
     * @param array $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function create($customerId, $params = [])
    {
        return $this->post('customers/'.$customerId.'/cards', ['form_params' => $params]);
    }
}
