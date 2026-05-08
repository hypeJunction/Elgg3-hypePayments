<?php

namespace hypeJunction\Payments;

use Elgg\Event;

class PageMenu {

	public function __invoke(Event $event) {

		$menu = $event->getValue();

		$menu->add(\ElggMenuItem::factory([
			'name' => 'payments:history',
			'href' => elgg_generate_url('collection:object:transaction:customer', [
				'guid' => elgg_get_logged_in_user_guid(),
			]),
			'text' => elgg_echo('payments:history'),
			'context' => ['settings', 'payments'],
			'section' => 'payments',
		]));

		$menu->add(\ElggMenuItem::factory([
			'name' => 'payments',
			'href' => '#',
			'text' => elgg_echo('payments'),
			'context' => ['admin'],
			'section' => 'configure',
		]));

		$menu->add(\ElggMenuItem::factory([
			'name' => 'payments:settings',
			'parent_name' => 'payments',
			'href' => 'admin/plugin_settings/hypePayments',
			'text' => elgg_echo('settings'),
			'icon' => 'cog',
			'context' => ['admin'],
			'section' => 'configure',
		]));
	}
}
