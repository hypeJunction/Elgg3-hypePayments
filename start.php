<?php

use hypeJunction\Payments\Transaction;
use SebastianBergmann\Money\Currency;

/**
 * Payments
 *
 * @author Ismayil Khayredinov <info@hypejunction.com>
 * @copyright Copyright (c) 2015, Ismayil Khayredinov
 */
require_once __DIR__ . '/autoloader.php';

elgg_register_event_handler('init', 'system', 'payments_init');

/**
 * Init
 * @return void
 */
function payments_init() {

	elgg_register_page_handler('payments', 'payments_page_handler');
	elgg_register_plugin_hook_handler('entity:url', 'object', 'payments_transaction_url');

	elgg_extend_view('css/elgg', 'object/transaction.css');

	elgg_register_menu_item('page', [
		'name' => 'payments:history',
		'href' => '/payments/history',
		'text' => elgg_echo('payments:history'),
		'context' => ['settings', 'payments'],
	]);
}

/**
 * Payments page handler
 *
 * @param array $segments URL segments
 * @return bool
 */
function payments_page_handler($segments) {

	$page = array_shift($segments);

	switch ($page) {

		case 'history' :
			echo elgg_view('resources/payments/history', [
				'guid' => isset($segments[0]) ? $segments[0] : elgg_get_logged_in_user_guid(),
			]);
			return true;

		case 'transaction' :
			echo elgg_view('resources/payments/transaction', [
				'id' => $segments[0],
			]);
			return true;
	}

	return false;
}

/**
 * Transaction URL handler
 *
 * @param string $hook   "entity:url"
 * @param string $type   "object"
 * @param string $return URL
 * @param array  $params Hook params
 * @return string
 */
function payments_transaction_url($hook, $type, $return, $params) {

	$entity = elgg_extract('entity', $params);

	if ($entity instanceof Transaction) {
		return elgg_normalize_url("/payments/transaction/$entity->transaction_id");
	}
}

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
