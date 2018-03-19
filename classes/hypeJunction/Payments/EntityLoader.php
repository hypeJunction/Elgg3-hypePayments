<?php

namespace hypeJunction\Payments;

use Elgg\Database\Select;

trait EntityLoader {

	/**
	 * Load an entity from guid
	 *
	 * @param int $guid GUID
	 * @return bool
	 */
	public function loadFromGuid($guid) {

		$guid = (int) $guid;
		if (!$guid) {
			return false;
		}

		$rows = elgg_get_entities([
			'guids' => $guid,
			'limit' => 1,
			'callback' => false,
		]);

		if ($rows) {
			$this->load($rows[0]);
			return true;
		}

		return false;
	}
}