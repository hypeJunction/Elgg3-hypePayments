<?php

namespace hypeJunction\Payments;

use ElggMenuItem;

class Menus {

	/**
	 * Returns transaction menu items
	 *
	 * @param Transaction $transaction Transaction
	 *
	 * @return ElggMenuItem[]
	 */
	public static function getTransactionMenuItems(Transaction $transaction) {

		$items = [];

		$status = $transaction->getStatus();

		if ($status == TransactionInterface::STATUS_PAID && $transaction->canEdit()) {
			$items[] = ElggMenuItem::factory([
				'name' => 'refund',
				'text' => elgg_echo('payments:refund'),
				'href' => elgg_generate_action_url('transactions/refund', [
					'guid' => $transaction->guid,
				]),
				'confirm' => elgg_echo('payments:refund:confirm'),
			]);
		}

		if ($transaction->canEdit()) {
			$items[] = ElggMenuItem::factory([
				'name' => 'log_payment',
				'text' => elgg_echo('payments:transaction:log_payment'),
				'href' => elgg_generate_entity_url($transaction, 'view', null, [
					'filter' => 'log_payment',
				]),
			]);
		}

		return $items;
	}

}
