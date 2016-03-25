<?php

namespace hypeJunction\Payments;

use ElggEntity;
use ElggFile;
use SebastianBergmann\Money\Currency;
use SebastianBergmann\Money\Money;

/**
 * @property string $transaction_id   Unique ID of the transaction
 * @property string $payment_method   Payment method used for the transaction
 * @property string $status           Current payment status of the transaction
 */
class Transaction extends ElggFile implements TransactionInterface {

	const CLASSNAME = __CLASS__;
	const SUBTYPE = 'transaction';

	/**
	 * {@inheritdoc}
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		$this->attributes['subtype'] = self::SUBTYPE;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function factory(ElggEntity $customer, ElggEntity $merchant, $price_amount, $currency, array $data = []) {

		$ia = elgg_set_ignore_access(true);

		$site = elgg_get_site_entity();
		$transaction_id = sha1(time() . rand(10000, 99999) . json_encode($data));

		$transaction = new Transaction();
		$transaction->owner_guid = $site->guid;
		$transaction->container_guid = $site->guid;
		$transaction->setFilename("transactions/$transaction_id.json");
		$transaction->setMimeType('application/json');

		$transaction->open('write');
		$transaction->write(json_encode($data));
		$transaction->close();

		$transaction->transaction_id = $transaction_id;
		$transaction->access_id = ACCESS_PRIVATE;

		$guid = $transaction->save();

		if ($guid) {
			$transaction->setCustomer($customer);
			$transaction->setMerchant($merchant);
			$money = new Money($price_amount, new Currency($currency));
			$transaction->setAmount($money->getAmount());
			$transaction->setCurrency($money->getCurrency()->getCurrencyCode());
			$transaction->save();
		}

		elgg_set_ignore_access($ia);

		return $transaction;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function getFromId($transaction_id) {

		if (empty($transaction_id)) {
			return false;
		}

		$transactions = elgg_get_entities_from_metadata([
			'types' => 'object',
			'subtypes' => self::SUBTYPE,
			'metadata_name_value_pairs' => [
				'name' => 'transaction_id',
				'value' => $transaction_id,
			],
			'limit' => 1,
		]);

		return $transactions ? $transactions[0] : false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setStatus($status, array $params = []) {
		$this->status = $status;
		$params['entity'] = $this;
		return elgg_trigger_plugin_hook("transaction:$status", 'payments', $params, true);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDetails($name = null) {
		if (!isset($this->attributes['contents'])) {
			$this->open('read');
			$json = $this->grabFile();
			$this->close();
			$this->attributes['contents'] = json_decode($json, true);
		}

		if (!$name) {
			return $this->attributes['contents'];
		}

		return elgg_extract($name, $this->attributes['contents']);
	}

	/**
	 * {@inheritdoc}
	 */
	public function setDetails($name, $value = null) {
		$details = $this->getDetails();
		$details[$name] = $value;
		$this->open('write');
		$this->write(json_encode($details));
		$this->close();
		$this->attributes['contents'] = $details;
	}

	/**
	 * {@inheritdoc}
	 */
	public function save() {
		if (!isset($this->status)) {
			$this->status = self::STATUS_NEW;
		}
		return parent::save();
	}

	/**
	 * {@inheritdoc}
	 */
	public function setCustomer(ElggEntity $customer) {
		add_entity_relationship($customer->guid, 'customer', $this->guid);
		add_entity_relationship($this->guid, 'access_grant', $customer->guid);
		$customer_export = (array) $customer->toObject();
		$customer_export['_id'] = $customer->guid;
		$this->setDetails('_customer', $customer_export);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCustomer() {
		$customer = $this->getDetails('_customer');
		return get_entity(elgg_extract('_id', $customer));
	}

	/**
	 * {@inheritdoc}
	 */
	public function setMerchant(ElggEntity $merchant) {
		add_entity_relationship($merchant->guid, 'merchant', $this->guid);
		add_entity_relationship($this->guid, 'access_grant', $merchant->guid);
		$merchant_export = (array) $merchant->toObject();
		$merchant_export['_id'] = $merchant->guid;
		$this->setDetails('_merchant', $merchant_export);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getMerchant() {
		$merchant = $this->getDetails('_merchant');
		return get_entity(elgg_extract('_id', $merchant));
	}

	/**
	 * {@inheritdoc}
	 */
	public function setAmount($amount) {
		$this->amount = $amount;
		$this->setDetails('_total', $amount);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAmount() {
		return $this->getDetails('_total');
	}

	/**
	 * {@inheritdoc}
	 */
	public function setCurrency($currency) {
		$this->currency = $currency;
		$this->setDetails('_currency', $currency);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCurrency() {
		return $this->getDetails('_currency');
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCommissionRate(GatewayInterface $interface) {
		$merchant = $this->getMerchant();
		if (!$merchant || $merchant->guid == elgg_get_site_entity()->guid) {
			return 0;
		}

		$params = [
			'entity' => $this,
			'gateway' => $interface,
		];

		return elgg_trigger_plugin_hook('site_commission', 'payments', $params, 0);
	}

}
