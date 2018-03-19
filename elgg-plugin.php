<?php

return [
	'entities' => [
		[
			'type' => 'object',
			'subtype' => 'transaction',
			'class' => \hypeJunction\Payments\Transaction::class,
		],
	],
	'actions' => [
		'transactions/refund' => [
			'controller' => \hypeJunction\Payments\Actions\RefundTransaction::class,
		],
		'transactions/log_payment' => [
			'controller' => \hypeJunction\Payments\Actions\LogPayment::class,
		],
	],
	'routes' => [
		'collection:object:transaction:customer' => [
			'path' => '/payments/history/{guid}',
			'resource' => 'payments/history',
			'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
		],
		'collection:object:transaction:merchant' => [
			'path' => '/payments/merchant/{guid}',
			'resource' => 'payments/merchant',
			'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
		],
		'view:object:transaction' => [
			'path' => '/payments/transaction/{transaction_id?}/{filter?}',
			'resource' => 'payments/transaction',
			'defaults' => [
				'filter' => 'view',
			],
		],
	],
	'settings' => [
		'environment' => 'sandbox',
	],
];
