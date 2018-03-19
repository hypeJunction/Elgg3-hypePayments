<?php

use hypeJunction\Payments\TransactionInterface;

$item = elgg_extract('item', $vars);
if (!$item instanceof TransactionInterface) {
	return;
}

$merchant = $item->getMerchant();
if (!$merchant) {
	return;
}

if ($merchant->guid) {
	echo elgg_view('output/url', [
		'text' => $merchant->getDisplayName(),
		'href' => $merchant->getURL(),
	]);
} else {
	echo $merchant->title;
}

