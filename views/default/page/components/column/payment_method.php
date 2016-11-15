<?php

use hypeJunction\Payments\Transaction;

$item = elgg_extract('item', $vars);
if (!$item instanceof Transaction) {
	return;
}

if ($item->payment_method) {
	echo elgg_view("payments/method/$item->payment_method");
}

$funding = $item->getFundingSource();
if ($funding) {
	echo $funding->format();
}
