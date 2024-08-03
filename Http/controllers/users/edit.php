<?php

use Core\App;
use Core\Database;
use Core\Session;

$db = App::resolve(Database::class);
$user = $db->query("select * from users where id= :id", ['id' => $_POST['id']])->find();

view("/users/edit.view.php", [
    'user' => $user,
    'errors' => Session::get('errors'),
]);