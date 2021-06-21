<?php

use EJM\MainMapper;

require '../vendor/autoload.php';

/**
 * Class User
 * @method string getUsername()
 * @method \Book[] getBooks()
 */
class User extends MainMapper
{
    const MAP = [
        'username' => 'string',
        'name' => 'string',
        'books' => Book::class.'[]'
    ];
}

class Book extends MainMapper{
    const MAP = [];
}

$u = new User([
    "username" => 'mehmet',
    'name' => 'Mehmet',
    'has_username' => 'ok',
    'books' => [ 'Book1','Book2']
]);
