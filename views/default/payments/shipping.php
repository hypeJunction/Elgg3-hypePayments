<?php

use hypeJunction\Payments\Address;
use hypeJunction\Payments\OrderInterface;

$order = elgg_extract('order', $vars);
if (!$order instanceof OrderInterface) {
	return;
}
?>

<table class="elgg-table payments-table payments-order-shipping">
	<thead>
		<tr>
			<th><?= elgg_echo('payments:order:shipping_address') ?></th>
			<th><?= elgg_echo('payments:order:billing_address') ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<?php
				$shipping_address = $order->getShippingAddress();
				if ($shipping_address instanceof Address) {
					echo $shipping_address->format();
				} else {
					echo elgg_echo('payments:not_specified');
				}
				?>
			</td>
			<td>
				<?php
				$billing_address = $order->getBillingAddress();
				if ($billing_address instanceof Address) {
					echo $billing_address->format();
				} else {
					echo elgg_echo('payments:not_specified');
				}
				?>
			</td>
		</tr>
	</tbody>
</table>
