<?php
/**
 * Library menu
 */

$user = elgg_get_logged_in_user_entity();
if (!$user) {
	return;
}

$menu = [];

$menu[] = [
	'name' => 'all',
	'text' => elgg_echo('library:all'),
	'href' => elgg_generate_url('collection:object:library_book:all'),
];

$menu[] = [
	'name' => 'owner',
	'text' => elgg_echo('library:owner', [$user->getDisplayName()]),
	'href' => elgg_generate_url('collection:object:library_book:owner', [
		'username' => $user->username,
	]),
];

$menu[] = [
	'name' => 'add',
	'text' => elgg_echo('library:add'),
	'href' => elgg_generate_url('add:object:library_book'),
];

$menu[] = [
	'name' => 'requests',
	'text' => elgg_echo('library:requests'),
	'href' => elgg_generate_url('library:requests'),
];

foreach ($menu as $item) {
	echo elgg_view('navigation/menu/elements/item', [
		'item' => new \ElggMenuItem($item['name'], $item['text'], $item['href']),
	]);
}