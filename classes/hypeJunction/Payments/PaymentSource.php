<?php

namespace hypeJunction\Payments;

/**
 * Represents a payment source, i.e. a card stored with one of the gateways
 */
class PaymentSource {

	/**
	 * @var GatewayInterface
	 */
	protected $gateway;
	/**
	 * @var string
	 */
	protected $id;
	/**
	 * @var array
	 */
	protected $options;

	/**
	 * PaymentSource constructor.
	 *
	 * @param GatewayInterface $gateway Payment gateway
	 * @param string           $id      Source ID
	 * @param array            $options Source details
	 */
	public function __construct(GatewayInterface $gateway, $id, array $options = []) {
		$this->gateway = $gateway;
		$this->id = $id;
		$this->options = $options;
	}

	/**
	 * Get gateway
	 * @return GatewayInterface
	 */
	public function getGateway() {
		return $this->gateway;
	}

	/**
	 * Get ID
	 * @return string
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Get details
	 * @return array
	 */
	public function getOptions() {
		return $this->options;
	}

	/**
	 * Get the label of the source
	 * @return string|null
	 */
	public function getLabel() {
		return elgg_extract('label', $this->options, $this->id);
	}

	/**
	 * Get URL of the source icon
	 * @return string|null
	 */
	public function getIconURL() {
		return elgg_extract('icon', $this->options);
	}
}