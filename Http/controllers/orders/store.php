<?php

use Core\App;
use Core\Database;
use Core\Validator;
use Http\Forms\CreateOrderForm;


$db = App::resolve(Database::class);
// validation goes here
// dd($_POST);
$form = CreateOrderForm::validateAttributes(
    $attributes = [
        'notes' => $_POST["notes"],
        'room' => $_POST['room'],
        'productChosen' => $_POST['productChosen'],
        'userChosen' => $_SESSION['user']['role'] == 'admin' ? $_POST['user-id'] : "placeholder",
    ]
);
// create a new order record
//dd($db->query("select * from takes")->get());
date_default_timezone_set('Europe/Moscow');
$mysqlDateTime = date('Y-m-d H:i:s');
$db->query(
    "insert into `order` (orderstatus, date, roomnumber, type, made_by, notes) values (:OrderStatus, :Date, :RoomNumber, :type, :role, :notes);",
    [
        'OrderStatus' => "processing",
        'Date' => $mysqlDateTime,
        'RoomNumber' => $_POST['room'],
        'type' => $_POST['type'],
        'role' => $_SESSION['user']['role'],
        'notes' => $_POST['notes'],
    ]
);
// get the latest orderId based on time
$LatestOrder = $db->query("select * from `order` where date = :mysqlDateTime", [
    'mysqlDateTime' => $mysqlDateTime
])->get();
$orderid = $LatestOrder[0]['orderid'];
// update order status and make the choosen room taken
//$db->query("call update_order_status($orderid , 10);");
$db->query("update room r JOIN `order` o ON r.roomnumber = o.roomnumber SET r.status = 'taken' ;");
$orderQuantities = $_POST['quantities'];
// insert a record for each item in the order table
foreach ($orderQuantities as $product => $quantity) {
    if ($quantity != 0)
        $db->query("insert INTO takes (userid, productname, orderid, quantity) VALUES (:UserId, :ProductName, :OrderId, :Quantity)", [
            'UserId' => $_SESSION['user']['role'] == 'user' ? $_SESSION['user']['id'] : $_POST['user-id'],
            'ProductName' => $product,
            'OrderId' => $orderid,
            'Quantity' => $quantity,
        ]);
}

$params = [
    'orderid' => $orderid,
];
require_once __DIR__ . '/../my_orders/index.php';
