<?php

namespace hypeJunction\Payments;

/**
 * Order item interface
 *
 * @property ProductInterface $product
 * @property int              $quantity
 */
interface OrderItemInterface {

	/**
	 * Constructor
	 *
	 * @param ProductInterface $product
	 * @param int              $quantity
	 */
	public function __construct(ProductInterface $product, $quantity = 1);

	/**
	 * Returns product
	 * @return ProductInterface
	 */
	public function getProduct();

	/**
	 * Returns quantity of item in order
	 * @return int
	 */
	public function getQuantity();

	/**
	 * Export to array
	 * @return array
	 */
	public function toArray();
}
