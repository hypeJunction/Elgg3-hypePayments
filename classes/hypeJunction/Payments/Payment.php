<?php

namespace hypeJunction\Payments;

class Payment implements PaymentInterface {

	/** @var mixed */
    protected $amount;
	/** @var mixed */
    protected $payment_method;
	/** @var mixed */
    protected $reason;
	/** @var mixed */
    protected $time_created;

	/**
     * @return mixed
     */
    public function getAmount() {
		if (!$this->amount) {
			return new Amount(0, 'EUR');
		}
		return $this->amount;
	}

	/**
     * @return mixed
     */
    public function getPaymentMethod() {
		return $this->payment_method;
	}

	/**
     * @return mixed
     */
    public function getDescription() {
		return $this->reason;
	}

	/**
     * @return mixed
     */
    public function getTimeCreated() {
		return $this->time_created;
	}

	/**
     * @param Amount $amount
     * @return mixed
     */
    public function setAmount(Amount $amount) {
		$this->amount = $amount;
		return $this;
	}

	/**
     * @param mixed $payment_method
     * @return mixed
     */
    public function setPaymentMethod($payment_method) {
		$this->payment_method = $payment_method;
		return $this;
	}

	/**
     * @param mixed $reason
     * @return mixed
     */
    public function setDescription($reason) {
		$this->reason = $reason;
		return $this;
	}

	/**
     * @param mixed $time
     * @return mixed
     */
    public function setTimeCreated($time) {
		$this->time_created = $time;
		return $this;
	}

	/**
     * @return mixed
     */
    public function serialize() {
		return serialize(get_object_vars($this));
	}

	/**
     * @param mixed $serialized
     */
    public function unserialize($serialized) {
		$data = unserialize($serialized);
		foreach ($data as $key => $value) {
			$this->$key = $value;
		}
	}

}
