<?php

use Core\App;
use Core\Database;
use Core\Session;

$db = App::resolve(Database::class);

$users = $db->query('select * from users')->get();
$products = $db->query('select * from product')->get();
$rooms = $db->query('select * from room')->get();
$orders = $db->query('select * from `order`')->get();
$categories = $db->query('select * from category')->get();

$currentUserId = $_SESSION['user']['id'];
$latestOrder = $db->query("
    select * from takes 
    where orderid = (SELECT orderid FROM takes 
                    WHERE userid = :userid 
                    ORDER BY orderid 
                    DESC LIMIT 1)
    ",[
        'userid' => $currentUserId
])->get();

view('/orders/create.view.php', [
    'products' => $products, 
    'users' => $users, 
    'rooms' => $rooms, 
    'latestOrder' => $latestOrder ?? '', 
    'errors' => Session::get('errors'),
    'categories' => $categories,
]);