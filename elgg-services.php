<?php

return [
	'payments' => \DI\object(\hypeJunction\Payments\PaymentsService::class)
		->constructor(\DI\get('hooks')),

	'payments.storage' => \DI\object(\hypeJunction\Payments\SessionStorage::class),
];
