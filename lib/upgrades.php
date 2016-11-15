<?php

use hypeJunction\Payments\Amount;
use hypeJunction\Payments\Transaction;

run_function_once('payments_upgrade_20161110a');

/**
 * Move transactions from files to metadata
 */
function payments_upgrade_20161110a() {

	$transactions = new ElggBatch('elgg_get_entities', [
		'types' => 'object',
		'subtypes' => Transaction::SUBTYPE,
		'limit' => 0,
	]);

	$site = elgg_get_site_entity();
	foreach ($transactions as $transaction) {
		/* @var $transaction Transaction */

		$id = $transaction->transaction_id;

		$file = new ElggFile();
		$file->owner_guid = $site->guid;
		$file->setFilename("transactions/$id.json");

		if (!$file->exists()) {
			continue;
		}

		$file->open('read');
		$json = $file->grabFile();
		$file->close();

		$transaction->access_id = ACCESS_PRIVATE;

		$data = json_decode($json, true);

		$customer = get_entity($data['_customer']['_id']);
		$merchant = get_entity($data['_merchant']['_id']);

		$currency = $data['_currency'];
		$total = $data['_total'];

		$amount = new Amount($total, $currency);
		$transaction->setAmount($amount);
		if ($merchant) {
			$transaction->setMerchant($merchant);
		}
		if ($customer) {
			$transaction->setCustomer();
		}

		if (!$transaction->getPaymentMethod()) {
			$transaction->setPaymentMethod($data['_payment_method']);
		}

		$transaction->setMetadata('details', json_encode($data));

		if ($transaction->save()) {
			$file->delete();
		}
	}
}
