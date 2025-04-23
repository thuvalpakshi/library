<?php
/**
 * Save a book to the library
 */

$guid = (int) get_input('guid');
$container_guid = (int) get_input('container_guid', elgg_get_logged_in_user_guid());

$title = get_input('title', '', false);
$description = get_input('description', '', false);
$tags = get_input('tags');
$access_id = (int) get_input('access_id');

// ISBN and other book information
$isbn = get_input('isbn');
$author = get_input('author', '', false);
$publisher = get_input('publisher', '', false);
$year = (int) get_input('year');

if (empty($title)) {
	return elgg_error_response(elgg_echo('library:error:missing:title'));
}

elgg_make_sticky_form('library');

if ($guid) {
	$entity = get_entity($guid);
	if (!$entity instanceof \Elgg\Library\LibraryBook || !$entity->canEdit()) {
		return elgg_error_response(elgg_echo('library:error:cannot_edit_entity'));
	}
} else {
	$entity = new \Elgg\Library\LibraryBook();
	$entity->container_guid = $container_guid;
}

$entity->title = $title;
$entity->description = $description;
$entity->tags = string_to_tag_array($tags);
$entity->access_id = $access_id;

$entity->isbn = $isbn;
$entity->author = $author;
$entity->publisher = $publisher;
$entity->year = $year;

if (!$entity->save()) {
	return elgg_error_response(elgg_echo('library:error:cannot_save'));
}

elgg_clear_sticky_form('library');

return elgg_ok_response('', elgg_echo('library:save:success'), $entity->getURL());