<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
$user_id = $_POST['id'];
$orders = $db->query("
    SELECT o.orderid, o.date AS order_date, SUM(t.quantity * p.price) AS total
    FROM `order` o
    JOIN takes t ON o.orderid = t.orderid
    JOIN product p ON t.productname = p.name
    WHERE t.userid = :user_id
    GROUP BY o.orderid, o.date
    ORDER BY o.date;
", [
    'user_id' => $user_id
])->get();
?>

<div class="w-full max-w-4xl p-4 bg-white rounded-md shadow-md h-full overflow-auto">
    <div class="h-full overflow-y-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50 sticky top-0">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order Date</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-right">Total Bill</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($orders as $order) : ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 flex items-center">
                            <?= htmlspecialchars($order['order_date'])?>
                            <button class="showOrderBtn text-accent-800 hover:text-accent-400 ml-2" data-orderid="<?= $order['orderid'] ?>">
                                <i class="fas fa-eye ml-8"></i>
                            </button>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right"><?= htmlspecialchars($order['total'])?> EGP</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
