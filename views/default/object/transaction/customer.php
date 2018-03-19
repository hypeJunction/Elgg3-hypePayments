<?php

use hypeJunction\Payments\TransactionInterface;

$item = elgg_extract('item', $vars);
if (!$item instanceof TransactionInterface) {
	return;
}

$customer_name = '';
$customer_email = '';
$customer_url = false;

$customer = $item->getCustomer();
if ($customer instanceof ElggEntity) {
	$customer_name = $customer->getDisplayName();
	$customer_url = $customer->getURL();
	if ($customer->email) {
		$customer_email = $customer->email;
	}
}

if (empty($customer_name)) {
	$customer_name = implode(' ', [$item->first_name, $item->last_name]);
}

if (empty($customer_email)) {
	$customer_email = $item->email;
}

echo elgg_view('output/url', [
	'text' => $customer_name,
	'href' => $customer_url,
]);

if ($customer_email) {
	echo '<br />';
	echo '<small>' . elgg_view('output/url', [
			'href' => "mailto:$customer_email",
			'text' => elgg_get_excerpt($customer_email, 25),
			'icon' => 'envelope',
		]) . '</small>';
}

