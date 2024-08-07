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
    ORDER BY p.name; 
", [
    'orderid' => $orderid
])->get();
?>
<div  class="h-full mt-4 overflow-x-auto flex gap-5 items-center">
    <?php foreach ($order as $product) : ?>
        <div class="bg-white border border-gray-200 rounded-lg shadow-md p-2  w-48">
            <div class="flex items-center">
                <img src="<?= '/serve_image_product.php?image=' . $product['productimage']?>" class="w-20 h-20 object-cover rounded-md mr-2">
                <div class="flex-1">
                    <p class="text-sm font-semibold mb-1"><?= htmlspecialchars($product['productname']) ?></p>
                    <span class="block text-gray-700 mb-1 text-xs"><?= htmlspecialchars($product['productprice']) . " EGP" ?></span>
                    <span class="block text-gray-500 text-xs"><?= htmlspecialchars($product['quantity']) ?></span>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
