<?php

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

elgg_set_ignore_access(true);
$title = elgg_echo('payments:history');
$content = elgg_list_entities_from_relationship([
	'types' => 'object',
	'subtypes' => \hypeJunction\Payments\Transaction::SUBTYPE,
	'relationship' => 'customer',
	'relationship_guid' => $entity->guid,
	'inverse_relationship' => false,
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
