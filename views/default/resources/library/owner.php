<?php
/**
 * List a user's library books
 */

$username = elgg_extract('username', $vars);
$user = get_user_by_username($username);
if (!$user) {
	throw new \Elgg\Exceptions\Http\EntityNotFoundException();
}

elgg_push_collection_breadcrumbs('object', 'library_book', $user);

elgg_register_title_button('library', 'add', 'object', 'library_book');

$content = elgg_list_entities([
	'type' => 'object',
	'subtype' => 'library_book',
	'owner_guid' => $user->guid,
	'full_view' => false,
	'no_results' => elgg_echo('library:none'),
	'distinct' => false,
]);

$title = elgg_echo('library:owner', [$user->getDisplayName()]);

$body = elgg_view_layout('default', [
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('library/sidebar'),
	'filter_id' => 'library',
	'filter_value' => 'owner',
]);

echo elgg_view_page($title, $body);