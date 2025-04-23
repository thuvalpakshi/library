<?php
/**
 * Add a new book
 */

$container_guid = elgg_extract('guid', $vars, elgg_get_logged_in_user_guid());
$container = (int)get_entity($container_guid);

if (!$container || !$container->canWriteToContainer(0, 'object', 'library_book')) {
	throw new \Elgg\Exceptions\Http\EntityPermissionsException();
}

elgg_push_collection_breadcrumbs('object', 'library_book', $container);
elgg_push_breadcrumb(elgg_echo('library:add'));

$title = elgg_echo('library:add');

$vars = [
	'container_guid' => $container_guid,
];

$content = elgg_view_form('library/save', ['prevent_double_submit' => true], $vars);

$body = elgg_view_layout('default', [
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('library/sidebar'),
]);

echo elgg_view_page($title, $body);