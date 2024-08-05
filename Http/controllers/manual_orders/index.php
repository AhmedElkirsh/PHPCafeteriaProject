<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$orders = $db->query("
    SELECT users.name, `order`.date, `order`.type, `order`.roomnumber, product.name AS product_name, product.image, product.price, takes.quantity
    FROM users
    JOIN takes ON users.id = takes.userid
    JOIN product ON takes.productname = product.name
    JOIN `order` ON takes.orderid = `order`.orderid
    WHERE `order`.made_by = 'admin'
    ORDER BY `order`.date DESC
")->get();

view('/manual_orders/index.view.php',[
    'orders' => $orders,
]);
