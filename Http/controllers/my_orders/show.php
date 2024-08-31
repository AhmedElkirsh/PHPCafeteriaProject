<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
$orderid = $_POST['orderid'];
$user_id = $_SESSION['user']['id']; // Or set this to the specific user ID you need

$takes = $db->query("
    SELECT 
        t.userid, 
        t.productname, 
        t.orderid, 
        t.quantity, 
        p.price,
        p.image
    FROM takes t
    JOIN product p ON t.productname = p.name
    WHERE t.orderid = :orderid
", [
    'orderid' => $orderid,
])->get();



$orders = $db->query("
    SELECT o.orderid, t.userid AS user_id, o.date AS order_date, o.orderstatus AS status, SUM(t.quantity * p.price) AS total
    FROM `order` o
    JOIN takes t ON o.orderid = t.orderid
    JOIN product p ON t.productname = p.name
    WHERE t.userid = :user_id
    GROUP BY t.userid, o.date, o.orderstatus
    ORDER BY o.date;
", [
    'user_id' => $user_id
])->get();

view('/my_orders/show.view.php',[
    'takes' => $takes,
    'orders' => $orders,
]);