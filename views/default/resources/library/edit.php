<?php
/**
 * Edit a book
 */

$guid = elgg_extract('guid', $vars);
$entity = get_entity($guid);

if (!$entity instanceof \Elgg\Library\LibraryBook) {
	throw new \Elgg\Exceptions\Http\EntityNotFoundException();
}

if (!$entity->canEdit()) {
	throw new \Elgg\Exceptions\Http\EntityPermissionsException();
}

elgg_push_entity_breadcrumbs($entity);

$title = elgg_echo('library:edit');

$vars = [
	'entity' => $entity,
];

$content = elgg_view_form('library/save', ['prevent_double_submit' => true], $vars);

$body = elgg_view_layout('default', [
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('library/sidebar'),
]);

echo elgg_view_page($title, $body);