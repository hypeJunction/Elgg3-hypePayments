<?php

namespace hypeJunction\Payments;

use ElggMenuItem;

class Menus {

	/**
	 * Returns transaction menu items
	 * 
	 * @param Transaction $transaction Transaction
	 * @return ElggMenuItem[]
	 */
	public static function getTransactionMenuItems(Transaction $transaction) {

		$items = [];

		$status = $transaction->getStatus();

		if ($status == TransactionInterface::STATUS_PAID && $transaction->canEdit()) {
			$items[] = ElggMenuItem::factory([
						'name' => 'refund',
						'text' => elgg_echo('payments:refund'),
						'href' => "action/transactions/refund?guid=$transaction->guid",
						'is_action' => true,
						'confirm' => elgg_echo('payments:refund:confirm'),
			]);
		}

		if ($status !== TransactionInterface::STATUS_FAILED && $status !== TransactionInterface::STATUS_REFUNDED && $transaction->canEdit()) {
			$items[] = ElggMenuItem::factory([
						'name' => 'log_payment',
						'text' => elgg_echo('payments:transaction:log_payment'),
						'href' => "payments/transaction/{$transaction->getId()}/log_payment",
			]);
		}

		return $items;
	}

}
