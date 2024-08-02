<?php


use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
$user = $db->query("select * from user where id= :id", ['id' => $_POST['id']])->find();

view("/users/edit.view.php", [
    'user' => $user
]);
