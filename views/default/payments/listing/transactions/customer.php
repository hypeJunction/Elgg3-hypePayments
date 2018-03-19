<?php

use hypeJunction\Payments\Transaction;

$entity = elgg_extract('entity', $vars);
if (!$entity->canEdit()) {
	return;
}

echo elgg_list_entities([
	'types' => 'object',
	'subtypes' => Transaction::SUBTYPE,
	'relationship' => 'customer',
	'relationship_guid' => (int) $entity->guid,
	'inverse_relationship' => false,
	'list_type' => 'table',
	'columns' => \hypeJunction\Payments\Transaction::getTableColumns(),
	'list_class' => 'payments-transactions',
	'item_class' => 'payments-transaction',
	'no_results' => elgg_echo('payments:transactions:no_results'),
]);
