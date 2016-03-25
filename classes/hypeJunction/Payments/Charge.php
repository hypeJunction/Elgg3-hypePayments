<?php

namespace hypeJunction\Payments;

use hypeJunction\Payments\ChargeInterface;

class Charge implements ChargeInterface {

	/**
	 * ID
	 * @var string
	 */
	private $id;

	/**
	 * Rate
	 * @var float
	 */
	private $rate;

	/**
	 * Flat fee
	 * @var int
	 */
	private $flat;

	/**
	 * {@inheritdoc}
	 */
	public function __construct($id = '', $rate = 0.00, $flat = 0) {
		$this->id = $id;
		$this->rate = $rate;
		$this->flat = $flat;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getFlat() {
		return $this->flat;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getRate() {
		return $this->rate;
	}

	/**
	 * {@inheritdoc}
	 */
	public function calculate($amount) {
		return (int) round(($amount * $this->rate / 100) + $this->flat);
	}

	/**
	 * {@inheritdoc}
	 */
	public function toArray() {
		return [
			'_id' => $this->getId(),
			'_rate' => $this->getRate(),
			'_flat' => $this->getFlat(),
		];
	}

}
