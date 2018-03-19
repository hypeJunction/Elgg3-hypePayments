<?php

namespace hypeJunction\Payments;

use ElggEntity;
use Serializable;

/**
 * Order interface
 */
interface OrderInterface extends Serializable {

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
	 * Sets the merchant
	 *
	 * @param ElggEntity $merchant Merchant
	 * @return self
	 */
	public function setMerchant(ElggEntity $merchant);

	/**
	 * Returns the merchant
	 * @return ElggEntity|null
	 */
	public function getMerchant();

	/**
	 * Sets the customer
	 *
	 * @param ElggEntity $entity Customer entity
	 * @return self
	 */
	public function setCustomer(ElggEntity $entity);

	/**
	 * Returns the customer
	 * @return ElggEntity|null
	 */
	public function getCustomer();

	/**
	 * Sets the currency code
	 *
	 * @param string $currency Currency
	 * @return self
	 */
	public function setCurrency($currency);

	/**
	 * Returns the currency code
	 * @return string|null
	 */
	public function getCurrency();

	/**
	 * Returns all products in order
	 * @return OrderItemInterface[]
	 */
	public function all();

	/**
	 * Check if order contains a product
	 *
	 * @param ProductInterface $product Product
	 * @return bool
	 */
	public function has(ProductInterface $product);

	/**
	 * Find a order item for product
	 *
	 * @param ProductInterface $product Product
	 * @return OrderItemInterface
	 */
	public function find(ProductInterface $product);

	/**
	 * Adds product to order
	 *
	 * @param ProductInterface $product  Product
	 * @param int              $quantity Quantity
	 * @return OrderItemInterface
	 */
	public function add(ProductInterface $product, $quantity = 1);

	/**
	 * Updates quantity in order
	 *
	 * @param ProductInterface $product  Product
	 * @param int              $quantity New quantity
	 * @return bool
	 */
	public function update(ProductInterface $product, $quantity = 1);

	/**
	 * Removes product from order
	 *
	 * @param ProductInterface $product
	 * @return bool
	 */
	public function remove(ProductInterface $product);

	/**
	 * Count total items
	 * @return int
	 */
	public function count();

	/**
	 * Count total unique items
	 * @return int
	 */
	public function countLines();

	/**
	 * Sets shipping address
	 * @return self
	 */
	public function setShippingAddress(Address $address);

	/**
	 * Returns shipping address
	 * @return Address|null
	 */
	public function getShippingAddress();

	/**
	 * Sets billing address
	 * @return self
	 */
	public function setBillingAddress(Address $address);

	/**
	 * Returns billing address
	 * @return Address|null
	 */
	public function getBillingAddress();

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
