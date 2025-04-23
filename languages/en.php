<?php
/**
 * Translation file
 */

return [
	'library' => 'Library',
	'library:owner' => '%s\'s library',
	'library:add' => 'Add book',
	'library:edit' => 'Edit book',
	'library:view' => 'View book',
	'library:all' => 'All site books',
	'library:requests' => 'Book requests',
	
	'library:title' => 'Title',
	'library:description' => 'Description',
	'library:isbn' => 'ISBN',
	'library:author' => 'Author',
	'library:publisher' => 'Publisher',
	'library:year' => 'Year',
	
	'library:status' => 'Status',
	'library:status:available' => 'Available',
	'library:status:borrowed' => 'Borrowed by %s',
	'library:status:requested' => 'Requested by %s',
	
	'library:request' => 'Request',
	'library:approve' => 'Approve',
	'library:return' => 'Return',
	
	'library:widget' => 'Library books',
	'library:widget:description' => 'Show your library books',
	'library:widget:edit:num_display' => 'Number of books to display',
	
	'library:save:success' => 'The book was successfully saved',
	'library:delete:success' => 'The book was successfully deleted',
	'library:request:success' => 'Your request has been sent to the book owner',
	'library:approved:success' => 'The request has been approved',
	'library:return:success' => 'The book was returned to the library',
	
	'library:error:missing:title' => 'Please enter a title for the book',
	'library:error:entity_not_found' => 'Book not found',
	'library:error:cannot_edit_entity' => 'You do not have permission to edit this book',
	'library:error:cannot_save' => 'Unable to save the book',
	'library:error:cannot_delete' => 'Unable to delete the book',
	'library:error:owner_cannot_borrow' => 'You cannot borrow your own book',
	'library:error:already_borrowed' => 'This book is already borrowed or requested',
	'library:error:cannot_request' => 'Unable to request this book',
	'library:error:not_owner' => 'You are not the owner of this book',
	'library:error:no_request' => 'There is no request to borrow this book',
	'library:error:requester_not_found' => 'The user who requested the book could not be found',
	'library:error:cannot_approve' => 'Unable to approve the request',
	'library:error:not_borrowed' => 'This book is not currently borrowed',
	'library:error:cannot_return' => 'You do not have permission to return this book',
	
	'library:request:subject' => 'Book borrowing request',
	'library:request:message' => '%s has requested to borrow your book "%s"',
	'library:approved:subject' => 'Book request approved',
	'library:approved:message' => 'Your request to borrow "%s" has been approved',
	'library:return:subject' => 'Book returned',
	'library:return:message' => '%s has returned your book "%s"',
];