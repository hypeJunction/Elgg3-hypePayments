<?php

return [
	'payments' => \DI\create(\hypeJunction\Payments\PaymentsService::class)
		->constructor(\DI\get('events')),

	'payments.storage' => \DI\create(\hypeJunction\Payments\SessionStorage::class),
];
