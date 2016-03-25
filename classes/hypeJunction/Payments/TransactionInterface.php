<?php

namespace hypeJunction\Payments;

use ElggEntity;
use stdClass;

/**
 * Payment transaction interface
 */
interface TransactionInterface {

	const STATUS_NEW = 'new';
	const STATUS_PAYMENT_PENDING = 'payment_pending';
	const STATUS_PAID = 'paid';
	const STATUS_REFUNDED = 'refunded';
	const STATUS_FAILED = 'failed';
	const STATUS_PARTIALLY_REFUNDED = 'partially_refunded';

	/**
	 * Create a new transaction
	 *
	 * @param ElggEntity $customer     Customer entity
	 * @param ElggEntity $merchant     Merchant entity
	 * @param string     $price_amount Monetary value of the transaction
	 * @param string     $currency     Currency code of the transaction
	 * @param array      $data         Transaction data
	 * @return TransactionInterface
	 */
	public static function factory(ElggEntity $customer, ElggEntity $merchant, $price_amount, $currency, array $data = []);

	/**
	 * Load transaction from it's id
	 *
	 * @param string $transaction_id Transaction ID
	 * @return TransactionInterface
	 */
	public static function getFromId($transaction_id);

	/**
	 * Update status
	 *
	 * @param string $status Status
	 * @param array  $params Additional params
	 * @return bool
	 */
	public function setStatus($status, array $params = []);

	/**
	 * Add details of the transaction
	 *
	 * @param string $name  Name of the transaction attribute
	 * @param mixed  $value Value
	 * @return bool
	 */
	public function setDetails($name, $value = null);

	/**
	 * Get details of the transaction
	 *
	 * @param string $name Name of the attribute
	 * @return mixed
	 */
	public function getDetails($name = null);

	/**
	 * Get a plain old object copy for public consumption
	 * @return stdClass
	 */
	public function toObject();

	/**
	 * Set payer of the transaction
	 *
	 * @param ElggEntity $customer Payer
	 * @return void
	 */
	public function setCustomer(ElggEntity $customer);

	/**
	 * Get payer of the transaction
	 * @return ElggEntity|false
	 */
	public function getCustomer();

	/**
	 * Set recipient of the transaction
	 *
	 * @param ElggEntity $merchant Merchant
	 * @return void
	 */
	public function setMerchant(ElggEntity $merchant);

	/**
	 * Get recipient of the transaction
	 * @return ElggEntity|false
	 */
	public function getMerchant();

	/**
	 * Set monetary value of the transaction (total)
	 *
	 * @param int $amount Amount
	 * @return void
	 */
	public function setAmount($amount);

	/**
	 * Returns monetary value
	 * @return int
	 */
	public function getAmount();

	/**
	 * Set currency of the transaction
	 *
	 * @param string $currency Currency code
	 * @return void
	 */
	public function setCurrency($currency);

	/**
	 * Returns currency
	 * @return string
	 */
	public function getCurrency();

	/**
	 * Returns commission rate that should be credited to the site
	 *
	 * @param GatewayInterface $interface Payment gateway
	 * @return float
	 */
	public function getCommissionRate(GatewayInterface $interface);
}
