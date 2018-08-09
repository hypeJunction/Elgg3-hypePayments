<?php

namespace hypeJunction\Payments;

use InvalidArgumentException;
use Money\Currencies\ISOCurrencies;
use \Money\Currency;
use Money\Formatter\DecimalMoneyFormatter;
use \Money\Money;
use Money\Parser\DecimalMoneyParser;

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
	public function __construct($amount, $currency = null) {
		if (!is_int($amount)) {
			throw new InvalidArgumentException(__METHOD__ . ' expects a monetary value as integer');
		}
		$this->amount = $amount;
		$this->currency = $currency ? strtoupper($currency) : null;
	}

	/**
	 * Returns converted amount, e.g. 10.00 for 1000
	 * @return string
	 */
	public function getConvertedAmount() {
		$money = new Money($this->getAmount(), new Currency($this->getCurrency()));

		$currencies = new ISOCurrencies();
		$formatter = new DecimalMoneyFormatter($currencies);

		return $formatter->format($money);
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
		$currencies = new ISOCurrencies();
		$moneyParser = new DecimalMoneyParser($currencies);
		$money = $moneyParser->parse($value, $currency);

		return new Amount((int) $money->getAmount(), $money->getCurrency()->getCode());
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
		$extract = (new Money($this->getAmount(), new Currency($this->getCurrency())))
			->allocate([$percentage, 100 - $percentage]);

		return [
			'subtotal' => new Amount((int) $extract[1]->getAmount(), $this->getCurrency()),
			'percentage' => new Amount((int) $extract[0]->getAmount(), $this->getCurrency()),
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
