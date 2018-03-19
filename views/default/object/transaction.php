<?php

$entity = elgg_extract('entity', $vars);
$full_view = elgg_extract('full_view', $vars, false);

if (!$entity instanceof \hypeJunction\Payments\Transaction) {
	return;
}

$table = elgg_view_entity_list([$entity], [
	'full_view' => false,
	'list_type' => 'table',
	'columns' => \hypeJunction\Payments\Transaction::getTableColumns(),
	'list_class' => 'payments-transactions',
	'item_class' => 'payments-transaction',
		]);

if (!$full_view) {
	echo $table;
	return;
}

echo elgg_view_module('aside', elgg_echo('payments:transaction'), $table);

$payments = elgg_view('payments/payments', $vars);
if ($payments) {
	echo elgg_view_module('aside', elgg_echo('payments:payments'), $payments);
}

$order = $entity->getOrder();
if ($order) {
	$order_view = elgg_view('payments/order', [
		'order' => $order,
	]);

	echo elgg_view_module('aside', elgg_echo('payments:order'), $order_view);

	$shipping_view = elgg_view('payments/shipping', [
		'order' => $order,
	]);

	echo elgg_view_module('aside', elgg_echo('payments:order:shipping'), $shipping_view);
}
