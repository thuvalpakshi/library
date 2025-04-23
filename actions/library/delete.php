<?php
/**
 * Delete a book
 */

$guid = (int) get_input('guid');
$entity = get_entity($guid);

if (!$entity instanceof \Elgg\Library\LibraryBook) {
	return elgg_error_response(elgg_echo('library:error:entity_not_found'));
}

if (!$entity->canDelete()) {
	return elgg_error_response(elgg_echo('library:error:cannot_delete'));
}

if (!$entity->delete()) {
	return elgg_error_response(elgg_echo('library:error:cannot_delete'));
}

return elgg_ok_response('', elgg_echo('library:delete:success'));