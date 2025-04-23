<?php
/**
 * Library sidebar
 */

// Display sidebar menu
echo elgg_view_menu('library', [
	'class' => 'elgg-menu-page',
]);

// Add a search box
echo elgg_view('search/search_box', [
	'type' => 'object',
	'subtype' => 'library_book',
]);