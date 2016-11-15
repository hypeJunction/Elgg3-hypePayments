<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof hypeJunction\Payments\Transaction) {
	return;
}

$vars['full_view'] = true;
echo elgg_view_entity($entity, $vars);