<?php
/**
 * Edit book form
 */

$entity = elgg_extract('entity', $vars);

$title_label = elgg_echo('library:title');
$title_input = elgg_view('input/text', [
	'name' => 'title',
	'value' => $entity ? $entity->getDisplayName() : '',
	'required' => true,
]);

$description_label = elgg_echo('library:description');
$description_input = elgg_view('input/longtext', [
	'name' => 'description',
	'value' => $entity ? $entity->description : '',
]);

$isbn_label = elgg_echo('library:isbn');
$isbn_input = elgg_view('input/text', [
	'name' => 'isbn',
	'value' => $entity ? $entity->isbn : '',
]);

$author_label = elgg_echo('library:author');
$author_input = elgg_view('input/text', [
	'name' => 'author',
	'value' => $entity ? $entity->author : '',
]);

$publisher_label = elgg_echo('library:publisher');
$publisher_input = elgg_view('input/text', [
	'name' => 'publisher',
	'value' => $entity ? $entity->publisher : '',
]);

$year_label = elgg_echo('library:year');
$year_input = elgg_view('input/number', [
	'name' => 'year',
	'value' => $entity ? $entity->year : '',
	'min' => 0,
	'max' => date('Y'),
]);

$tag_label = elgg_echo('tags');
$tag_input = elgg_view('input/tags', [
	'name' => 'tags',
	'value' => $entity ? $entity->tags : '',
]);

$access_label = elgg_echo('access');
$access_input = elgg_view('input/access', [
	'name' => 'access_id',
	'value' => $entity ? $entity->access_id : ACCESS_DEFAULT,
	'entity' => $entity,
	'entity_type' => 'object',
	'entity_subtype' => 'library_book',
]);

$guid_input = elgg_view('input/hidden', [
	'name' => 'guid',
	'value' => $entity ? $entity->guid : 0,
]);

$container_guid_input = elgg_view('input/hidden', [
	'name' => 'container_guid',
	'value' => elgg_extract('container_guid', $vars, elgg_get_logged_in_user_guid()),
]);

$submit_value = $entity ? elgg_echo('save') : elgg_echo('library:add');
$submit_input = elgg_view('input/submit', [
	'value' => $submit_value,
]);

echo <<<HTML
<div>
	<label for="title">$title_label</label>
	$title_input
</div>

<div>
	<label for="description">$description_label</label>
	$description_input
</div>

<div>
	<label for="isbn">$isbn_label</label>
	$isbn_input
</div>

<div>
	<label for="author">$author_label</label>
	$author_input
</div>

<div>
	<label for="publisher">$publisher_label</label>
	$publisher_input
</div>

<div>
	<label for="year">$year_label</label>
	$year_input
</div>

<div>
	<label for="tags">$tag_label</label>
	$tag_input
</div>

<div>
	<label for="access_id">$access_label</label>
	$access_input
</div>

$guid_input
$container_guid_input

<div class="elgg-foot">
	$submit_input
</div>
HTML;