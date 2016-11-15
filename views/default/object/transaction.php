<?php

$entity = elgg_extract('entity', $vars);
$full_view = elgg_extract('full_view', $vars, false);

if (!$entity instanceof \hypeJunction\Payments\Transaction) {
	return;
}

$table = elgg_view_entity_list([$entity], [
	'full_view' => false,
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
