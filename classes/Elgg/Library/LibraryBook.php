<?php

namespace Elgg\Library;

/**
 * Library book entity
 *
 * @property string $isbn      ISBN number
 * @property string $author    Book author
 * @property string $publisher Book publisher
 * @property int    $year      Year published
 */
class LibraryBook extends \ElggObject {
	
	/**
	 * {@inheritdoc}
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		
		$this->attributes['subtype'] = 'library_book';
	}
	
	/**
	 * Is the book borrowed?
	 *
	 * @return bool
	 */
	public function isBorrowed() {
		$ia = elgg_set_ignore_access(true);
		$result = elgg_get_annotations([
			'guid' => $this->guid,
			'annotation_name' => 'borrow',
			'limit' => 1,
		]);
		elgg_set_ignore_access($ia);
		
		return !empty($result);
	}
	
	/**
	 * Is there a request to borrow this book?
	 *
	 * @return bool
	 */
	public function hasRequest() {
		$ia = elgg_set_ignore_access(true);
		$result = elgg_get_annotations([
			'guid' => $this->guid,
			'annotation_name' => 'request',
			'limit' => 1,
		]);
		elgg_set_ignore_access($ia);
		
		return !empty($result);
	}
	
	/**
	 * Get the user who borrowed this book
	 *
	 * @return \ElggUser|null
	 */
	public function getBorrower() {
		$ia = elgg_set_ignore_access(true);
		$annotation = elgg_get_annotations([
			'guid' => $this->guid,
			'annotation_name' => 'borrow',
			'limit' => 1,
		]);
		elgg_set_ignore_access($ia);
		
		if (empty($annotation)) {
			return null;
		}
		
		$user = get_user($annotation[0]->owner_guid);
		if (!$user instanceof \ElggUser) {
			return null;
		}
		
		return $user;
	}
	
	/**
	 * Get the user who requested to borrow this book
	 *
	 * @return \ElggUser|null
	 */
	public function getRequester() {
		$ia = elgg_set_ignore_access(true);
		$annotation = elgg_get_annotations([
			'guid' => $this->guid,
			'annotation_name' => 'request',
			'limit' => 1,
		]);
		elgg_set_ignore_access($ia);
		
		if (empty($annotation)) {
			return null;
		}
		
		$user = get_user($annotation[0]->owner_guid);
		if (!$user instanceof \ElggUser) {
			return null;
		}
		
		return $user;
	}
}