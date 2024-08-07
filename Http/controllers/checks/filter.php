<?php

use Core\App;
use Core\Database;

$start_date = $_POST['start_date'] ?? '2024-07-01';
$end_date = $_POST['end_date'] ?? '2100-07-01';

$db = App::resolve(Database::class);
$users = $db->query("
        SELECT 
        users.id as id,
        users.name as name, 
        SUM(product.price) AS total
        FROM users
        JOIN takes ON users.id = takes.userid
        JOIN product ON takes.productname = product.name
        JOIN `order` ON takes.orderid = `order`.orderid
        WHERE `order`.date BETWEEN :start_date AND :end_date
        GROUP BY users.name
        ", [
            'start_date' => $start_date,
            'end_date' => $end_date
        ])->get();

foreach ($users as $user) {
    echo "<tr>
            <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500 flex items-center'>
                " . htmlspecialchars($user['name']) . "
                <button class='showOrdersBtn text-blue-500 hover:text-blue-700 ml-2' data-user-id='" . $user['id'] . "'>
                    <i class='fas fa-plus ml-8'></i>
                </button>
            </td>
            <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>" . htmlspecialchars($user['total']) . " EGP</td>
        </tr>";
}