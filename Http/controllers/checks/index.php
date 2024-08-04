<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
$users = $db->query('SELECT u.name, SUM(p.price) AS total_price
                        FROM `users` u
                        JOIN `takes` t ON u.id = t.userid
                        JOIN `product` p ON t.productname = p.name
                        GROUP BY u.id, u.name ')->get();
view('/checks/index.view.php',[
    // 'page' => 'checks',
    // 'users' => $users,
]);


