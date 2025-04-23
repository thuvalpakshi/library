<?php
/**
 * Return a borrowed book
 */

$guid = (int) get_input('guid');
$entity = get_entity($guid);

if (!$entity instanceof \Elgg\Library\LibraryBook) {
	return elgg_error_response(elgg_echo('library:error:entity_not_found'));
}

if (!$entity->isBorrowed()) {
	return elgg_error_response(elgg_echo('library:error:not_borrowed'));
}

$borrower = $entity->getBorrower();
$user = elgg_get_logged_in_user_entity();

// Only the borrower or the owner can return the book
if ($borrower->guid !== $user->guid && $entity->owner_guid !== $user->guid) {
	return elgg_error_response(elgg_echo('library:error:cannot_return'));
}

// Delete the borrow annotation
$annotations = elgg_get_annotations([
	'guid' => $entity->guid,
	'annotation_name' => 'borrow',
	'limit' => false,
]);

foreach ($annotations as $annotation) {
	$annotation->delete();
}

// Notify the owner if the borrower is returning
if ($borrower->guid === $user->guid && $entity->owner_guid !== $user->guid) {
	notify_user($entity->owner_guid, $user->guid, elgg_echo('library:return:subject'), elgg_echo('library:return:message', [$user->getDisplayName(), $entity->getDisplayName()]));
}

return elgg_ok_response('', elgg_echo('library:return:success'));