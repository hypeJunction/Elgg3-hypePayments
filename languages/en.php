<?php

return [

	'item:object:transaction' => 'Transaction',
	'collection:object:transaction' => 'Transactions',

	'payments' => 'Payments',
	'payments:history' => 'Payment history',

	'payments:price' => '%s %s',

	'payments:environment' => 'Environment',
	'payments:environment:sandbox' => 'Sandbox',
	'payments:environment:production' => 'Production',

	'payments:status:new' => 'Unpaid',
	'payments:status:payment_pending' => 'Pending',
	'payments:status:paid' => 'Paid',
	'payments:status:refunded' => 'Refunded',
	'payments:status:failed' => 'Failed',
	'payments:status:partially_refunded' => 'Partially Refunded',
	'payments:status:refund_pending' => 'Refund Pending',

	'payments:transaction:id' => 'Transaction %s',
	'payments:processing_fee' => 'Processing fee %s%%',
	'payments:no_processing_fee' => 'No processing fee',

	'ViewColumn:view:object/transaction/merchant' => 'Payee',
	'ViewColumn:view:object/transaction/customer' => 'Payer',
	'ViewColumn:view:object/transaction/payment_status' => 'Status',
	'ViewColumn:view:object/transaction/payment_method' => 'Method',
	'ViewColumn:view:object/transaction/amount' => 'Amount',
	'ViewColumn:view:object/transaction/transaction_id' => 'ID',
	'ViewColumn:view:object/transaction/time_created' => 'Date',

	'payments:transaction' => 'Transaction',
	'payments:transactions:no_results' => 'There are not transactions yet',
	
	'payments:order' => 'Order',
	'payments:order:product'=> 'Item',
	'payments:order:price' => 'Unit price',
	'payments:order:charges' => 'Charges',
	'payments:order:quantity' => 'Quantity',
	'payments:order:subtotal' => 'Subtotal',
	'payments:order:total' => 'Total',
	
	'payments:order:shipping' => 'Shipping',
	'payments:order:shipping_address' => 'Shipping Address',
	'payments:order:billing_address' => 'Billing Address',

	'payments:not_specified' => 'Not specified',

	'payments:payment' => 'Payment',
	'payments:payments' => 'Payments',
	'payments:refund' => 'Refund',
	'payments:refund:confirm' => 'Are you sure you want to initiate a refund of the payment? Depending on the payment gateway used for this transaction, the refund might take place immediately, or you may need to log a refund payment manually',
	'payments:refund:error' => 'Refund could not be issued',
	'payments:refund:success' => 'Refund has been initiated',
	'payments:payment:time_created' => 'Time Created',
	'payments:payment:description' => 'Description',
	'payments:payment:amount' => 'Amount',
	'payments:payment:payment_method' => 'Method',
	'payments:payment:balance' => 'Balance',
	'payments:payment:type' => 'Type',
	'payments:payment:status' => 'Status',
	'payments:payment:status:help' => 'Indicates the status of the transaction after this payment, i.e. if logging a refund change the status to Refunded',
	
	'payments:transaction:view' => 'Transaction details',
	'payments:transaction:log_payment' => 'Log payment',
	'payments:log' => 'Log',
	'payments:log_payment:success' => 'Payment has been logged',
	'payments:incl' => 'incl. %s',

	'payments:error:not_found' => 'Item not found',
	'payments:error:permissions' => 'You do not have sufficient permissions for this action',

	'admin:payments' => 'Payments',
	'menu:page:header:payments' => 'Payments',

	'payments:charges:processing_fee' => 'Processing Fee',
	'payments:charges:shipping_fee' => 'Shipping',
	'payments:charges:coupon' => 'Coupon',
	'payments:charges:site_commission' => 'Site Commission',
	'payments:charges:handling_fee' => 'Handling',

	'payments:invoice:id' => 'Invoice No. %s',

	'payments:method:select' => 'Pay with',
];