<?php

use Core\App;
use Core\Database;
use Core\Session;

$db = App::resolve(Database::class);
$users = $db->query('select * from users')->get();
$products = $db->query('select * from product')->get();
$rooms = $db->query('select * from room')->get();
$orders = $db->query('select * from `order`')->get();
//dd($db->query("SELECT orderid FROM takes WHERE userid = 9 ORDER BY orderid DESC  LIMIT 1")->get());
//dd($db->query("select * from product")->get());

//get last order items for specific user

$currentUserId = $_SESSION['user']['id'];
$latestOrder = $db->query("select * from takes where orderid = (SELECT orderid FROM takes WHERE userid = $currentUserId ORDER BY orderid DESC  LIMIT 1)")->get();
view('/orders/create.view.php', ['products' => $products, 'users' => $users, 'rooms' => $rooms, 'latestOrder' => $latestOrder, 'errors' => Session::get('errors')]);
