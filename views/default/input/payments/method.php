<?php

$gateways = elgg_extract('gateways', $vars);
$sources = elgg_extract('sources', $vars);

if (!isset($gateways)) {
	$gateways = \hypeJunction\Payments\PaymentsService::instance()->getGateways();
}

if (!isset($sources)) {
	$sources = \hypeJunction\Payments\PaymentsService::instance()->getSources();
}

if (empty($gateways) && empty($sources)) {
	return;
}

$name = elgg_extract('name', $vars, 'payment_method');
$value = elgg_extract('value', $vars);
?>

<div class="payments-method-selector">
	<?php
	foreach ($sources as $source) {
		if (!$source instanceof \hypeJunction\Payments\PaymentSource) {
			continue;
		}

		$gateway = $source->getGateway();
		$id = $gateway->id();
		$uid = base_convert(mt_rand(), 10, 36);
		?>
        <div>
			<?php
			echo elgg_format_element('input', [
				'type' => 'radio',
				'name' => $name,
				'value' => "{$gateway->id()}::{$source->getId()}",
				'id' => "payments-method-$id-$uid",
				'checked' => $source->getId() == $value,
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
                        <h3><?= $source->getLabel() ?></h3>
                    </div>
                    <div class="elgg-image-alt">
                        <small class="elgg-subtext payment-method-icons">
							<?php
							$icon_url = $source->getIconURL();
							if ($icon_url) {
								echo elgg_view('output/img', [
									'src' => $icon_url,
								]);
							}
							?>
                        </small>
                    </div>
                </div>
            </label>
        </div>
		<?php
	}

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