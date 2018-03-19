<?php

use hypeJunction\Payments\Menus;
use hypeJunction\Payments\Transaction;

elgg_set_context('settings');
elgg_push_context('payments');

$id = elgg_extract('transaction_id', $vars);
$filter_context = elgg_extract('filter', $vars, 'view');

$transaction = Transaction::getFromId($id);
if (!$transaction instanceof Transaction) {
	throw new \Elgg\EntityNotFoundException();
}

$user = $transaction->getCustomer();

if ($user instanceof ElggUser) {

	elgg_push_breadcrumb($user->getDisplayName(), $user->getURL());

	elgg_push_breadcrumb(
		elgg_echo('settings'),
		elgg_generate_url('settings:account', [
			'username' => $user->username,
		])
	);
}

elgg_push_breadcrumb(
	elgg_echo('payments:history'),
	elgg_generate_url('collection:object:transaction:owner', [
		'guid' => $user->guid,
	])
);

if (!elgg_view_exists("payments/transactions/$filter_context")) {
	$filter_context = 'view';
}

switch ($filter_context) {
	case 'view' :
		$items = Menus::getTransactionMenuItems($transaction);
		foreach ($items as $item) {
			$item->addLinkClass('elgg-button elgg-button-action');
			elgg_register_menu_item('title', $item);
		}
		break;
}

$title = elgg_echo("payments:transaction:$filter_context");

$vars['entity'] = $transaction;
$vars['filter_context'] = $filter_context;

$content = elgg_view("payments/transactions/$filter_context", $vars);
if (!$content) {
	throw new \Elgg\PageNotFoundException();
}

if (elgg_is_xhr()) {
	echo elgg_view_module('lightbox', $title, $content);

	return;
}

$layout = elgg_view_layout('default', [
	'title' => $title,
	'content' => $content,
	'entity' => $transaction,
	'filter_id' => 'payments/transaction',
	'filter_value' => $filter_context,
]);

echo elgg_view_page($title, $layout, 'default', [
	'entity' => $transaction,
]);
