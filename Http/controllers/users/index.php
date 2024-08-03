<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
$users = $db->query("select * from users where role = 'user'")->get();

view("/users/index.view.php", [
    'users' => $users,
]);