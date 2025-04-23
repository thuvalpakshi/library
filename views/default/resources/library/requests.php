<?php
/**
 * Show the requests to borrow books
 */

elgg_push_collection_breadcrumbs('object', 'library_book');
elgg_push_breadcrumb(elgg_echo('library:requests'));

$user = elgg_get_logged_in_user_entity();

$content = elgg_list_entities([
	'type' => 'object',
	'subtype' => 'library_book',
	'owner_guid' => $user->guid,
	'annotation_name' => 'request',
	'full_view' => false,
	'no_results' => elgg_echo('library:norequests'),
	'distinct' => false,
]);

$title = elgg_echo('library:requests');

$body = elgg_view_layout('default', [
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('library/sidebar'),
	'filter_id' => 'library',
	'filter_value' => 'requests',
]);

echo elgg_view_page($title, $body);