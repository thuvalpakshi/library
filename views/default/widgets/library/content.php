<?php
/**
 * Library widget content
 */

$widget = elgg_extract('entity', $vars);
$owner = $widget->getOwnerEntity();

if (!$owner instanceof \ElggUser) {
	return;
}

echo elgg_list_entities([
	'type' => 'object',
	'subtype' => 'library_book',
	'owner_guid' => $owner->guid,
	'limit' => (int) $widget->num_display ?: 4,
	'full_view' => false,
	'no_results' => elgg_echo('library:none'),
	'pagination' => false,
]);