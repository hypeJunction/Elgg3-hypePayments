<?php

use hypeJunction\Payments\Amount;
use hypeJunction\Payments\Payment;
use hypeJunction\Payments\Transaction;

$guid = get_input('guid');
$entity = get_entity($guid);

if (!$entity instanceof Transaction) {
	$error = elgg_echo('payments:error:not_found');
	return elgg_error_response($error, REFERRER, ELGG_HTTP_NOT_FOUND);
}

if (!$entity->canEdit()) {
	$error = elgg_echo('payments:error:permissions');
	return elgg_error_response($error, REFERRER, ELGG_HTTP_FORBIDDEN);
}

$type = get_input('type');
$status = get_input('status');
$amount = get_input('amount', '0');

$currency = $entity->getAmount()->getCurrency();

if ($type == 'refund') {
	$amount = (float) $amount;
	$amount = (string) -$amount;
	$reason = elgg_echo('payments:refund');
} else {
	$reason = elgg_echo('payments:payment');
}

$amount = Amount::fromString($amount, $currency);

if ($amount->getAmount()) {
	$payment = new Payment();
	$payment->setAmount($amount)
			->setDescription($reason)
			->setPaymentMethod($entity->getPaymentMethod())
			->setTimeCreated(time());

	$entity->addPayment($payment);
}

if ($status != $entity->getStatus()) {
	$entity->setStatus($status);
}

$data = [
	'entity' => $entity,
	'action' => 'log_payment',
];
$message = elgg_echo('payments:log_payment:success');
$forward_url = $entity->getURL();
return elgg_ok_response($data, $message, $forward_url);
