<?php

$id = elgg_extract('id', $vars);
$transaction = hypeJunction\Payments\Transaction::getFromId($id);

if (!$transaction) {
	return;
}

$user = $transaction->getCustomer();
if ($user instanceof ElggUser) {
	elgg_push_breadcrumb($user->getDisplayName(), "/settings/user/$user->username");
}
elgg_push_breadcrumb(elgg_echo('payments:history'), "/payments/history/$user->guid");

$title = elgg_echo('payments:transaction:id', [$id]);
$content = elgg_view_entity($transaction, [
	'full_view' => true,
]);

$layout = elgg_view_layout('content', [
	'title' => $title,
	'content' => $content,
	'entity' => $transaction,
	'filter' => '',
]);

echo elgg_view_page($title, $layout, 'default', [
	'entity' => $transaction,
]);