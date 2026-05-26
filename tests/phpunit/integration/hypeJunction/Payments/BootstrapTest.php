<?php

namespace hypeJunction\Payments;

use Elgg\IntegrationTestCase;

class BootstrapTest extends IntegrationTestCase {

	public function getPluginID(): string {
		return 'hypepayments';
	}

	public function up(): void {}

	public function down(): void {}

	public function testPluginIsActive(): void {
		$plugin = \elgg_get_plugin_from_id('hypepayments');
		$this->assertInstanceOf(\ElggPlugin::class, $plugin);
		$this->assertTrue($plugin->isActive());
	}

	public function testPaymentsServiceIsAccessible(): void {
		$this->assertInstanceOf(PaymentsService::class, elgg()->get('payments'));
	}

	public function testPaymentsServiceInstanceReturnsService(): void {
		$this->assertInstanceOf(PaymentsService::class, PaymentsService::instance());
	}

	public function testPermissionsCheckEventHandlerExists(): void {
		$this->assertTrue(\_elgg_services()->events->hasHandler('permissions_check', 'object'));
	}

	public function testPermissionsCheckDeleteEventHandlerExists(): void {
		$this->assertTrue(\_elgg_services()->events->hasHandler('permissions_check:delete', 'object'));
	}

	public function testPageMenuEventHandlerExists(): void {
		$this->assertTrue(\_elgg_services()->events->hasHandler('register', 'menu:page'));
	}

	public function testGetCurrenciesReturnsArray(): void {
		$svc = PaymentsService::instance();
		$currencies = $svc->getCurrencies();
		$this->assertIsArray($currencies);
		$this->assertNotEmpty($currencies);
	}

	public function testTransactionActionIsRegistered(): void {
		$actions = \_elgg_services()->actions->getAllActions();
		$this->assertArrayHasKey('transactions/refund', $actions);
		$this->assertArrayHasKey('transactions/log_payment', $actions);
	}

	public function testRoutePaymentsHistoryIsRegistered(): void {
		$url = \elgg_generate_url('collection:object:transaction:customer', ['guid' => 1]);
		$this->assertNotEmpty($url);
	}
}
