<?php

use hypeJunction\Payments\Transaction;

$entity = elgg_extract('entity', $vars);
if (!$entity->canEdit()) {
	return;
}

echo elgg_list_entities_from_relationship([
	'types' => 'object',
	'subtypes' => Transaction::SUBTYPE,
	'relationship' => 'merchant',
	'relationship_guid' => (int) $entity->guid,
	'inverse_relationship' => false,
	'list_type' => 'table',
	'columns' => [
		elgg()->table_columns->transaction_id(),
		elgg()->table_columns->time_created(null, [
			'format' => 'M j, Y H:i',
		]),
		elgg()->table_columns->payment_method(),
		elgg()->table_columns->customer(),
		elgg()->table_columns->merchant(),
		elgg()->table_columns->amount(),
		elgg()->table_columns->payment_status(),
	],
	'item_class' => 'payments-transaction',
		]);
