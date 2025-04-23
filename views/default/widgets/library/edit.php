<?php
/**
 * Library widget settings
 */

$widget = elgg_extract('entity', $vars);

echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('library:widget:edit:num_display'),
	'name' => 'params[num_display]',
	'value' => $widget->num_display ?: 4,
	'options' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
]);