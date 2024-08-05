<?php

use Core\App;
use Core\Database;

$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

$db = App::resolve(Database::class);
$users = $db->query("
        SELECT 
        users.name as name, 
        SUM(product.price) AS total
        FROM users
        JOIN takes ON users.id = takes.userid
        JOIN product ON takes.productname = product.name
        JOIN `order` ON takes.orderid = order.orderid
        WHERE order.date BETWEEN '$start_date' AND '$end_date'
        GROUP BY users.name 
        ")->get();

view('/checks/index.view.php',[
    'users' => $users,
]);