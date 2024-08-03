<?php

use Core\App;
use Core\Database;
use Core\Session;

$db = App::resolve(Database::class);
$product = $db->query("select * from product where name= :name", ['name' => $_POST['name']])->find();

view("/products/edit.view.php", [
    'user' => $user,
    'errors' => Session::get('errors'),
]);