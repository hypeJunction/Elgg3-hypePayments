<?php

$name = elgg_extract('name', $vars);
$value = elgg_extract('value', $vars);

unset($vars['name'], $vars['value']);

if (is_array($value)) {
	$amount = elgg_extract('amount', $value, '0');
	$currency = elgg_extract('currency', $value);

	$amount = \hypeJunction\Payments\Amount::fromString($amount, $currency);
} else if ($value instanceof \hypeJunction\Payments\Amount) {
	$amount = $value;
} else {
	$amount = new \hypeJunction\Payments\Amount(0);
}

$input = elgg_view('input/text', [
	'name' => "{$name}[amount]",
	'value' => $amount->getConvertedAmount(),
	'data-part' => 'amount',
]);

$input .= elgg_view('input/payments/currency', [
	'name' => "{$name}[currency]",
	'value' => $amount->getCurrency(),
	'data-part' => 'currency',
	'no_js' => true,
]);

$vars['class'] = elgg_extract_class($vars, 'elgg-input-payments-amount');

echo elgg_format_element('div', $vars, $input);