<?php

use Core\App;
use Core\Database;
use Core\Validator;
use Http\Forms\CreateOrderForm;

$db = App::resolve(Database::class);
// Optional validation
// $form = CreateOrderForm::validateAttributes([
//     'notes' => $_POST["notes"],
//     'room' => $_POST['room'],
//     'userChosen' => $_SESSION['user']['role'] == 'admin' ? $_POST['user-id'] : "placeholder",
// ]);

date_default_timezone_set('Europe/Moscow');
$mysqlDateTime = date('Y-m-d H:i:s');

// Create a new order record
$db->query(
    "INSERT INTO `order` (orderstatus, date, roomnumber, type, made_by, notes) VALUES (:OrderStatus, :Date, :RoomNumber, :type, :role, :notes);",
    [
        'OrderStatus' => "processing",
        'Date' => $mysqlDateTime,
        'RoomNumber' => $_POST['room'],
        'type' => $_POST['type'],
        'role' => $_SESSION['user']['role'],
        'notes' => $_POST['notes'],
    ]
);

// Get the latest orderId based on time
$LatestOrder = $db->query("
    SELECT * FROM `order`
    ORDER BY date DESC, orderid DESC
    LIMIT 1
")->get();

if (empty($LatestOrder)) {
    die("No orders found.");
}
$orderid = $LatestOrder[0]['orderid'];

// Update room status to 'taken'
$db->query("
    UPDATE room r
    JOIN `order` o ON r.roomnumber = o.roomnumber
    SET r.status = 'taken'
    WHERE o.orderid = :orderid
", [
    'orderid' => $orderid,
]);


// Handle product quantities
$orderQuantities = $_POST['quantities'];
// Insert records for each item in the 'takes' table
foreach ($orderQuantities as $product => $quantity) {
 
    $db->query("INSERT INTO takes (userid, productname, orderid, quantity) VALUES (:UserId, :ProductName, :OrderId, :Quantity)", [
        'UserId' => $_SESSION['user']['role'] == 'user' ? $_SESSION['user']['id'] : $_POST['user-id'],
        'ProductName' => $product,
        'OrderId' => $orderid,
        'Quantity' => $quantity,
    ]);

}

$params = [
    'orderid' => $orderid,
];

if ($_SESSION['user']['role']==='admin') {
    redirect('/manual_orders');
    die();
} else {
    redirect('/my_orders');
    die();
}
