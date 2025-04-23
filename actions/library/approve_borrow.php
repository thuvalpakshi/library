<?php
/**
 * Approve a request to borrow a book
 */

$guid = (int) get_input('guid');
$entity = get_entity($guid);

if (!$entity instanceof \Elgg\Library\LibraryBook) {
	return elgg_error_response(elgg_echo('library:error:entity_not_found'));
}

if ($entity->owner_guid !== elgg_get_logged_in_user_guid()) {
	return elgg_error_response(elgg_echo('library:error:not_owner'));
}

if ($entity->isBorrowed()) {
	return elgg_error_response(elgg_echo('library:error:already_borrowed'));
}

if (!$entity->hasRequest()) {
	return elgg_error_response(elgg_echo('library:error:no_request'));
}

$requester = $entity->getRequester();
if (!$requester) {
	return elgg_error_response(elgg_echo('library:error:requester_not_found'));
}

// Remove the request annotation
$annotations = elgg_get_annotations([
	'guid' => $entity->guid,
	'annotation_name' => 'request',
	'annotation_owner_guid' => $requester->guid,
	'limit' => false,
]);

foreach ($annotations as $annotation) {
	$annotation->delete();
}

// Add the borrow annotation
$id = $entity->annotate('borrow', true, $entity->access_id, $requester->guid);
if (!$id) {
	return elgg_error_response(elgg_echo('library:error:cannot_approve'));
}

// Notify the requester
notify_user($requester->guid, $entity->owner_guid, elgg_echo('library:approved:subject'), elgg_echo('library:approved:message', [$entity->getDisplayName()]));

return elgg_ok_response('', elgg_echo('library:approved:success'));