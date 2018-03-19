<?php

namespace hypeJunction\Payments;

class Permissions {
	
	/**
	 * Set transaction editing permissions
	 *
	 * @param string $hook   "permissions_check"
	 * @param string $type   "object"
	 * @param bool   $return Permission
	 * @param array  $params Hook params
	 * @return bool
	 */
	public static function canEdit($hook, $type, $return, $params) {

		$entity = elgg_extract('entity', $params);
		if (!$entity instanceof Transaction) {
			return;
		}

		$merchant = $entity->getMerchant();
		if ($merchant && $merchant->canEdit()) {
			// Only merchant editors can change the transaction
			return true;
		}

		return false;
	}

	/**
	 * Set transaction delete permissions
	 *
	 * @param string $hook   "permissions_check:delete"
	 * @param string $type   "object"
	 * @param bool   $return Permission
	 * @param array  $params Hook params
	 * @return bool
	 */
	public static function canDelete($hook, $type, $return, $params) {

		$entity = elgg_extract('entity', $params);

		if (!$entity instanceof Transaction) {
			return;
		}

		// Transactions should not be deleted
		return false;
	}
}
