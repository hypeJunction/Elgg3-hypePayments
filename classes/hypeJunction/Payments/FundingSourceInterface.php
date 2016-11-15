<?php

namespace hypeJunction\Payments;

use Serializable;

interface FundingSourceInterface extends Serializable {
	
	/**
	 * Return human readable label
	 */
	public function format();
}
