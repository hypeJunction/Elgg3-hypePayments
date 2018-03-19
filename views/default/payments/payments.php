<?php

use hypeJunction\Payments\Amount;
use hypeJunction\Payments\PaymentInterface;
use hypeJunction\Payments\Transaction;

$transaction = elgg_extract('entity', $vars);
if (!$transaction instanceof Transaction) {
	return;
}

$payments = $transaction->getPayments();
if (empty($payments)) {
	return;
}

$balance = 0;
?>

<table class="elgg-table payments-table payments-transaction-payments">
	<thead>
		<tr>
			<th><?= elgg_echo('payments:payment:time_created') ?></th>
			<th><?= elgg_echo('payments:payment:payment_method') ?></th>
			<th><?= elgg_echo('payments:payment:description') ?></th>
			<th><?= elgg_echo('payments:payment:amount') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($payments as $payment) {
			/* @var $payment PaymentInterface */
			$balance += $payment->getAmount()->getAmount();
			?>
			<tr>
				<td><?= date('M j, Y H:i', $payment->getTimeCreated()) ?></td>
				<td><?= elgg_view("payments/method/{$payment->getPaymentMethod()}") ?></td>
				<td><?= $payment->getDescription() ?></td>
				<td><?= $payment->getAmount()->format() ?></td>
			</tr>
			<?php
		}
		?>
			<tr class="payments-transaction-payments-balance">
				<td colspan="3"><?= elgg_echo('payments:payment:balance') ?></td>
				<td><?= (new Amount($balance, $transaction->getAmount()->getCurrency()))->format() ?></td>
			</tr>
	</tbody>
</table>
