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

/**
 * This is the cards class.
 *
 * @author Vincent Klaiber <vincent@hoy.se>
 */
final class Cards extends AbstractClient
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
        return $this->post('customers/'.$customerId.'/cards', ['json' => $params]);
    }
}
