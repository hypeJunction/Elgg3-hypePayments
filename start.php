<?php

/**
 * Payments
 *
 * @author    Ismayil Khayredinov <info@hypejunction.com>
 * @copyright Copyright (c) 2015-2018, Ismayil Khayredinov
 */

use hypeJunction\Payments\Permissions;

require_once __DIR__ . '/autoloader.php';

return function () {
	elgg_register_event_handler('init', 'system', function () {

		elgg_register_plugin_hook_handler('permissions_check', 'object', [Permissions::class, 'canEdit']);
		elgg_register_plugin_hook_handler('permissions_check:delete', 'object', [Permissions::class, 'canDelete']);

		elgg_extend_view('elements/components.css', 'payments/stylesheet.css');
		elgg_extend_view('admin.css', 'payments/stylesheet.css');
		elgg_extend_view('elements/forms.css', 'input/payments/method.css');

		elgg_register_collection('collection:object:transaction:customer', \hypeJunction\Payments\CustomerTransactionCollection::class);

		elgg_register_plugin_hook_handler('register', 'menu:page', \hypeJunction\Payments\PageMenu::class);
	});
};
