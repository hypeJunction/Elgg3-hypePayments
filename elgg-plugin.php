<?php

return [
	'plugin' => [
		'version' => '5.0.0',
	],

	'bootstrap' => \hypeJunction\Payments\Bootstrap::class,

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

	'view_extensions' => [
		'elements/components.css' => [
			'payments/stylesheet.css' => [],
		],
		'admin.css' => [
			'payments/stylesheet.css' => [],
		],
		'elements/forms.css' => [
			'input/payments/method.css' => [],
		],
	],

	'events' => [
		'register' => [
			'menu:page' => [
				\hypeJunction\Payments\PageMenu::class => [],
			],
		],
	],
];
