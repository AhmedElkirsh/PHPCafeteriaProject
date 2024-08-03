<?php view('/partials/head.php'); ?>
<?php view('/partials/nav.php'); ?>
<main>
<?php include 'Database.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Orders</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .action-col {
            width: 1%;
            white-space: nowrap;
        }
        .table-sm th, .table-sm td {
            padding: 0.3rem;
        }
        .small-table {
            font-size: 0.8rem;
        }
        .product-image {
            width: 50px; 
            height: auto;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2>User Orders</h2>
    

    <form method="get" class="mb-4">
        <div class="form-row">
            <div class="col">
                <input type="date" name="start_date" class="form-control" placeholder="Start Date" value="<?php echo isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>" required>
            </div>
            <div class="col">
                <input type="date" name="end_date" class="form-control" placeholder="End Date" value="<?php echo isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>" required>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered table-sm small-table">
        <thead>
            <tr>
                <th class="action-col">Action</th>
                <th>User Name</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
            
            $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : null;
            $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : null;

            if ($startDate && $endDate) {
                // Query that get data from Tables 
                $sql = "
                    SELECT u.id, u.name, o.orderid as order_id, o.date, p.name as product_name, p.price, p.image
                    FROM users u
                    JOIN takes t ON u.id = t.userid
                    JOIN product p ON t.productname = p.name
                    JOIN `order` o ON t.orderid = o.orderid
                    WHERE o.date BETWEEN '$startDate' AND '$endDate'
                    ORDER BY u.id, o.orderid
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

                foreach ($users as $userId => $user) {
                    $totalPrice = 0;
                    foreach ($user['orders'] as $order) {
                        foreach ($order['products'] as $product) {
                            $totalPrice += $product['price'];
                        }
                    }
                    echo "<tr data-user-id='{$userId}'>";
                    echo "<td><button class='btn btn-primary btn-sm toggle-details'>+</button></td>";
                    echo "<td>{$user['name']}</td>";
                    echo "<td>\${$totalPrice}</td>";
                    echo "</tr>";

                    foreach ($user['orders'] as $orderId => $order) {
                        $orderPrice = array_sum(array_column($order['products'], 'price'));
                        echo "<tr class='order-details' data-user-id='{$userId}' style='display: none;'>";
                        echo "<td colspan='3'>";
                        echo "<table class='table table-bordered table-sm small-table'>";
                        echo "<thead><tr><th>Order Date</th><th>Total Price</th><th>Action</th></tr></thead><tbody>";
                        echo "<tr data-order-id='{$orderId}'>";
                        echo "<td>{$order['date']}</td>";
                        echo "<td>\${$orderPrice}</td>";
                        echo "<td><button class='btn btn-primary btn-sm toggle-products'>+</button></td>";
                        echo "</tr>";

                        echo "<tr class='product-details' data-order-id='{$orderId}' style='display: none;'>";
                        echo "<td colspan='3'>";
                        echo "<table class='table table-bordered table-sm small-table'>";
                        echo "<thead><tr><th>Product Image</th><th>Price</th></tr></thead><tbody>";

                        foreach ($order['products'] as $product) {
                            echo "<tr>";
                            echo "<td><img src='{$product['image']}' class='product-image' alt='{$product['name']}'></td>";
                            echo "<td>\${$product['price']}</td>";
                            echo "</tr>";
                        }

                        echo "</tbody></table>";
                        echo "</td></tr>";

                        echo "</tbody></table>";
                        echo "</td></tr>";
                    }
                }
            } else {
                echo "<tr><td colspan='3'>Please select a date range.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
</body>
</html>


</main>

<?php view('/partials/foot.php') ?>