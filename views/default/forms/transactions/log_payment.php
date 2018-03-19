<?php

use hypeJunction\Payments\Transaction;
use hypeJunction\Payments\TransactionInterface;

$entity = elgg_extract('entity', $vars);

if (!$entity instanceof Transaction) {
	return;
}

echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('payments:payment:type'),
	'name' => 'type',
	'required' => true,
	'options_values' => [
		'payment' => elgg_echo('payments:payment'),
		'refund' => elgg_echo('payments:refund'),
	],
]);

echo elgg_view_field([
	'#type' => 'fieldset',
	'#label' => elgg_echo('payments:payment:amount'),
	'align' => 'horizontal',
	'fields' => [
			[
			'#type' => 'text',
			'name' => 'amount',
			'value' => $entity->getAmount()->getConvertedAmount(),
			'required' => true,
			],
			[
			'#type' => 'text',
			'disabled' => true,
			'value' => $entity->getAmount()->getCurrency(),
			],
	],
]);

echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('payments:payment:status'),
	'#help' => elgg_echo('payments:payment:status:help'),
	'name' => 'status',
	'value' => $entity->getStatus(),
	'required' => true,
	'options_values' => [
		TransactionInterface::STATUS_NEW => elgg_echo('payments:status:new'),
		TransactionInterface::STATUS_PAYMENT_PENDING => elgg_echo('payments:status:payment_pending'),
		TransactionInterface::STATUS_PAID => elgg_echo('payments:status:paid'),
		TransactionInterface::STATUS_REFUND_PENDING => elgg_echo('payments:status:refund_pending'),
		TransactionInterface::STATUS_REFUNDED => elgg_echo('payments:status:refunded'),
		TransactionInterface::STATUS_PARTIALLY_REFUNDED => elgg_echo('payments:status:partially_refunded'),
		TransactionInterface::STATUS_FAILED => elgg_echo('payments:status:failed'),
	],
]);

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'guid',
	'value' => $entity->guid,
]);

$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('payments:log'),
		]);
elgg_set_form_footer($footer);
