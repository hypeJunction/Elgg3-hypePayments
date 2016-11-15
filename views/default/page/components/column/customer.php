<?php

use hypeJunction\Payments\TransactionInterface;

$item = elgg_extract('item', $vars);
if (!$item instanceof TransactionInterface) {
	return;
}

$customer = $item->getCustomer();
if (!$customer) {
	return;
}
if ($customer->guid) {
	echo elgg_view('output/url', [
		'text' => $customer->getDisplayName(),
		'href' => $customer->getURL(),
	]);
} else {
	echo $customer->title;
}

