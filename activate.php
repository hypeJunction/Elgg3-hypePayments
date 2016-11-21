<?php

require_once __DIR__ . '/autoloader.php';

use hypeJunction\Payments\Transaction;

$subtypes = [
	Transaction::SUBTYPE => Transaction::class,
];

foreach ($subtypes as $subtype => $class) {
	if (!update_subtype('object', $subtype, $class)) {
		add_subtype('object', $subtype, $class);
	}
}