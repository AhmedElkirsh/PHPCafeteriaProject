<?php

use Core\App;
use Core\Database;
use Core\Session;

$db = App::resolve(Database::class);

$user = $db->query("select * from users where id= :id", ['id' => $_POST['id']])->find();

authorize(Session::get('user')['role'] === 'admin');

$db->query("delete from users where id=:id", [
    'id' => $_POST['id'],
]);

$users = $db->query("select * from users")->get();

view("/users/index.view.php", [
    'users' => $users,
]);