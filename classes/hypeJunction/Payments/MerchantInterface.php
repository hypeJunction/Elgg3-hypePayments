<?php

namespace hypeJunction\Payments;

interface MerchantInterface {

	/**
	 * Returns Merchant id
	 * @return string
	 */
	public function getId();

	/**
	 * Export
	 * @return array
	 */
	public function toArray();

	/**
	 * Calculate charges on a given set of items
	 * 
	 * @param OrderInterface $order Order
	 * @return ChargeInterface[]
	 */
	public function getCharges(OrderInterface $order);

}
