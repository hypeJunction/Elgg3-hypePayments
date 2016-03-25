<?php

$entity = elgg_extract('entity', $vars);
?>
<div>
	<label><?= elgg_echo('payments:environment') ?></label>
	<?php
		echo elgg_view('input/dropdown', [
			'name' => 'params[environment]',
			'value' => $entity->environment,
			'options_values' => [
				'sandbox' => elgg_echo('payments:environment:sandbox'),
				'production' => elgg_echo('payments:environment:production'),
			],
		]);
	?>
</div>
