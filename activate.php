<?php

require_once __DIR__ . '/autoloader.php';

$subtypes = [
	hypeJunction\Payments\Transaction::SUBTYPE => hypeJunction\Payments\Transaction::CLASSNAME,
];

foreach ($subtypes as $subtype => $class) {
	if (!update_subtype('object', $subtype, $class)) {
		add_subtype('object', $subtype, $class);
	}
}