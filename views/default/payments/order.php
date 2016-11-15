<?php

use hypeJunction\Payments\Amount;
use hypeJunction\Payments\ChargeInterface;
use hypeJunction\Payments\OrderInterface;

$order = elgg_extract('order', $vars);
if (!$order instanceof OrderInterface) {
	return;
}

$incl_charges = [];
?>

<table class="elgg-table payments-table payments-order-table">
	<thead>
		<tr>
			<th class="payments-order-item-description"><?= elgg_echo('payments:order:product') ?></th>
			<th><?= elgg_echo('payments:order:price') ?></th>
			<th><?= elgg_echo('payments:order:quantity') ?></th>
			<th><?= elgg_echo('payments:order:total') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		$items = $order->all();
		foreach ($items as $item) {
			?>
			<tr>
				<td class="payments-order-item-description">
					<?php
					echo $item->getTitle();
					?>
				</td>
				<td class="payments-order-item-price">
					<?php
					echo $item->getPrice()->format();
					?>
				</td>
				<td class="payments-order-item-quantity">
					<?php
					echo $item->getQuantity();
					?>
				</td>
				<td class="payments-order-item-total">
					<?php
					echo $item->getTotalAmount()->format();
					?>
				</td>
			</tr>
			<?php
			$item_charges = $item->getCharges();
			foreach ($item_charges as $item_charge) {
				$item_charge_id = $item_charge->getId();
				$item_charge_amount = $item_charge->getTotalAmount();

				if (isset($incl_charges[$item_charge_id])) {
					$currency = $incl_charges[$item_charge_id]->getCurrency();
					$new_amount = $incl_charges[$item_charge_id]->getAmount() + $item_charge_amount->getAmount();
					$incl_charges[$item_charge_id] = new Amount($new_amount, $currency);
				} else {
					$incl_charges[$item_charge_id] = $item_charge_amount;
				}
			}
		}
		?>
		<tr class="payments-order-subtotal">
			<td colspan="3"><?= elgg_echo('payments:order:subtotal') ?></td>
			<td>
				<?php
				echo $order->getSubtotalAmount()->format()
				?>
			</td>
		</tr>
		<?php
		$charges = $order->getCharges();
		foreach ($charges as $charge) {
			/* @var $charge ChargeInterface */
			?>
			<tr class="payments-order-subtotal payments-order-charges-excluded">
				<td colspan="3"><?= elgg_echo("payments:charges:{$charge->getId()}") ?></td>
				<td>
					<?php
					echo $charge->getTotalAmount()->format();
					?>
				</td>
			</tr>
			<?php
		}
		?>
		<tr class="payments-order-total">
			<td colspan="3">
				<?php
				echo elgg_echo('payments:order:total');
				?>
			</td>
			<td>
				<?php
				echo $order->getTotalAmount()->format();
				?>
			</td>
		</tr>
		<?php
		foreach ($incl_charges as $id => $charge_amount) {
			?>
			<tr class="payments-order-subtotal payments-order-charges-included">
				<td colspan="3"><?= elgg_echo('payments:incl', [elgg_echo("payments:charges:$id")]) ?></td>
				<td>
					<?php
					echo $charge_amount->format();
					?>
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>