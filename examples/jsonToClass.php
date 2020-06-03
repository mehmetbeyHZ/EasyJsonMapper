<?php

require '../vendor/autoload.php';
header("Content-Type: text/plain");


$jtc = new \EJM\JsonToClass(json_encode([
    'username' => "mehmet",
    "age"   => 40,
    "full_name" => "karakas",
    "mails" => [
        [
            "email" => "mehmet@gmail.com",
            "subject" => "test"
        ],
        [
            "email" => "mehmet@gmail.com",
            "subject" => "test"
        ],
        [
            "email" => "mehmet@gmail.com",
            "subject" => "test"
        ]
    ]
]), "Users");

foreach ($jtc->createClassBody() as $cs)
{
    print_r($cs);
    echo "\n\n";
}