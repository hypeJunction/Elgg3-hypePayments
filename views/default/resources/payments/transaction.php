<?php

use hypeJunction\Payments\Menus;
use hypeJunction\Payments\Transaction;

elgg_gatekeeper();

$id = elgg_extract('id', $vars);
$filter_context = elgg_extract('filter_context', $vars, 'view');

$transaction = Transaction::getFromId($id);
if (!$transaction instanceof Transaction) {
	forward('', '404');
}

$user = $transaction->getCustomer();
if ($user instanceof ElggUser) {
	elgg_push_breadcrumb($user->getDisplayName(), "/settings/user/$user->username");
}

elgg_push_breadcrumb(elgg_echo('payments:history'), "/payments/history/$user->guid");

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
elgg_push_breadcrumb($title, $transaction->getURL());

$vars['entity'] = $transaction;
$vars['filter_context'] = $filter_context;

$content = elgg_view("payments/transactions/$filter_context", $vars);
if (!$content) {
	forward('', '404');
}

if (elgg_is_xhr()) {
	echo elgg_view_module('lightbox', $title, $content);
	return;
}

$layout = elgg_view_layout('content', [
	'title' => $title,
	'content' => $content,
	'entity' => $transaction,
	'filter' => '',
		]);

echo elgg_view_page($title, $layout, 'default', [
	'entity' => $transaction,
]);
