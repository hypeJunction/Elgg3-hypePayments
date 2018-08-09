<?php

/**
 * Display a dropdown of currencies
 */
$vars['name'] = elgg_extract('name', $vars, 'currency');
$vars['value'] = strtoupper((string) elgg_extract('value', $vars, ''));

$currencies = elgg()->payments->getCurrencies();
/* @var $currencies \Money\Currency[] */

if (count($currencies) == 1) {
	$vars['value'] = $currencies[0]->getCode();

	echo elgg_view('input/hidden', $vars);
	echo elgg_format_element('span', [
		'class' => 'currency-input-placeholder',
	], $currencies[0]->getCode());
} else {
	$vars['options_values'] = [];

	$icons = [
		'USD' => 'usd',
		'EUR' => 'eur',
		'JPY' => 'jpy',
		'GBP' => 'gbp',
	];

	foreach ($currencies as $currency) {
		$currencyCode = $currency->getCode();

		$vars['options_values'][] = [
			'text' => $currencyCode,
			'value' => $currencyCode,
			'data-icon-name' => elgg_extract($currencyCode, $icons),
		];
	}

	echo elgg_view('input/select', $vars);
}
