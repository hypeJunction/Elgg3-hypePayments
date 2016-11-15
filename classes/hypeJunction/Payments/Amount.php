<?php

namespace hypeJunction\Payments;

use SebastianBergmann\Money\Currency;
use SebastianBergmann\Money\Money;

class Amount implements \Serializable {

	const DEFAULT_CURRENCY = 'EUR';
	
	/**
	 * @var int
	 */
	protected $amount;

	/**
	 * @var string
	 */
	protected $currency;

	/**
	 * Constructor
	 * 
	 * @param int    $amount   Monetary value, i.e. 1000 for 10.00 EUR
	 * @param string $currency Currency code
	 */
	public function __construct($amount, $currency) {
		if (!is_int($amount)) {
			throw new \InvalidArgumentException(__METHOD__ . ' expects a monetary value as integer');
		}
		$this->amount = $amount;
		$this->currency = $currency;
	}

	/**
	 * Returns converted amount, e.g. 10.00 for 1000
	 * @return string
	 */
	public function getConvertedAmount() {
		$money = new Money($this->getAmount(), new Currency($this->getCurrency()));
		return $money->getConvertedAmount();
	}

	/**
	 * Returns amount
	 * @return int
	 */
	public function getAmount() {
		return $this->amount;
	}

	/**
	 * Returns currency
	 * @return string
	 */
	public function getCurrency() {
		return $this->currency ? : self::DEFAULT_CURRENCY;
	}

	/**
	 * Construct from string
	 *
	 * @param string $value    Converted amount as string, e.g. 10.00
	 * @param string $currency Currency code
	 * @return \self
	 */
	public static function fromString($value, $currency) {
		$money = Money::fromString($value, $currency);
		return new Amount($money->getAmount(), $money->getCurrency()->getCurrencyCode());
	}

	/**
	 * Outputs human readable formatted price
	 * @return string
	 */
	public function format() {
		return elgg_echo('payments:price', [$this->getConvertedAmount(), $this->getCurrency()]);
	}

	/**
	 * Extracts percentage and subtotal
	 * [
	 *    'subtotal' => Amount,
	 *    'percentage' => Amount
	 * ]
	 * @param float $percentage Percentage to extract
	 * @return Amount[]
	 */
	public function extractPercentage($percentage) {
		$extract = (new Money($this->getAmount(), $this->getCurrency()))->extractPercentage($percentage);
		return [
			'subtotal' => new Amount($extract['subtotal']->getAmount(), $this->getCurrency()),
			'percentage' => new Amount($extract['percentage']->getAmount(), $this->getCurrency()),
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function serialize() {
		return serialize([
			'_amount' => $this->getAmount(),
			'_currency' => $this->getCurrency(),
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function unserialize($serialized) {
		$data = unserialize($serialized);

		$this->amount = $data['_amount'];
		$this->currency = $data['_currency'];
	}

}
