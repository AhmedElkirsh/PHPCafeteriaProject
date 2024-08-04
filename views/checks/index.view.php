<?php view('/partials/head.php'); ?>
<?php view('/partials/nav.php'); ?>

<main>
<div class="container mx-auto mt-5">
    <h2 class="text-2xl font-bold mb-4">User Orders</h2>
    
    
    <form method="POST" class="mb-4" >
        <div class="grid grid-cols-3 gap-4">
            <div>
                <input type="date" name="start_date" class="form-input mt-1 block w-full" placeholder="Start Date" value="<?php echo isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>" required>
            </div>
            <div>
                <input type="date" name="end_date" class="form-input mt-1 block w-full" placeholder="End Date" value="<?php echo isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>" required>
            <div>
                <input type="date" name="end_date" class="form-input mt-1 block w-full" placeholder="End Date" value="<?php echo isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>" required>
            </div>
            <div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Filter</button>
            <div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Filter</button>
            </div>
        </div>
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="action-col px-4 py-2 border">Action</th>
                    <th class="px-4 py-2 border">User Name</th>
                    <th class="px-4 py-2 border">Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                         
                $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : null;
                $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : null;
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="action-col px-4 py-2 border">Action</th>
                    <th class="px-4 py-2 border">User Name</th>
                    <th class="px-4 py-2 border">Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                         
                $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : null;
                $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : null;

                if ($startDate && $endDate) {
                    // Query 
                    $sql = "
                        SELECT u.id, u.name, o.id as order_id, o.date, p.name as product_name, p.price, p.image
                        FROM users u
                        JOIN takes t ON u.id = t.userid
                        JOIN product p ON t.productname = p.name
                        JOIN `order` o ON t.orderid = o.id
                        WHERE o.date BETWEEN '$startDate' AND '$endDate'
                        ORDER BY u.id, o.id
                    ";
                    $result = $conn->query($sql);
                if ($startDate && $endDate) {
                    // Query 
                    $sql = "
                        SELECT u.id, u.name, o.id as order_id, o.date, p.name as product_name, p.price, p.image
                        FROM users u
                        JOIN takes t ON u.id = t.userid
                        JOIN product p ON t.productname = p.name
                        JOIN `order` o ON t.orderid = o.id
                        WHERE o.date BETWEEN '$startDate' AND '$endDate'
                        ORDER BY u.id, o.id
                    ";
                    $result = $conn->query($sql);

                    $users = [];
                    while($row = $result->fetch_assoc()) {
                        $userId = $row['id'];
                        $orderId = $row['order_id'];
                        $users[$userId]['name'] = $row['name'];
                        $users[$userId]['orders'][$orderId]['date'] = $row['date'];
                        $users[$userId]['orders'][$orderId]['products'][] = [
                            'name' => $row['product_name'], 
                            'price' => $row['price'],
                            'image' => $row['image']
                        ];
                    }
                    $users = [];
                    while($row = $result->fetch_assoc()) {
                        $userId = $row['id'];
                        $orderId = $row['order_id'];
                        $users[$userId]['name'] = $row['name'];
                        $users[$userId]['orders'][$orderId]['date'] = $row['date'];
                        $users[$userId]['orders'][$orderId]['products'][] = [
                            'name' => $row['product_name'], 
                            'price' => $row['price'],
                            'image' => $row['image']
                        ];
                    }

                    foreach ($users as $userId => $user) {
                        $totalPrice = 0;
                        foreach ($user['orders'] as $order) {
                            foreach ($order['products'] as $product) {
                                $totalPrice += $product['price'];
                            }
                        }
                        echo "<tr data-user-id='{$userId}'>";
                        echo "<td class='px-4 py-2 border'><button class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded toggle-details'>+</button></td>";
                        echo "<td class='px-4 py-2 border'>{$user['name']}</td>";
                        echo "<td class='px-4 py-2 border'>\${$totalPrice}</td>";
                        echo "</tr>";
                    foreach ($users as $userId => $user) {
                        $totalPrice = 0;
                        foreach ($user['orders'] as $order) {
                            foreach ($order['products'] as $product) {
                                $totalPrice += $product['price'];
                            }
                        }
                        echo "<tr data-user-id='{$userId}'>";
                        echo "<td class='px-4 py-2 border'><button class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded toggle-details'>+</button></td>";
                        echo "<td class='px-4 py-2 border'>{$user['name']}</td>";
                        echo "<td class='px-4 py-2 border'>\${$totalPrice}</td>";
                        echo "</tr>";

                        foreach ($user['orders'] as $orderId => $order) {
                            $orderPrice = array_sum(array_column($order['products'], 'price'));
                            echo "<tr class='order-details' data-user-id='{$userId}' style='display: none;'>";
                            echo "<td colspan='3' class='p-0'>";
                            echo "<table class='min-w-full bg-gray-100'>";
                            echo "<thead><tr><th class='px-4 py-2 border'>Order Date</th><th class='px-4 py-2 border'>Total Price</th><th class='px-4 py-2 border'>Action</th></tr></thead><tbody>";
                            echo "<tr data-order-id='{$orderId}'>";
                            echo "<td class='px-4 py-2 border'>{$order['date']}</td>";
                            echo "<td class='px-4 py-2 border'>\${$orderPrice}</td>";
                            echo "<td class='px-4 py-2 border'><button class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded toggle-products'>+</button></td>";
                            echo "</tr>";
                        foreach ($user['orders'] as $orderId => $order) {
                            $orderPrice = array_sum(array_column($order['products'], 'price'));
                            echo "<tr class='order-details' data-user-id='{$userId}' style='display: none;'>";
                            echo "<td colspan='3' class='p-0'>";
                            echo "<table class='min-w-full bg-gray-100'>";
                            echo "<thead><tr><th class='px-4 py-2 border'>Order Date</th><th class='px-4 py-2 border'>Total Price</th><th class='px-4 py-2 border'>Action</th></tr></thead><tbody>";
                            echo "<tr data-order-id='{$orderId}'>";
                            echo "<td class='px-4 py-2 border'>{$order['date']}</td>";
                            echo "<td class='px-4 py-2 border'>\${$orderPrice}</td>";
                            echo "<td class='px-4 py-2 border'><button class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded toggle-products'>+</button></td>";
                            echo "</tr>";

                            echo "<tr class='product-details' data-order-id='{$orderId}' style='display: none;'>";
                            echo "<td colspan='3' class='p-0'>";
                            echo "<table class='min-w-full bg-gray-100'>";
                            echo "<thead><tr><th class='px-4 py-2 border'>Product Image</th><th class='px-4 py-2 border'>Price</th></tr></thead><tbody>";
                            echo "<tr class='product-details' data-order-id='{$orderId}' style='display: none;'>";
                            echo "<td colspan='3' class='p-0'>";
                            echo "<table class='min-w-full bg-gray-100'>";
                            echo "<thead><tr><th class='px-4 py-2 border'>Product Image</th><th class='px-4 py-2 border'>Price</th></tr></thead><tbody>";

                            foreach ($order['products'] as $product) {
                                echo "<tr>";
                                echo "<td class='px-4 py-2 border'><img src='{$product['image']}' class='product-image' alt='{$product['name']}'></td>";
                                echo "<td class='px-4 py-2 border'>\${$product['price']}</td>";
                                echo "</tr>";
                            }
                            foreach ($order['products'] as $product) {
                                echo "<tr>";
                                echo "<td class='px-4 py-2 border'><img src='{$product['image']}' class='product-image' alt='{$product['name']}'></td>";
                                echo "<td class='px-4 py-2 border'>\${$product['price']}</td>";
                                echo "</tr>";
                            }

                            echo "</tbody></table>";
                            echo "</td></tr>";
                            echo "</tbody></table>";
                            echo "</td></tr>";

                            echo "</tbody></table>";
                            echo "</td></tr>";
                        }
                    }
                } else {
                    echo "<tr><td colspan='3' class='px-4 py-2 border'>Please select a date range.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
</main>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function(){
        $('.toggle-details').click(function(){
            var userId = $(this).closest('tr').data('user-id');
            $(this).text($(this).text() === '+' ? '-' : '+');
            $('tr.order-details[data-user-id="' + userId + '"]').toggle();
        });

        $('.toggle-products').click(function(){
            var orderId = $(this).closest('tr').data('order-id');
            $(this).text($(this).text() === '+' ? '-' : '+');
            $('tr.product-details[data-order-id="' + orderId + '"]').toggle();
        });
    });
</script>
<?php view('/partials/foot.php') ?>