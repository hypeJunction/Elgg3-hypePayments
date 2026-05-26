<?php

namespace hypeJunction\Payments;

class CreditCard implements FundingSourceInterface {

	/** @var mixed */
    public $id;
	/** @var mixed */
    public $last4;
	/** @var mixed */
    public $brand;
	/** @var mixed */
    public $exp_month;
	/** @var mixed */
    public $exp_year;

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

	/**
     * @return mixed
     */
    public function format() {
		return \elgg_view('payments/credit_card', [
			'credit_card' => $this,
		]);
	}

}
