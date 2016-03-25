<?php

namespace hypeJunction\Payments;

use SebastianBergmann\Money\Currency;
use SebastianBergmann\Money\Money;

class Price {

	/**
	 * Format price
	 *
	 * @param int    $price
	 * @param string $currency
	 * @return string
	 */
	public static function format($price, $currency) {
		$money = new Money((int) $price, new Currency((string) $currency));
		$price = $money->getConvertedAmount();
		$currency = $money->getCurrency()->getCurrencyCode();
		return elgg_echo('payments:price', [$price, $currency]);
	}

}
