<?php

namespace hypeJunction\Payments;

use Serializable;

interface MerchantInterface extends Serializable {

	/**
	 * Returns Merchant id
	 * @return string
	 */
	public function getId();

	/**
	 * Returns title
	 * @return string
	 */
	public function getTitle();

	/**
	 * Returns description
	 * @return string
	 */
	public function getDescription();

	/**
	 * Export
	 * @return array
	 */
	public function toArray();
}
