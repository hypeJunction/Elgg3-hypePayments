<?php

use hypeJunction\Payments\CreditCard;

$credit_card = elgg_extract('credit_card', $vars);
if (!$credit_card instanceof CreditCard) {
	return;
}

$brand = strtolower($credit_card->brand ?: '');
$icon = '';
if (elgg_view_exists("payments/icons/$brand.png")) {
	$icon = elgg_view('output/img', [
		'src' => elgg_get_simplecache_url("payments/icons/$brand.png"),
	]);
}

$num = implode('-', array_filter([$icon, $credit_card->last4]));
$exp = '';
//$exp = implode('-', array_filter([$credit_card->exp_month, $credit_card->exp_year]));

$view = implode(' ', array_filter([$num, $exp]));

echo elgg_format_element('div', [
	'class' => 'payments-credit-card',
		], $view);
