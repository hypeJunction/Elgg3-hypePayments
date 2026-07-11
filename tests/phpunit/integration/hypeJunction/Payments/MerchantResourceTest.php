<?php

namespace hypeJunction\Payments;

use Elgg\IntegrationTestCase;
use Elgg\Request;
use Elgg\Http\Request as HttpRequest;

/**
 * The `collection:object:transaction:merchant` route (/payments/merchant/{guid})
 * renders through resources/payments/merchant.php.
 *
 * That resource view was never created during the port, so the route 404'd via
 * ResourceNotFoundException (bd elgg-migrate-ckn0c). resources/payments/history.php
 * (the customer route) builds its collection from $request->getRoute() and is thus
 * route-agnostic, so merchant delegates straight to it. These tests lock in that the
 * view exists and that merchant is a faithful delegation — identical behaviour to
 * history for an identical request.
 *
 * Note: both resources depend on the `collections` service (hypeJunction\Lists); where
 * that is unavailable both raise the SAME error, which still proves the delegation.
 * Wiring that service is separate, plugin-wide migration work, not part of this fix.
 */
class MerchantResourceTest extends IntegrationTestCase {

	public function getPluginID(): string {
		return 'hypepayments';
	}

	public function up(): void {}

	public function down(): void {}

	private function buildRequest(string $route, int $guid): Request {
		$request = new Request(elgg(), HttpRequest::create(elgg_normalize_url('/payments')));
		$request->setParam('guid', (string) $guid);
		$request->setParam('_route', $route);
		return $request;
	}

	/** @return array{string,string} outcome tag and payload (output, or exception class) */
	private function renderOutcome(string $resource, Request $request): array {
		try {
			return ['ok', elgg_view_resource($resource, ['request' => $request])];
		} catch (\Throwable $e) {
			return ['throw', get_class($e)];
		}
	}

	public function testMerchantResourceViewExists(): void {
		// The direct cause of the 404 — the missing resource view — is gone.
		$this->assertTrue(elgg_view_exists('resources/payments/merchant'));
	}

	public function testMerchantDelegatesToHistory(): void {
		$user = $this->createUser();
		_elgg_services()->session_manager->setLoggedInUser($user);

		$merchant = $this->renderOutcome(
			'payments/merchant',
			$this->buildRequest('collection:object:transaction:merchant', $user->guid)
		);
		$history = $this->renderOutcome(
			'payments/history',
			$this->buildRequest('collection:object:transaction:customer', $user->guid)
		);

		_elgg_services()->session_manager->removeLoggedInUser();

		// Merchant must behave exactly like the route-agnostic history dispatcher:
		// same outcome kind (rendered vs threw) and same payload.
		$this->assertSame($history[0], $merchant[0], 'merchant and history diverged in outcome kind');
		$this->assertSame($history[1], $merchant[1], 'merchant did not delegate faithfully to history');
	}
}
