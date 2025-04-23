<?php
/**
 * View a book
 */

$guid = elgg_extract('guid', $vars);
$entity = get_entity($guid);

if (!$entity instanceof \Elgg\Library\LibraryBook) {
	throw new \Elgg\Exceptions\Http\EntityNotFoundException();
}

elgg_push_entity_breadcrumbs($entity);

$content = elgg_view_entity($entity, ['full_view' => true]);

$body = elgg_view_layout('default', [
	'content' => $content,
	'title' => $entity->getDisplayName(),
	'sidebar' => elgg_view('library/sidebar'),
	'entity' => $entity,
]);

echo elgg_view_page($entity->getDisplayName(), $body);