<?php

namespace hypeJunction\Payments;

use ElggEntity;
use Serializable;

/**
 * Payment transaction interface
 */
interface TransactionInterface extends Serializable {

	const STATUS_NEW = 'new';
	const STATUS_PAYMENT_PENDING = 'payment_pending';
	const STATUS_PAID = 'paid';
	const STATUS_REFUNDED = 'refunded';
	const STATUS_PARTIALLY_REFUNDED = 'partially_refunded';
	const STATUS_REFUND_PENDING = 'refund_pending';
	const STATUS_FAILED = 'failed';

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
	 * @return self
	 */
	public function setStatus($status, array $params = []);

	/**
	 * Returns current status
	 * @return string
	 */
	public function getStatus();

	/**
	 * Sets transaction ID
	 * 
	 * @param string $transaction_id ID
	 * @return self
	 */
	public function setId($transaction_id);

	/**
	 * Returns transaction ID
	 * @return string
	 */
	public function getId();

	/**
	 * Sets payment method (gateway)
	 *
	 * @param string $payment_method Payment method
	 * @return self
	 */
	public function setPaymentMethod($payment_method);

	/**
	 * Returns payment method
	 * @return string|null
	 */
	public function getPaymentMethod();

	/**
	 * Sets the funding source used within the payment method (gateway)
	 *
	 * @param FundingSourceInterface $funding_source Funding source
	 * @return self
	 */
	public function setFundingSource(FundingSourceInterface $funding_source);

	/**
	 * Returns funding source
	 * @return FundingSourceInterface|null
	 */
	public function getFundingSource();

	/**
	 * Sets order
	 * 
	 * @param OrderInterface $order Order
	 * @return self
	 */
	public function setOrder(OrderInterface $order);

	/**
	 * Returns an order
	 * @return OrderInterface|false
	 */
	public function getOrder();

	/**
	 * Set payer of the transaction
	 *
	 * @param ElggEntity $customer Payer
	 * @return self
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
	 * @param Amount $amount
	 * @return self
	 */
	public function setAmount(Amount $amount);

	/**
	 * Returns total amount
	 * @return Amount
	 */
	public function getAmount();

	/**
	 * Issue a full refund
	 * @return bool
	 */
	public function refund();

	/**
	 * Add a payment or refund
	 *
	 * @param PaymentInterface $payment Payment
	 * @return self
	 */
	public function addPayment(PaymentInterface $payment);

	/**
	 * Returns a list of all payments and refunds
	 * @return PaymentInterface
	 */
	public function getPayments();

	/**
	 * Prepare serializable array
	 * @return array
	 */
	public function toArray();
}
