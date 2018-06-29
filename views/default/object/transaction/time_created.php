<?php

$item = elgg_extract('item', $vars);
if (!$item instanceof \hypeJunction\Payments\Transaction) {
	return;
}

echo elgg_view('output/date', [
	'value' => $item->time,
	'format' => 'M j, Y H:i',
]);