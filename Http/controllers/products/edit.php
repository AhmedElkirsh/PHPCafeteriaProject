<?php

use Core\App;
use Core\Database;
use Core\Session;

$db = App::resolve(Database::class);
$product = $db->query("select * from product where name= :name", ['name' => $_POST['name']])->find();

$categories = $db->query('select * from category')->get();

view("/products/edit.view.php", [
    'product' => $product,
    'categories' => $categories,
    'errors' => Session::get('errors'),
]);

