<?php

use EJM\MainMapper;

require '../vendor/autoload.php';

$data = json_decode(file_get_contents('data.json'), true);

class User extends MainMapper
{
    const MAP = [
        'username' => 'string',
        'full_name' => 'string',
        'books' => 'Books[]',
        'social' => 'Social[]',
        'mail' => 'Mail'
    ];
}

class Mail extends MainMapper
{
    const MAP = [
        'contact' => 'string',
    ];
}

class Books extends MainMapper
{
    const MAP = [
        'book_name' => 'string',
        'writer' => 'string'
    ];
}

class Social extends MainMapper
{
    const MAP = [
        'social_media' => 'string',
        'link' => 'string'
    ];
}

$user = new User($data);
//print_r($user);

print_r($user->getUsername() . "\n");
print_r($user->getFullName() . "\n");
print_r($user->getMail()->getContact());

echo "\n\nBOOKS:\n";
foreach ($user->getBooks() as $book) {
    print_r($book->getBookName() . ":" . $book->getWriter() . "\n");
}

echo "\n\nSocial:\n";
foreach ($user->getSocial() as $social) {
    print_r($social->getSocialMedia() . ":" . $social->getLink() . "\n");
}

