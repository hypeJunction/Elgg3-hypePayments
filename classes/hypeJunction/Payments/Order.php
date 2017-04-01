<?php

namespace hypeJunction\Payments;

use ElggEntity;
use ElggObject;
use ElggUser;

class Order implements OrderInterface {

	/**
	 * @var ElggEntity
	 */
	protected $customer;

	/**
	 * @var ElggEntity
	 */
	protected $merchant;

	/**
	 * @var OrderItem[]
	 */
	protected $items = [];

	/**
	 * @var ChargeInterface[]
	 */
	protected $charges = [];

	/**
	 * @var array
	 */
	protected $props;

	/**
	 * @var string
	 */
	protected $currency;

	/**
	 * @var Address
	 */
	protected $shipping_address;

	/**
	 * @var Address
	 */
	protected $billing_address;

	/**
	 * {@inheritdoc}
	 */
	public function add(ProductInterface $product, $quantity = 1) {
		$item = $this->find($product);
		if ($item) {
			$this->remove($product);
			$quantity += $item->getQuantity();
		}
		if ($quantity >= 1) {
			$item = new OrderItem($product, $quantity);
			$this->items[] = $item;
		}
		return $item;
	}

	/**
	 * {@inheritdoc}
	 */
	public function all() {
		return $this->items;
	}

	/**
	 * {@inheritdoc}
	 */
	public function find(ProductInterface $product) {
		foreach ($this->items as $item) {
			if ($product->getId() && $item->getProduct()->getId() === $product->getId()) {
				return $item;
			}
		}
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has(ProductInterface $product) {
		return $this->find($product);
	}

	/**
	 * {@inheritdoc}
	 */
	public function remove(ProductInterface $product) {
		$result = false;
		foreach ($this->items as $key => $item) {
			if ($item->getProduct()->getId() == $product->getId()) {
				unset($this->items[$key]);
				$result = true;
			}
		}
		return $result;
	}

	/**
	 * {@inheritdoc}
	 */
	public function update(ProductInterface $product, $quantity = 1) {
		$this->remove($product);
		return $this->add($product, $quantity);
	}

	/**
	 * {@inheritdoc}
	 */
	public function count() {
		$quantity = 0;
		foreach ($this->items as $item) {
			$quantity += $item->getQuantity();
		}
		return $quantity;
	}

	/**
	 * {@inheritdoc}
	 */
	public function countLines() {
		return count($this->items);
	}

	/**
	 * {@inheritdoc}
	 */
	public function clear() {
		$this->items = [];
	}

	/**
	 * {@inheritdoc}
	 */
	public function setShippingAddress(Address $address) {
		$this->shipping_address = $address;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getShippingAddress() {
		return $this->shipping_address;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setBillingAddress(Address $address) {
		$this->billing_address = $address;
		return $this;
	}

	public function getBillingAddress() {
		return $this->billing_address;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setCharges($charges) {
		if (!is_array($charges)) {
			$charges = [$charges];
		}
		$this->charges = [];
		foreach ($charges as $charge) {
			if ($charge instanceof ChargeInterface) {
				$this->charges[] = $charge;
			}
		}
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCharges() {
		return $this->charges;
	}

	/**
	 * {@inheritdoc}
	 */
	public function charges() {
		$total = 0;
		foreach ($this->charges as &$charge) {
			/* @var $charge ChargeInterface */
			$charge->setBaseAmount($this->getSubtotalAmount());
			$total += $charge->getTotalAmount()->getAmount();
		}

		return $total;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getChargesAmount() {
		return new Amount($this->charges(), $this->getCurrency());
	}

	/**
	 * {@inheritdoc}
	 */
	public function subtotal() {
		$total = 0;
		foreach ($this->all() as $item) {
			$total += $item->getProduct()->getPrice()->getAmount() * $item->getQuantity();
		}
		return $total;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSubtotalAmount() {
		return new Amount($this->subtotal(), $this->getCurrency());
	}

	/**
	 * {@inheritdoc}
	 */
	public function total() {
		return $this->subtotal() + $this->charges();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getTotalAmount() {
		return new Amount($this->total(), $this->getCurrency());
	}

	/**
	 * {@inheritdoc}
	 */
	public function __get($name) {
		return $this->get($name);
	}

	/**
	 * {@inheritdoc}
	 */
	public function __set($name, $value) {
		return $this->set($name, $value);
	}

	/**
	 * {@inheritdoc}
	 */
	public function get($key) {
		if (isset($this->props[$key])) {
			return $this->props[$key];
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function set($key, $value) {
		$this->props[$key] = $value;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setMerchant(ElggEntity $merchant) {
		$this->merchant = $merchant;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getMerchant() {
		return $this->merchant;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setCustomer(ElggEntity $customer) {
		$this->customer = $customer;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCustomer() {
		return $this->customer;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setCurrency($currency) {
		$this->currency = $currency;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCurrency() {
		if ($this->currency) {
			return $this->currency;
		}
		$item = array_shift($this->items);
		if ($item) {
			return $item->getProduct()->getPrice()->getCurrency();
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function serialize() {
		return serialize($this->toArray());
	}

	/**
	 * {@inheritdoc}
	 */
	public function unserialize($serialized) {
		$data = unserialize($serialized);

		if ($data['_merchant']) {
			$merchant = get_entity($data['_merchant']['_id']);
			if (!$merchant) {
				$merchant = new ElggObject();
				$merchant->email = $data['_merchant']['_email'];
				$merchant->title = $data['_merchant']['_title'];
				$merchant->description = $data['_merchant']['_description'];
			}
			$this->setMerchant($merchant);
		}

		if ($data['_customer']) {
			$customer = get_entity($data['_customer']['_id']);
			if (!$customer) {
				$customer = new ElggUser();
				$customer->email = $data['_customer']['_email'];
				$customer->name = $data['_customer']['_name'];
			}
			$this->setCustomer($customer);
		}

		$this->setCurrency($data['_currency']);

		$this->items = $data['_items'];
		$this->charges = $data['_charges'];
		$this->shipping_address = $data['_shipping_address'];
		$this->billing_address = $data['_billing_address'];
		$this->props = $data['_props'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function toArray() {

		$currency = $this->getCurrency();
		$subtotal = $this->subtotal();

		return $this->prepareExport([
					'_merchant' => $this->getMerchant(),
					'_customer' => $this->getCustomer(),
					'_currency' => $currency,
					'_items' => $this->all(),
					'_subtotal' => $subtotal,
					'_total' => $this->total(),
					'_charges' => $this->getCharges(),
					'_shipping_address' => $this->getShippingAddress(),
					'_billing_address' => $this->getBillingAddress(),
					'_props' => $this->props,
		]);
	}

	/**
	 * Export entities
	 *
	 * @param mixed $val Value to export
	 * @return mixed
	 */
	protected function prepareExport($val) {
		if (is_array($val)) {
			foreach ($val as &$elem) {
				$elem = $this->prepareExport($elem);
			}
		} else if ($val instanceof ElggObject) {
			$export = (array) $val->toObject();
			$export['_id'] = $val->guid;
			$export['_title'] = $val->title;
			$export['_description'] = $val->description;
			$val = $export;
		} else if ($val instanceof ElggEntity) {
			$export = (array) $val->toObject();
			$export['_id'] = $val->guid;
			$export['_email'] = $val->email;
			$export['_name'] = $val->name;
			$export['_description'] = $val->description;
			$val = $export;
		}

		return $val;
	}

}
