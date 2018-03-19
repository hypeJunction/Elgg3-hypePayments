<?php

namespace hypeJunction\Payments;

class OrderItem implements OrderItemInterface {

	/**
	 * @var ProductInterface
	 */
	protected $product;

	/**
	 * @var int
	 */
	protected $quantity;

	/**
	 * @var array
	 */
	protected $props;

	/**
	 * @var ChargeInterface[]
	 */
	protected $charges;

	/**
	 * @var Amount
	 */
	protected $price;

	/**
	 * {@inheritdoc}
	 */
	public function __construct(ProductInterface $product, $quantity = 1) {
		$this->setProduct($product);
		$this->setQuantity($quantity);
	}

	/**
	 * {@inheritdoc}
	 */
	public function setProduct(ProductInterface $product) {
		$this->product = $product;
		$this->id = $this->product->getId();
		$this->title = $this->product->getTitle();
		$this->description = $this->product->getDescription();
		$this->price = $this->product->getTotalPrice();
		$this->setCharges($this->product->getCharges());
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getProduct() {
		return $this->product;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setQuantity($quantity = 0) {
		$this->quantity = $quantity;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getQuantity() {
		return $this->quantity;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getPrice() {
		return $this->price;
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
		if (empty($this->charges)) {
			return $total;
		}
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
		return new Amount($this->charges(), $this->price->getCurrency());
	}

	/**
	 * {@inheritdoc}
	 */
	public function subtotal() {
		return $this->getPrice()->getAmount() * $this->getQuantity();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSubtotalAmount() {
		return new Amount($this->subtotal(), $this->price->getCurrency());
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
		return new Amount($this->total(), $this->price->getCurrency());
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
	public function serialize() {
		return serialize($this->toArray());
	}

	/**
	 * {@inheritdoc}
	 */
	public function unserialize($serialized) {
		$data = unserialize($serialized);

		if ($data['_product'] instanceof ProductInterface) {
			$this->setProduct($data['_product']);
		}

		$this->setQuantity($data['_quantity']);
		$this->props = $data['_props'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function toArray() {
		
		$currency = $this->getPrice()->getCurrency();
		$subtotal = $this->subtotal();

		foreach ($this->charges as $charge) {
			$charge->setBaseAmount($this->getSubtotalAmount());
		}

		return [
			'_product' => $this->getProduct(),
			'_quantity' => $this->getQuantity(),
			'_price' => $this->getPrice(),
			'_subtotal' => $subtotal,
			'_total' => $this->total(),
			'_charges' => $this->getCharges(),
			'_props' => $this->props,
		];
	}

}
