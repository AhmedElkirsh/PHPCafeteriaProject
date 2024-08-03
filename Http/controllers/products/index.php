<?php 

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
$products = $db->query("select * from product")->get();

view('/products/index.view.php',[
    'products'=>$products,
]);