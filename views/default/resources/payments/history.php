<?php

elgg_gatekeeper();

$guid = elgg_extract('guid', $vars);
$entity = get_entity($guid);

if (!$entity || !$entity->canEdit()) {
	forward('', '403');
}

elgg_set_context('settings');
elgg_push_context('payments');

elgg_set_page_owner_guid($entity->guid);

if ($entity instanceof ElggUser) {
	elgg_push_breadcrumb($entity->getDisplayName(), "/settings/user/$entity->username");
}
elgg_push_breadcrumb(elgg_echo('payments:history'), "/payments/history/$entity->guid");

$title = elgg_echo('payments:history');
$content = elgg_view('payments/listing/transactions/customer', [
	'entity' => $entity,
]);
$layout = elgg_view_layout('content', [
	'title' => $title,
	'content' => $content,
	'filter' => elgg_view('payments/history/filter', $vars),
	'entity' => $entity,
		]);

echo elgg_view_page($title, $layout, 'default', [
	'entity' => $entity,
]);
