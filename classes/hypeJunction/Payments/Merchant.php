<?php

namespace hypeJunction\Payments;

use ElggObject;

abstract class Merchant extends ElggObject implements MerchantInterface {

	use SerializedMetadata;
	use EntityLoader;

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
	public function serialize() {
		return serialize($this->toArray());
	}

	/**
	 * {@inheritdoc}
	 */
	public function unserialize($serialized) {
		$data = unserialize($serialized);

		$this->initializeAttributes();
		if (!$this->loadFromGuid($data['_id'])) {
			$this->title = $data['_title'];
			$this->description = $data['_description'];
		}

	}

	/**
	 * {@inheritdoc}
	 */
	public function toArray() {
		$export = (array) $this->toObject();
		$export['_id'] = $this->getId();
		$export['_title'] = $this->getDisplayName();
		$export['_description'] = $this->getDescription();
		return $export;
	}

}
