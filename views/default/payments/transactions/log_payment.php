<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof hypeJunction\Payments\Transaction || !$entity->canEdit()) {
	return;
}

echo elgg_view_form('transactions/log_payment', [], $vars);

