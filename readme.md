Easy JSON Mapper.

Install 
```
composer require mehmetbeyhz/easy-json-mapper:dev-master
```

```php
<?php 

class User extends MainMapper{ 
    const MAP = [
       'user_id'  => 'int',
       'username'  => 'string',
       'full_name' => 'string',
       'friends'   => 'Friends[]'
    ];   
}

class Friends extends MainMapper{ 
    const MAP = [
       'friend_id'   => 'int',
       'friend_name' => 'string',
       'friend_mail' => 'string'
    ]; 
}

$user = new User([
'user_id' => 1,
'username' => 'mt.ks',
'full_name' => 'Mehmet',
'friends' => [
  [
    'friend_id' => 1,
    'friend_name' => 'Abdulkadir',
    'friend_mail' => 'abdlkdr@gmail.com'
  ],
  [
    'friend_id' => 2,
    'friend_name' => 'Ali',
    'friend_mail' => 'ali@gmail.com'
  ]
]
]);

echo $user->getUserId();
echo $user->getUsername();
echo $user->getFullName();

foreach($user->getFriends() as $friend)
{
    echo $friend->getFriendId();
    echo $friend->getFriendName();
    echo $friend->getFriendMail();
}
```

## Json To PHP Class (Auto)
```php
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

```
#### Response

![alt text](https://i.ibb.co/jJkJ2Pn/Screenshot-from-2020-06-03-21-52-46.png " Json To Php")
