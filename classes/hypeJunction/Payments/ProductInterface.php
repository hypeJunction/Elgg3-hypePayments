<?php

namespace hypeJunction\Payments;

use Serializable;

/**
 * Product interface
 *
 * @property int    $price
 * @property string $currency
 */
interface ProductInterface extends Serializable {

	/**
	 * Returns Product id
	 * @return string
	 */
	public function getId();

	/**
	 * Returns the merchant
	 * @return MerchantInterface
	 */
	public function getMerchant();

	/**
	 * Returns title
	 * @return string
	 */
	public function getTitle();

	/**
	 * Returns description
	 * @return string
	 */
	public function getDescription();

	/**
	 * Normalizes and sets product price excluding charges
	 *
	 * @param Amount $price Price
	 * @return void
	 */
	public function setPrice(Amount $price);

	/**
	 * Returns product price excluding charges
	 * @return Amount
	 */
	public function getPrice();

	/**
	 * Returns product price including charges
	 * @return Amount
	 */
	public function getTotalPrice();

	/**
	 * Set charges that apply to the subtotal
	 * Charges may include VAT, packaging, gift wrap etc.
	 *
	 * @param ChargeInterface[] $charges Charges
	 * @return self
	 */
	public function setCharges($charges);

	/**
	 * Get charges that apply to the subtotal
	 * @return ChargeInterface[]
	 */
	public function getCharges();

	/**
	 * Add stock
	 *
	 * @param int $quantity Quantity to add
	 * @return bool
	 */
	public function addStock($quantity = 1);

	/**
	 * Returns current stock
	 * @return int
	 */
	public function getStock();

	/**
	 * Check if item is in stock
	 *
	 * @param int $quantity Quantity
	 * @return bool
	 */
	public function inStock($quantity = 1);

	/**
	 * Export to array suitable for order/order serialization
	 * @param array
	 */
	public function toArray();
}
