<?php

/**
 * Display a dropdown of currencies
 */
$vars['name'] = elgg_extract('name', $vars, 'currency');
$vars['value'] = strtoupper((string) elgg_extract('value', $vars, ''));

$currencies = payments_get_currencies();
if (count($currencies) == 1) {
	echo $currencies[0]->getDisplayName();
	if (!$vars['value']) {
		$vars['value'] = $currencies[0]->getCurrencyCode();
	}
	echo elgg_view('input/hidden', $vars);
} else {
	$vars['options_values'] = [];
	foreach ($currencies as $currency) {
		$currencyCode = $currency->getCurrencyCode();
		$currencyName = $currency->getDisplayName();

		$vars['options_values'][$currencyCode] = $currencyName;
	}
	echo elgg_view('input/dropdown', $vars);
}
