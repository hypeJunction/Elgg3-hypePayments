<?php

use hypeJunction\Payments\TransactionInterface;

$item = elgg_extract('item', $vars);
if (!$item instanceof TransactionInterface) {
	return;
}

echo elgg_view('output/url', [
	'text' => $item->guid,
	'href' => $item->getURL(),
	'title' => $item->transaction_id,
]);
