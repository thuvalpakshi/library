<?php
/**
 * List all books in the library
 */

elgg_push_collection_breadcrumbs('object', 'library_book');

elgg_register_title_button('library', 'add', 'object', 'library_book');

$content = elgg_list_entities([
	'type' => 'object',
	'subtype' => 'library_book',
	'full_view' => false,
	'no_results' => elgg_echo('library:none'),
	'distinct' => false,
]);

$title = elgg_echo('library:all');

$body = elgg_view_layout('default', [
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('library/sidebar'),
	'filter_id' => 'library',
	'filter_value' => 'all',
]);

echo elgg_view_page($title, $body);