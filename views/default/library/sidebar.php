<?php
/**
 * Library sidebar
 */

$user = elgg_get_logged_in_user_entity();
if (!$user) {
	return;
}

echo elgg_view_module('aside', elgg_echo('library'), elgg_view_menu('library', [
	'class' => 'elgg-menu-page',
]));