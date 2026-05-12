<?php

return [
	'payments' => \DI\create(\hypeJunction\Payments\PaymentsService::class)
		->constructor(\DI\get('hooks')),

	'payments.storage' => \DI\create(\hypeJunction\Payments\SessionStorage::class),
];
