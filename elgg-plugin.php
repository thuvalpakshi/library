<?php

use Elgg\Library\Bootstrap;

return [
    'bootstrap' => Bootstrap::class,
    'entities' => [
        [
            'type' => 'object',
            'subtype' => 'library_book',
            'class' => '\Elgg\Library\LibraryBook',
            'searchable' => true,
        ],
    ],
    'actions' => [
        'library/save' => [
            'access' => 'logged_in',
        ],
        'library/delete' => [
            'access' => 'logged_in',
        ],
        'library/request_borrow' => [
            'access' => 'logged_in',
        ],
        'library/approve_borrow' => [
            'access' => 'logged_in',
        ],
        'library/return' => [
            'access' => 'logged_in',
        ],
    ],
    'routes' => [
        'default:object:library_book' => [
            'path' => '/library/view/{guid}/{title?}',
            'resource' => 'library/view',
        ],
        'collection:object:library_book:all' => [
            'path' => '/library/all',
            'resource' => 'library/all',
        ],
        'collection:object:library_book:owner' => [
            'path' => '/library/owner/{username}',
            'resource' => 'library/owner',
        ],
        'add:object:library_book' => [
            'path' => '/library/add/{guid?}',
            'resource' => 'library/add',
        ],
        'edit:object:library_book' => [
            'path' => '/library/edit/{guid}',
            'resource' => 'library/edit',
        ],
        'library:requests' => [
            'path' => '/library/requests',
            'resource' => 'library/requests',
            'middleware' => [
                \Elgg\Router\Middleware\Gatekeeper::class,
            ],
        ],
    ],
    'widgets' => [
        'library' => [
            'context' => ['profile', 'dashboard'],
        ],
    ],
];
