<?php

use Core\App;
use Core\Database;

$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

$db = App::resolve(Database::class);
$users = $db->query("
        SELECT u.id, u.name, o.orderid as order_id, o.date, p.name as product_name, p.price, p.image
        FROM users u
        JOIN takes t ON u.id = t.userid
        JOIN product p ON t.productname = p.name
        JOIN `order` o ON t.orderid = o.orderid
        WHERE o.date BETWEEN '$start_date' AND '$end_date'
        ORDER BY u.id, o.orderid
        ")->get();

view('/checks/index.view.php',[
    'users' => $users,
]);
