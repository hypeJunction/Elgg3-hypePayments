<?php

namespace hypeJunction\Payments;

abstract class Charge implements ChargeInterface {

	/**
	 * @var string
	 */
	protected $id = '';

	/**
	 * @var float
	 */
	protected $rate = 0.00;

	/**
	 * @var Amount
	 */
	protected $flat;

	/**
	 * @var Amount
	 */
	protected $base;

	/**
	 * @var string
	 */
	protected $currency;

	/**
	 * {@inheritdoc}
	 */
	public function __construct($id = '', $rate = 0.00, Amount $flat = null) {
		$this->setId($id);
		$this->setRate($rate);
		$this->setFlatAmount($flat);
	}

	/**
	 * {@inheritdoc}
	 */
	public function setId($id = '') {
		$this->id = (string) $id;
		return $this;
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
	public function setFlatAmount(Amount $amount = null) {
		$this->flat = $amount;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getFlatAmount() {
		return $this->flat;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setRate($rate = 0.00) {
		$this->rate = (float) $rate;
		return $this;
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
	public function getTotalAmount() {
		if ($this->getBaseAmount()) {
			$total = $this->getBaseAmount()->getAmount() * $this->rate / 100;
			if ($this->getFlatAmount()) {
				$total += $this->getFlatAmount()->getAmount();
			}
			return new Amount((int) round($total), $this->getBaseAmount()->getCurrency());
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function setBaseAmount(Amount $amount = null) {
		$this->base = $amount;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBaseAmount() {
		return $this->base;
	}

	/**
	 * {@inheritdoc}
	 */
	public function serialize() {
		return serialize($this->toArray());
	}

	/**
	 * {@inheritdoc}
	 */
	public function unserialize($serialized) {
		$data = unserialize($serialized);
		return $this->setId($data['_id'])
						->setRate($data['_rate'])
						->setFlatAmount($data['_flat'])
						->setBaseAmount($data['_base']);
	}

	/**
	 * {@inheritdoc}
	 */
	public function toArray() {
		return [
			'_id' => $this->getId(),
			'_rate' => $this->getRate(),
			'_flat' => $this->getFlatAmount(),
			'_base' => $this->getBaseAmount(),
			'_total' => $this->getTotalAmount(),
		];
	}

}
