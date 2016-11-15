<?php

namespace hypeJunction\Payments;

use Elgg\Http\ResponseBuilder;

interface GatewayInterface {

	/**
	 * Make a payment
	 * This method can forward to the payment provider website
	 * 
	 * @param TransactionInterface $transaction Transaction
	 * @return ResponseBuilder
	 */
	public function pay(TransactionInterface $transaction);

	/**
	 * Refund a payment
	 *
	 * @param TransactionInterface $transaction Transaction
	 * @return bool
	 */
	public function refund(TransactionInterface $transaction);
}
