<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
$users = $db->query('select * from users')->get();
view('/checks/index.view.php',[
    'page' => 'checks',
    'users' => $users,
]);
