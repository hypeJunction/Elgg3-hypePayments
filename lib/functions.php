<?php

use SebastianBergmann\Money\Currency;

/**
 * Returns supported currencies
 * @return Currency[]
 */
function payments_get_currencies() {
	$currencies = array();
	$default_supported_currencies = array('USD', 'EUR', 'JPY', 'GBP', 'CHF', 'CAD', 'AUD', 'ZAR');
	$supported_currencies = elgg_trigger_plugin_hook('currencies', 'payments', null, $default_supported_currencies);
	foreach ($supported_currencies as $currency) {
		try {
			$currencies[] = new Currency($currency);
		} catch (Exception $ex) {
			elgg_log("Unknown currency code '$currency'", 'ERROR');
		}
	}

	return $currencies;
}
