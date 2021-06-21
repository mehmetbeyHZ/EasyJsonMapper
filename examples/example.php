<?php

use EJM\MainMapper;

require '../vendor/autoload.php';

/**
 * Class User
 * @method string getUsername()
 * @method \Book[] getBooks()
 * @method boolean hasBooks()
 */
class User extends MainMapper
{
    const MAP = [
        'username' => 'string',
        'name' => 'string',
        'books' => Book::class.'[]'
    ];
}

/**
 * Class Book
 * @method getName()
 * @method boolean hasName()
 */
class Book extends MainMapper{
    const MAP = [
        'name' => 'string'
    ];
}

$u = new User([
    "username" => 'mehmet',
    'name' => 'Mehmet',
    'has_username' => 'ok',
    'books' => [
        [
            'name' => 'Book1'
        ],
        [
            'name' => 'Book2'
        ]
    ]
]);



var_dump($u->getBooks()[0]->hasName() ? "yes" : "no");
