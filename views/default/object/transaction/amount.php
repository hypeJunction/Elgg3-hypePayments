<?php

use hypeJunction\Payments\TransactionInterface;

$item = elgg_extract('item', $vars);
if (!$item instanceof TransactionInterface) {
	return;
}

echo $item->getAmount()->format();
