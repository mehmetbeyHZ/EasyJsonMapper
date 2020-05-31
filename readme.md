Easy JSON Mapper.

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
