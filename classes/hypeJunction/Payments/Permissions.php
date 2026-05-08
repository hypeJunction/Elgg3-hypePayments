<?php

namespace hypeJunction\Payments;

use Elgg\Event;

class Permissions {

	public static function canEdit(Event $event) {

		$entity = $event->getEntityParam();
		if (!$entity instanceof Transaction) {
			return;
		}

		$merchant = $entity->getMerchant();
		if ($merchant && $merchant->canEdit()) {
			return true;
		}

		return false;
	}

	public static function canDelete(Event $event) {

		$entity = $event->getEntityParam();

		if (!$entity instanceof Transaction) {
			return;
		}

		return false;
	}
}
