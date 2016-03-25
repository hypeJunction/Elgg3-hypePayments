<?php

namespace hypeJunction\Payments;

/**
 * Order interface
 */
interface OrderInterface {

	/**
	 * Set a property
	 * 
	 * @param string $key   Property name
	 * @param mixed  $value Property value
	 * @return mixed
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
	 * Calculate subtotal monetary value of items
	 * @return int
	 */
	public function subtotal();

	/**
	 * Calculate monetary value of charges
	 * @return int
	 */
	public function charges();

	/**
	 * Calculate total monetary value of items
	 * @return int
	 */
	public function total();

	/**
	 * Export to array
	 * @return array
	 */
	public function toArray();

}
