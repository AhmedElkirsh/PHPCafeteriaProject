<?php

use Core\App;
use Core\Database;
use Core\Session;

$db = App::resolve(Database::class);

$product = $db->query("select * from product where name= :name", ['name' => $_POST['name']])->find();

authorize(Session::get('user')['role'] === 'admin');

$db->query("delete from product where name=:name", [
    'name' => $_POST['name'],
]);

$products = $db->query("select * from product")->get();

view("/products/index.view.php", [
    'products' => $products,
]);