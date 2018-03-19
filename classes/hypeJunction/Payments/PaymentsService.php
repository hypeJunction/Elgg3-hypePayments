<?php

namespace hypeJunction\Payments;

use Elgg\PluginHooksService;
use hypeJunction\PayPal\API\Adapter;
use Money\Currency;

class PaymentsService {

	/**
	 * @var PluginHooksService
	 */
	protected $hooks;

	/**
	 * @var GatewayInterface[]
	 */
	protected $gateways;

	/**
	 * Constructor
	 *
	 * @param PluginHooksService $hooks Hooks
	 */
	public function __construct(PluginHooksService $hooks) {
		$this->hooks = $hooks;
	}

	/**
	 * Returns supported currencies
	 * @return Currency[]
	 */
	public function getCurrencies() {

		$currencies = [];
		$default_supported_currencies = [
			'USD',
			'EUR',
			'JPY',
			'GBP',
			'CHF',
			'CAD',
			'AUD',
			'ZAR',
		];

		$supported_currencies = $this->hooks->trigger(
			'currencies',
			'payments',
			null,
			$default_supported_currencies
		);

		foreach ($supported_currencies as $currency) {
			try {
				$currencies[] = new Currency($currency);
			} catch (\Exception $ex) {
				elgg_log("Unknown currency code '$currency'", 'ERROR');
			}
		}

		return $currencies;
	}

	/**
	 * Register a payment gateway
	 *
	 * @param GatewayInterface $gateway Gateway
	 *
	 * @return void
	 */
	public function registerGateway(GatewayInterface $gateway) {
		$this->gateways[$gateway->id()] = $gateway;
	}

	/**
	 * Get a gateway by its ID
	 *
	 * @param string $id ID
	 *
	 * @return GatewayInterface|null
	 */
	public function getGateway($id) {
		return elgg_extract($id, $this->gateways);
	}

	/**
	 * Get registered gateways
	 * @return GatewayInterface[]
	 */
	public function getGateways() {
		return array_values($this->gateways);
	}
}
