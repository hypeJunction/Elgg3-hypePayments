<?php

namespace hypeJunction\Payments;

use Serializable;

/**
 * Additional charges, including tax, shipping, discounts, coupons etc.
 */
interface ChargeInterface extends Serializable {

	/**
	 * Sets the ID of the charge
	 * Used in language keys
	 *
	 * @param string $id ID
	 * @return self
	 */
	public function setId($id = '');

	/**
	 * Returns charge id
	 * @return string
	 */
	public function getId();

	/**
	 * Sets the charge rate
	 *
	 * @param float $rate Rate
	 * @return self
	 */
	public function setRate($rate = 0.00);

	/**
	 * Returns percentile rate
	 * @return float
	 */
	public function getRate();

	/**
	 * Sets the flat amount
	 *
	 * @param Amount $amount Amount of the flat fee
	 * @return self
	 */
	public function setFlatAmount(Amount $amount);

	/**
	 * Returns flat rate
	 * @return Amount
	 */
	public function getFlatAmount();

	/**
	 * Sets base amount
	 *
	 * @param Amount $amount Base of the calculation
	 * @return self
	 */
	public function setBaseAmount(Amount $amount);

	/**
	 * Returns base amount
	 * @return Amount
	 */
	public function getBaseAmount();

	/**
	 * Calculates charge amount from base amount
	 * ($amount * $rate / 100) + $flat
	 *
	 * @return Amount
	 */
	public function getTotalAmount();

	/**
	 * Export to array suitable for order/order serialization
	 * @param array
	 */
	public function toArray();
}
