<?php

namespace hypeJunction\Payments;

use ElggObject;

/**
 * @property int    $price    Monetary value
 * @property string $currency Currency code
 * @property string $charges  Charges (serialized)
 */
abstract class Product extends ElggObject implements ProductInterface {

	/**
	 * {@inheritdoc}
	 */
	public function getId() {
		return $this->guid;
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
	public function getMerchant() {
		return $this->getContainerEntity();
	}

	/**
	 * {@inheritdoc}
	 */
	public function setPrice(Amount $price) {
		$this->price = $price->getAmount();
		$this->currency = $price->getCurrency();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getPrice() {
		return new Amount((int) $this->price, $this->currency);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getTotalPrice() {
		$charges = $this->getCharges();
		if (empty($charges)) {
			return $this->getPrice();
		}
		$total = $this->getPrice()->getAmount();
		foreach ($charges as $charge) {
			/* @var $charge ChargeInterface */
			$charge->setBaseAmount($this->getPrice());
			$total += $charge->getTotalAmount()->getAmount();
		}
		
		return new Amount($total, $this->currency);
	}

	/**
	 * Add stock
	 *
	 * @param int $quantity Items to add
	 * @return bool
	 */
	public function addStock($quantity = 1) {
		$id = create_annotation($this->guid, 'quantity', $quantity, '', 0, ACCESS_PUBLIC);
		return $id ? true : false;
	}

	/**
	 * Returns current stock
	 * @return int
	 */
	public function getStock() {
		return (int) elgg_get_annotations([
					'guids' => (int) $this->guid,
					'annotation_names' => 'quantity',
					'annotation_calculation' => 'sum',
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function inStock($quantity = 1) {
		return $quantity <= $this->getStock();
	}

	/**
	 * {@inheritdoc}
	 */
	public function setCharges($charges) {
		if (!is_array($charges)) {
			$charges = [$charges];
		}
		$charges = array_filter($charges, function($charge) {
			return $charge instanceof ChargeInterface;
		});
		$this->charges = serialize($charges);
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCharges() {
		if (!$this->charges) {
			return [];
		}
		return unserialize($this->charges);
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

		$this->initializeAttributes();
		if (!$data['_id'] || !$this->load($data['_id'])) {
			$this->title = $data['_title'];
			$this->description = $data['_description'];
			$this->setPrice($data['_price']);
			$this->setCharges($data['_charges']);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function toArray() {
		$export = (array) $this->toObject();
		$export['_id'] = $this->getId();
		$export['_merchant'] = $this->getMerchant();
		$export['_price'] = $this->getPrice();
		$export['_charges'] = $this->getCharges();
		$export['_title'] = $this->getDisplayName();
		$export['_description'] = $this->getDescription();
		return $export;
	}

}
