<?php

namespace hypeJunction\Payments;

class Payment implements PaymentInterface {

	protected $amount;
	protected $payment_method;
	protected $reason;
	protected $time_created;

	public function getAmount() {
		return $this->amount;
	}

	public function getPaymentMethod() {
		return $this->payment_method;
	}

	public function getDescription() {
		return $this->reason;
	}

	public function getTimeCreated() {
		return $this->time_created;
	}

	public function setAmount(Amount $amount) {
		$this->amount = $amount;
		return $this;
	}

	public function setPaymentMethod($payment_method) {
		$this->payment_method = $payment_method;
		return $this;
	}

	public function setDescription($reason) {
		$this->reason = $reason;
		return $this;
	}

	public function setTimeCreated($time) {
		$this->time_created = $time;
		return $this;
	}

	public function serialize() {
		return serialize(get_object_vars($this));
	}

	public function unserialize($serialized) {
		$data = unserialize($serialized);
		foreach ($data as $key => $value) {
			$this->$key = $value;
		}
	}

}
