<?php

namespace hypeJunction\Payments;


use Elgg\EventsService;
use Money\Currency;

class PaymentsService {



	/**
	 * @var PluginHooksService
	 */
	protected $events;

	/**
	 * @var GatewayInterface[]
	 */
	protected $gateways;

	/**
	 * Constructor
	 *
	 * @param EventsService $events Hooks
	 */
	public function __construct(EventsService $events) {
		$this->events = $events;
	}

	public static function name(): string {
		return 'payments';
	}

	public static function instance(): static {
		return elgg()->get(static::name());
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

		$supported_currencies = $this->events->triggerResults(
			'currencies',
			'payments',
			[],
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

	/**
	 * Get payment sources for the user
	 *
	 * @param \ElggUser $user User
	 *
	 * @return PaymentSource[]
	 */
	public function getSources(\ElggUser $user = null) {
		if (!isset($user)) {
			$user = elgg_get_logged_in_user_entity();
		}

		return $this->events->triggerResults(
			'payments:sources',
			'user',
			['entity' => $user],
			[]
		);
	}
}
