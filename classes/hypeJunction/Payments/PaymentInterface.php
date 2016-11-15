<?php

namespace hypeJunction\Payments;

interface PaymentInterface extends \Serializable {

	/**
	 * Set payment amount
	 *
	 * @param \hypeJunction\Payments\Amount $amount
	 * @return self
	 */
	public function setAmount(Amount $amount);

	/**
	 * Returns payments amount
	 * @return Amount
	 */
	public function getAmount();

	/**
	 * Set payment reason
	 *
	 * @param string $reason Reason
	 * @return self
	 */
	public function setDescription($reason);

	/**
	 * Returns payment reason
	 * @return string
	 */
	public function getDescription();

	/**
	 * Sets the payment date
	 *
	 * @param int $time Timestamp
	 * @return self
	 */
	public function setTimeCreated($time);

	/**
	 * Returns the payment date
	 * @return int
	 */
	public function getTimeCreated();

	/**
	 * Sets the payment method
	 *
	 * @param string $payment_method Payment method
	 * @return self
	 */
	public function setPaymentMethod($payment_method);
	
	/**
	 * Returns the payment method
	 * @return string
	 */
	public function getPaymentMethod();
}
