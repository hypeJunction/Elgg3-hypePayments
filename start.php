<?php

/**
 * Payments
 *
 * @author Ismayil Khayredinov <info@hypejunction.com>
 * @copyright Copyright (c) 2015-2016, Ismayil Khayredinov
 */
require_once __DIR__ . '/autoloader.php';

use hypeJunction\Payments\Permissions;
use hypeJunction\Payments\Router;

elgg_register_event_handler('init', 'system', function() {

	elgg_register_page_handler('payments', [Router::class, 'controller']);
	elgg_register_plugin_hook_handler('entity:url', 'object', [Router::class, 'urlHandler']);

	elgg_register_plugin_hook_handler('permissions_check', 'object', [Permissions::class, 'canEdit']);
	elgg_register_plugin_hook_handler('permissions_check:delete', 'object', [Permissions::class, 'canDelete']);

	elgg_register_action('transactions/refund', __DIR__ . '/actions/transactions/refund.php');
	elgg_register_action('transactions/log_payment', __DIR__ . '/actions/transactions/log_payment.php');
	
	elgg_extend_view('elgg.css', 'payments/stylesheet.css');

	elgg_register_menu_item('page', [
		'name' => 'payments:history',
		'href' => '/payments/history',
		'text' => elgg_echo('payments:history'),
		'context' => ['settings', 'payments'],
	]);
});

elgg_register_event_handler('upgrade', 'system', function() {
	if (!elgg_is_admin_logged_in()) {
		return;
	}
	require_once __DIR__ . '/lib/upgrades.php';
});

