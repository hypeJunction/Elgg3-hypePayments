<?php

namespace hypeJunction\Payments;

/**
 * Product interface
 *
 * @property int    $price
 * @property string $currency
 */
interface ProductInterface {

	/**
	 * Returns Product id
	 * @return string
	 */
	public function getId();

	/**
	 * Returns merchant
	 * @return MerchantInterface
	 */
	public function getMerchant();

	/**
	 * Normalizes and sets product price
	 *
	 * @param string $amount       Monetary value
	 * @param string $currencyCode Currency
	 * @return void
	 */
	public function setPrice($amount, $currencyCode);

	/**
	 * Returns formatted price
	 * @return string
	 */
	public function getPrice();

	/**
	 * Returns monetary value
	 * @return int
	 */
	public function getPriceAmount();

	/**
	 * Returns currency
	 * @return string
	 */
	public function getPriceCurrency();

	/**
	 * Calculate charges on this item
	 * @return ChargeInterface[]
	 */
	public function getCharges();

	/**
	 * Export to array suitable for order/order serialization
	 * @param array
	 */
	public function toArray();

	/**
	 * Check if item is in stock
	 *
	 * @param int $quantity Quantity
	 * @return bool
	 */
	public function inStock($quantity = 1);

	/**
	 * Returns images associated with this product
	 *
	 * @param array $options ege* options
	 * @return ProductMediaInterface[]
	 */
	public function getMedia(array $options = []);
}
