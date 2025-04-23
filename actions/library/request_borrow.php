<?php
/**
 * Request to borrow a book
 */

$guid = (int) get_input('guid');
$entity = get_entity($guid);

if (!$entity instanceof \Elgg\Library\LibraryBook) {
	return elgg_error_response(elgg_echo('library:error:entity_not_found'));
}

$user = elgg_get_logged_in_user_entity();

if ($entity->owner_guid === $user->guid) {
	return elgg_error_response(elgg_echo('library:error:owner_cannot_borrow'));
}

if ($entity->isBorrowed() || $entity->hasRequest()) {
	return elgg_error_response(elgg_echo('library:error:already_borrowed'));
}

$id = $entity->annotate('request', true, $entity->access_id, $user->guid);
if (!$id) {
	return elgg_error_response(elgg_echo('library:error:cannot_request'));
}

// Notify the owner about the request
notify_user($entity->owner_guid, $user->guid, elgg_echo('library:request:subject'), elgg_echo('library:request:message', [$user->getDisplayName(), $entity->getDisplayName()]));

return elgg_ok_response('', elgg_echo('library:request:success'));