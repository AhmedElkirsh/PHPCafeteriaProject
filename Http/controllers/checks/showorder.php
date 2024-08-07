<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
$orderid = $_POST['orderid'];

$order = $db->query("
    SELECT p.name AS productname, p.image AS productimage, p.price AS productprice, t.quantity AS quantity
    FROM `order` o
    JOIN takes t ON o.orderid = t.orderid
    JOIN product p ON t.productname = p.name
    WHERE o.orderid = :orderid
    GROUP BY t.userid, o.date, o.orderstatus
    ORDER BY o.date;
", [
    'orderid' => $orderid
])->get();
?>

<div class="w-full max-w-4xl p-4 bg-white rounded-md shadow-md my-7 ">
    <div class="overflow-x-auto">
        <div class="max-h-96 overflow-y-auto">
            <?php foreach ($order as $product) : ?>
                <div class="bg-white border border-gray-200 rounded-lg shadow-md p-4 mb-4 flex-none w-64">
                    <div class="flex items-center mb-2">
                        <img src="<?= '/serve_image_product.php?image=' . $product['productimage']?>" class="w-24 h-24 object-cover rounded-md mr-4">
                        <div class="flex-1">
                            <p class="text-lg font-semibold mb-1"><?= htmlspecialchars($product['productname']) ?></p>
                            <span class="block text-gray-700 mb-1"><?= htmlspecialchars($product['productprice']) . " EGP" ?></span>
                            <span class="block text-gray-500"><?= htmlspecialchars($product['quantity']) ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>