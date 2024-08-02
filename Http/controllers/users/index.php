<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
$users = $db->query("select * from user")->get();

view("/users/index.view.php", [
    'users' => $users,
]);
