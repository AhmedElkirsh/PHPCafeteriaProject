<?php

use Core\App;
use Core\Database;
use Core\Session;
$db = App::resolve(Database::class);
$categories = $db->query('select * from category')->get();
view("/products/create.view.php",[
    'errors' => Session::get('errors'),
    'categories' => $categories,
]);