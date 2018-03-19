<?php

namespace hypeJunction\Payments;

use hypeJunction\Lists\Collection;

class CustomerTransactionCollection extends Collection {

	/**
	 * Get ID of the collection
	 * @return string
	 */
	public function getId() {
		return 'collection:object:transaction:customer';
	}

	/**
	 * Get title of the collection
	 * @return string
	 */
	public function getDisplayName() {
		return elgg_echo('collection:object:transaction');
	}

	/**
	 * Get the type of collection, e.g. owner, friends, group all
	 * @return string
	 */
	public function getCollectionType() {
		return 'customer';
	}

	/**
	 * Get type of entities in the collection
	 * @return mixed
	 */
	public function getType() {
		return 'object';
	}

	/**
	 * Get subtypes of entities in the collection
	 * @return string|string[]
	 */
	public function getSubtypes() {
		return [Transaction::SUBTYPE];
	}

	/**
	 * Get default query options
	 *
	 * @param array $options Query options
	 *
	 * @return array
	 */
	public function getQueryOptions(array $options = []) {
		return array_merge($options, [
			'relationship' => 'customer',
			'relationship_guid' => (int) $this->getTarget()->guid,
			'inverse_relationship' => false,
		]);
	}

	/**
	 * Get default list view options
	 *
	 * @param array $options List view options
	 *
	 * @return mixed
	 */
	public function getListOptions(array $options = []) {
		return array_merge($options, [
			'list_type' => 'table',
			'columns' => \hypeJunction\Payments\Transaction::getTableColumns(),
			'list_class' => 'payments-transactions',
			'item_class' => 'payments-transaction',
			'no_results' => elgg_echo('payments:transactions:no_results'),
		]);
	}

	/**
	 * Returns base URL of the collection
	 *
	 * @return string
	 */
	public function getURL() {
		return elgg_generate_url($this->getId(), [
			'guid' => $this->getTarget()->guid,
		]);
	}
}