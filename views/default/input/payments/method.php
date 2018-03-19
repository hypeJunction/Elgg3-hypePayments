<?php

$gateways = elgg_extract('gateways', $vars);

if (!isset($gateways)) {
	$svc = elgg()->payments;
	/* @var $svc \hypeJunction\Payments\PaymentsService */

	$gateways = $svc->getGateways();
}

if (empty($gateways)) {
	return;
}

$name = elgg_extract('name', $vars, 'payment_method');
$value = elgg_extract('value', $vars);
?>

<div class="payments-method-selector">
	<?php
	foreach ($gateways as $gateway) {
		if (!$gateway instanceof \hypeJunction\Payments\GatewayInterface) {
			continue;
		}

		$id = $gateway->id();
		$uid = base_convert(mt_rand(), 10, 36);

		$view = null;
		if (elgg_view_exists("payments/method/$id/form")) {
			$view = "payments/method/$id/form";
		}

		?>
        <div>
			<?php
			echo elgg_format_element('input', [
				'type' => 'radio',
				'name' => $name,
				'value' => $id,
				'id' => "payments-method-$id-$uid",
				'data-view' => $view,
				'data-config' => json_encode([
					'intent' => elgg_extract('intent', $vars),
				]),
				'checked' => $id == $value,
				'class' => 'payments-method-selector-input',
			])
			?>
            <label for="payments-method-<?= $id ?>-<?= $uid ?>" class="payments-method-selector-label">
                <div class="elgg-image-block">
                    <div class="elgg-image">
                        <div class="payments-method-selector-checkbox">
							<?= elgg_view_icon('check') ?>
                        </div>
                    </div>
                    <div class="elgg-body">
                        <h3><?= elgg_echo("payments:method:$id") ?></h3>
						<?= elgg_view("payments/method/$id/info") ?>
                    </div>
                    <div class="elgg-image-alt">
                        <small
                            class="elgg-subtext payment-method-icons"><?= elgg_view("payments/method/$id/icons") ?></small>
                    </div>
                </div>

                <div class="payments-method-data">
					<?php
					if ($view && $id == $value) {
						echo elgg_view($view);
					}
					?>
                </div>
            </label>
        </div>
		<?php
	}
	?>
</div>

<script>
	require(['input/payments/method']);
</script>