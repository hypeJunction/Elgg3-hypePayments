<?php

namespace hypeJunction\Payments;

use Elgg\Http\ResponseBuilder;

interface GatewayInterface {

	/**
	 * Returns ID of the gateway
	 * @return string
	 */
	public function id();

	/**
	 * Make a payment
	 * This method can forward to the payment provider website
	 *
	 * @param TransactionInterface $transaction Transaction
	 * @param array                $params      Request parameters
	 *
	 * @return ResponseBuilder
	 */
	public function pay(TransactionInterface $transaction, array $params = []);

	/**
	 * Refund a payment
	 *
	 * @param TransactionInterface $transaction Transaction
	 *
	 * @return bool
	 */
	public function refund(TransactionInterface $transaction);
}
