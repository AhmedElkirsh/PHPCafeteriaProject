<?php

use Core\App;
use Core\Database;
$orderid = $_POST['orderid'];
$db = App::resolve(Database::class);
$order = $db->query("delete from `order` where orderid = :orderid",[
    'orderid' => $orderid,
]);

redirect('/my_orders');