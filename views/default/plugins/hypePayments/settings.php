<?php
$entity = elgg_extract('entity', $vars);

echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('payments:environment'),
	'name' => 'params[environment]',
	'value' => $entity->environment,
	'options_values' => [
		'sandbox' => elgg_echo('payments:environment:sandbox'),
		'production' => elgg_echo('payments:environment:production'),
	],
]);
