<?php

namespace hypeJunction\Payments;

use Elgg\Upgrade\Batch;
use Elgg\Upgrade\Result;

/**
 * Migrate transaction storage from files to metadata
 */
class MigrateFilesToMetadata implements Batch {

	/**
	 * Version of the upgrade
	 *
	 * This tells the date when the upgrade was added. It consists of eight digits and is in format ``yyyymmddnn``
	 * where:
	 *
	 * - ``yyyy`` is the year
	 * - ``mm`` is the month (with leading zero)
	 * - ``dd`` is the day (with leading zero)
	 * - ``nn`` is an incrementing number (starting from ``00``) that is used in case two separate upgrades
	 *          have been added during the same day
	 *
	 * @return int E.g. 2016123101
	 */
	public function getVersion() {
		return 2016111001;
	}

	/**
	 * Should this upgrade be skipped?
	 *
	 * If true, the upgrade will not be performed and cannot be accessed later.
	 *
	 * @return bool
	 */
	public function shouldBeSkipped() {
		return !$this->countItems();
	}

	/**
	 * Should the run() method receive an offset representing all processed items?
	 *
	 * If true, run() will receive as $offset the number of items already processed. This is useful
	 * if you are only modifying data, and need to use the $offset in a function like elgg_get_entities*()
	 * to know how many to skip over.
	 *
	 * If false, run() will receive as $offset the total number of failures. This should be used if your
	 * process deletes or moves data out of the way of the process. E.g. if you delete 50 objects on each
	 * run(), you may still use the $offset to skip objects that already failed once.
	 *
	 * @return bool
	 */
	public function needsIncrementOffset() {
		return true;
	}

	/**
	 * The total number of items to process during the upgrade
	 *
	 * If unknown, Batch::UNKNOWN_COUNT should be returned, and run() must manually mark the result
	 * as complete.
	 *
	 * @return int
	 */
	public function countItems() {
		return elgg_get_entities([
			'types' => 'object',
			'subtypes' => Transaction::SUBTYPE,
			'count' => true,
		]);
	}

	/**
	 * Runs upgrade on a single batch of items
	 *
	 * If countItems() returns Batch::UNKNOWN_COUNT, this method must call $result->markCompleted()
	 * when the upgrade is complete.
	 *
	 * @param Result $result Result of the batch (this must be returned)
	 * @param int    $offset Number to skip when processing
	 *
	 * @return Result Instance of \Elgg\Upgrade\Result
	 * @throws \IOException
	 * @throws \InvalidParameterException
	 */
	public function run(Result $result, $offset) {

		$site = elgg_get_site_entity();

		$transactions = elgg_get_entities([
			'types' => 'object',
			'subtypes' => Transaction::SUBTYPE,
			'limit' => 10,
			'offset' => $offset,
		]);

		foreach ($transactions as $transaction) {
			/* @var $transaction Transaction */

			$id = $transaction->transaction_id;

			$file = new \ElggFile();
			$file->owner_guid = $site->guid;
			$file->setFilename("transactions/$id.json");

			if (!$file->exists()) {
				$result->addSuccesses(1);
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
				$result->addSuccesses();
				$file->delete();
			} else {
				$result->addFailures();
			}
		}

		return $result;
	}
}