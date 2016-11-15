<?php

namespace hypeJunction\Payments;

class CreditCard implements FundingSourceInterface {

	public $id;
	public $last4;
	public $brand;
	public $exp_month;
	public $exp_year;

	public function serialize() {
		return serialize(get_object_vars($this));
	}

	public function unserialize($serialized) {
		$data = unserialize($serialized);
		foreach ($data as $key => $value) {
			$this->$key = $value;
		}
	}

	public function format() {
		return elgg_view('payments/credit_card', [
			'credit_card' => $this,
		]);
	}

}
