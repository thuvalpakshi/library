<?php
/**
 * View for library book objects
 *
 * @uses $vars['entity'] The book entity
 */

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \Elgg\Library\LibraryBook) {
	return;
}

$owner = $entity->getOwnerEntity();

$vars['icon'] = elgg_view_entity_icon($owner, 'tiny');

$vars['imprint'] = [
	[
		'icon_name' => 'user',
		'content' => elgg_view('output/url', [
			'href' => $owner->getURL(),
			'text' => $owner->getDisplayName(),
		]),
	],
	[
		'icon_name' => 'calendar-alt',
		'content' => elgg_view('output/date', [
			'value' => $entity->time_created,
		]),
	],
];

if ($entity->isbn) {
	$vars['imprint'][] = [
		'icon_name' => 'barcode',
		'content' => elgg_format_element('span', [], elgg_view('output/text', [
			'value' => $entity->isbn,
		])),
	];
}

if ($entity->author) {
	$vars['imprint'][] = [
		'icon_name' => 'user-edit',
		'content' => elgg_format_element('span', [], elgg_view('output/text', [
			'value' => $entity->author,
		])),
	];
}

// book status
if ($entity->isBorrowed()) {
	$borrower = $entity->getBorrower();
	if ($borrower) {
		$vars['imprint'][] = [
			'icon_name' => 'book-reader',
			'content' => elgg_echo('library:status:borrowed', [
				elgg_view('output/url', [
					'text' => $borrower->getDisplayName(),
					'href' => $borrower->getURL(),
				]),
			]),
		];
	}
} elseif ($entity->hasRequest()) {
	$requester = $entity->getRequester();
	if ($requester) {
		$vars['imprint'][] = [
			'icon_name' => 'clock',
			'content' => elgg_echo('library:status:requested', [
				elgg_view('output/url', [
					'text' => $requester->getDisplayName(),
					'href' => $requester->getURL(),
				]),
			]),
		];
	}
} else {
	$vars['imprint'][] = [
		'icon_name' => 'check',
		'content' => elgg_echo('library:status:available'),
	];
}

if ($entity->canEdit()) {
	$vars['menu'] = elgg_view_menu('entity', [
		'entity' => $entity,
		'handler' => 'library',
		'class' => 'elgg-menu-hz',
	]);
}

// book details
$extras = '';
if (!empty($entity->publisher)) {
	$extras .= elgg_format_element('div', ['class' => 'elgg-subtext'], elgg_echo('library:publisher') . ': ' . $entity->publisher);
}
if (!empty($entity->year)) {
	$extras .= elgg_format_element('div', ['class' => 'elgg-subtext'], elgg_echo('library:year') . ': ' . $entity->year);
}

if ($vars['full_view']) {
	$body = '';
	
	$body .= elgg_view('output/longtext', [
		'value' => $entity->description,
	]);
	
	$body .= $extras;
	
	// add borrow/return actions
	$user = elgg_get_logged_in_user_entity();
	if ($user) {
		$actions = '';
		
		if ($entity->owner_guid === $user->guid) {
			if ($entity->hasRequest()) {
				$requester = $entity->getRequester();
				if ($requester) {
					$actions .= elgg_view('output/url', [
						'text' => elgg_echo('library:approve'),
						'href' => elgg_generate_action_url('library/approve_borrow', [
							'guid' => $entity->guid,
						]),
						'class' => 'elgg-button elgg-button-action',
						'confirm' => true,
					]);
				}
			}
		} elseif ($entity->isBorrowed()) {
			$borrower = $entity->getBorrower();
			if ($borrower && $borrower->guid === $user->guid) {
				$actions .= elgg_view('output/url', [
					'text' => elgg_echo('library:return'),
					'href' => elgg_generate_action_url('library/return', [
						'guid' => $entity->guid,
					]),
					'class' => 'elgg-button elgg-button-action',
					'confirm' => true,
				]);
			}
		} elseif (!$entity->hasRequest()) {
			$actions .= elgg_view('output/url', [
				'text' => elgg_echo('library:request'),
				'href' => elgg_generate_action_url('library/request_borrow', [
					'guid' => $entity->guid,
				]),
				'class' => 'elgg-button elgg-button-action',
				'confirm' => true,
			]);
		}
		
		if (!empty($actions)) {
			$body .= elgg_format_element('div', ['class' => 'elgg-listing-full-responses'], $actions);
		}
	}
	
	$params = [
		'entity' => $entity,
		'title' => false,
		'body' => $body,
		'show_summary' => true,
	];
	$params = $params + $vars;
	
	echo elgg_view('object/elements/full', $params);
} else {
	// brief view
	$params = [
		'entity' => $entity,
		'content' => elgg_get_excerpt($entity->description) . $extras,
		'show_summary' => true,
	];
	$params = $params + $vars;
	
	echo elgg_view('object/elements/summary', $params);
}