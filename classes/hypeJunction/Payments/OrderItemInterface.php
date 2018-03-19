<?php

namespace hypeJunction\Payments;

use Serializable;

/**
 * Order item interface
 *
 * @property ProductInterface $product
 * @property int              $quantity
 */
interface OrderItemInterface extends Serializable {

	/**
	 * Set a property
	 *
	 * @param string $key   Property name
	 * @param mixed  $value Property value
	 * @return self
	 */
	public function set($key, $value);

	/**
	 * Return a property
	 *
	 * @param string $key Property name
	 * @return mixed
	 */
	public function get($key);

	/**
	 * Set product
	 *
	 * @param ProductInterface $product Product
	 * @return self
	 */
	public function setProduct(ProductInterface $product);

	/**
	 * Returns the product
	 * May return false if the product has been deleted
	 * @return ProductInterface|false
	 */
	public function getProduct();

	/**
	 * Returns product ID (guid)
	 * @return int
	 */
	public function getId();

	/**
	 * Returns the title
	 * @return string
	 */
	public function getTitle();

	/**
	 * Returns the description
	 * @return string
	 */
	public function getDescription();

	/**
	 * Returns product price
	 * @return Amount
	 */
	public function getPrice();

	/**
	 * Sets the quantity
	 *
	 * @param int $quantity Quantity
	 * @return self
	 */
	public function setQuantity($quantity = 0);

	/**
	 * Returns quantity of item in order
	 * @return int
	 */
	public function getQuantity();

	/**
	 * Calculate subtotal monetary value of items
	 * @return int
	 */
	public function subtotal();

	/**
	 * Returns subtotal amount
	 * @return Amount
	 */
	public function getSubtotalAmount();

	/**
	 * Set charges that apply to the subtotal
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
	 * Calculate monetary value of charges
	 * @return int
	 */
	public function charges();

	/**
	 * Returns charges amount
	 * @return Amount
	 */
	public function getChargesAmount();

	/**
	 * Calculate total monetary value of items
	 * @return int
	 */
	public function total();

	/**
	 * Returns total amount
	 * @return Amount
	 */
	public function getTotalAmount();

	/**
	 * Export to array
	 * @return array
	 */
	public function toArray();
}
