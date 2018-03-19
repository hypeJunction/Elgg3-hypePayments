<?php

use hypeJunction\Payments\Transaction;

$item = elgg_extract('item', $vars);
if (!$item instanceof Transaction) {
	return;
}

$funding = $item->getFundingSource();
if ($funding) {
	echo $funding->format();
} else if ($item->payment_method) {
	echo '<small>' . elgg_view("payments/method/$item->payment_method") . '</small>';
}

