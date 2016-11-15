<?php

namespace hypeJunction\Payments;

interface StorableInterface {

	/**
	 * Restore from storage
	 * @return StorableInterface
	 */
	public function restore();

	/**
	 * Save to storage
	 * @return StorableInterface
	 */
	public function save();

	/**
	 * Clear all items
	 * @return StorableInterface
	 */
	public function clear();
}
