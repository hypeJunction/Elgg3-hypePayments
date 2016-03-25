<?php
$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \hypeJunction\Payments\Transaction) {
	return;
}

?>

<div class="payments-transaction-summary">
	<div class="payments-transaction-time">
		<?php
			echo date("M j, Y H:i", $entity->getTimeCreated());
		?>
	</div>
	<div class="payments-transaction-method">
		<?php
			echo elgg_view("payments/method/$entity->payment_method");
		?>
	</div>
	<div class="payments-transaction-merchant">
		<?php
			$merchant = $entity->getDetails('_merchant');
			echo $merchant['title'] ? : $merchant['name'];
		?>
	</div>
	<div class="payments-transaction-amount">
		<?php
			echo hypeJunction\Payments\Price::format($entity->getAmount(), $entity->getCurrency());
		?>
	</div>
	<div class="payments-transaction-status">
		<?php
			echo elgg_echo("payments:status:$entity->status");
		?>
	</div>
</div>