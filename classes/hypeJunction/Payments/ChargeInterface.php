<?php

namespace hypeJunction\Payments;

/**
 * Additional charges, including tax, shipping, discounts, coupons etc.
 */
interface ChargeInterface {

	/**
	 * Constructor
	 * 
	 * @param string $id   Charge id
	 * @param float  $rate Percentile rate
	 * @param int    $flat Flat rate
	 */
	public function __construct($id = '', $rate = 0.00, $flat = 0);

	/**
	 * Returns charge id
	 * @return string
	 */
	public function getId();

	/**
	 * Returns percentile rate
	 * @return float
	 */
	public function getRate();

	/**
	 * Returns flat rate
	 * @return int
	 */
	public function getFlat();

	/**
	 * Calcualtes charge amount from base amount
	 * ($amount * $rate / 100) + $flat
	 *
	 * @param int $amount Base
	 * @return int
	 */
	public function calculate($amount);

	/**
	 * Export to array suitable for order/order serialization
	 * @param array
	 */
	public function toArray();
}
