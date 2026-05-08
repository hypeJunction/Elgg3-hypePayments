<?php

namespace hypeJunction\Payments;

use Elgg\DefaultPluginBootstrap;

class Bootstrap extends DefaultPluginBootstrap {

	public function load(): void {
		$autoloader = dirname(__DIR__, 3) . '/autoloader.php';
		if (file_exists($autoloader)) {
			require_once $autoloader;
		}
	}

	public function init(): void {
		elgg_register_event_handler('permissions_check', 'object', [Permissions::class, 'canEdit']);
		elgg_register_event_handler('permissions_check:delete', 'object', [Permissions::class, 'canDelete']);
	}
}
