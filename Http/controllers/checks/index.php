<?php

use Core\App;
use Core\Database;

$start_date = $_POST['start_date'] ?? '2024-07-01';
$end_date = $_POST['end_date'] ?? '2100-07-01';

$db = App::resolve(Database::class);
$users = $db->query("
        SELECT 
        users.id AS id,
        users.name AS name, 
        SUM(product.price) AS total
        FROM users
        JOIN takes ON users.id = takes.userid
        JOIN product ON takes.productname = product.name
        JOIN `order` ON takes.orderid = `order`.orderid
        WHERE `order`.date BETWEEN :start_date AND :end_date
        GROUP BY users.id, users.name
        ", [
            'start_date' => $start_date,
            'end_date' => $end_date
        ])->get();

$allusers = $db->query("select * from users")->get();

view('/checks/index.view.php', [
    'users' => $users,
    'allusers' => $allusers,
]);