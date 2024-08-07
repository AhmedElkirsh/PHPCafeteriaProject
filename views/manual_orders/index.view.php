<?php view('/partials/head.php'); ?>
<?php view('/partials/nav.php'); ?>

<main class="w-full flex justify-center">
  <div class="w-full max-w-4xl p-4 bg-white rounded-md shadow-md mt-7">
    <!-- <h1 class="text-2xl font-bold text-gray-900 text-center mb-3">MANUAL ORDERS</h1> -->
    
    <div class="overflow-x-auto">
      <?php
      $previousDate = '';
      $itemBuffer = [];
      $totalPrice = 0;

      foreach ($orders as $key => $order) :
        $currentDate = $order['date'];

        // Check if we need to flush the itemBuffer for the previous date
        if ($previousDate && $previousDate !== $currentDate) {
          // Output the buffered items for the previous date
          ?>
          <div class="flex flex-wrap gap-4 mb-6">
            <?php foreach ($itemBuffer as $item) : ?>
              <div class="bg-white border border-gray-200 rounded-lg shadow-md p-2 mb-4 flex-none w-48">
                <div class="flex items-center mb-2">
                  <img src="<?= '/serve_image_product.php?image=' . htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>" class="w-20 h-20 object-cover rounded-md mr-2">
                  <div class="flex-1">
                    <p class="text-sm font-semibold mb-1"><?= htmlspecialchars($item['product_name']) ?></p>
                    <span class="block text-gray-700 mb-1 text-xs"><?= htmlspecialchars($item['price']) . " EGP" ?></span>
                    <span class="block text-gray-500 text-xs"><?= htmlspecialchars($item['quantity']) ?></span>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="text-right font-semibold text-lg mb-4">Total Price: <?= htmlspecialchars($totalPrice) ?> EGP</div>

          <?php
          // Reset buffer and total price
          $itemBuffer = [];
          $totalPrice = 0;
        }

        // Add current order to buffer
        $itemBuffer[] = [
          'product_name' => $order['product_name'],
          'image' => $order['image'],
          'price' => $order['price'],
          'quantity' => $order['quantity']
        ];

        // Accumulate total price
        $totalPrice += $order['price'] * $order['quantity'];

        // Output the order details table for the current date, only if it's the first item for this date
        if ($key == 0 || ($previousDate !== $currentDate && $previousDate)) : ?>
          <table class="min-w-full divide-y divide-gray-200 mb-6">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room Number</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= htmlspecialchars($order["date"]) ?></td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($order["name"]) ?></td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($order["roomnumber"]) ?></td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($order["type"]) ?></td>
              </tr>
            </tbody>
          </table>
        <?php endif; ?>

        <?php $previousDate = $currentDate; ?>
      <?php endforeach; ?>

      <?php if (!empty($itemBuffer)) : ?>
        <div class="flex flex-wrap gap-4 mb-6">
          <?php foreach ($itemBuffer as $item) : ?>
            <div class="bg-white border border-gray-200 rounded-lg shadow-md p-2 mb-4 flex-none w-48">
              <div class="flex items-center mb-2">
                <img src="<?= '/serve_image_product.php?image=' . htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>" class="w-20 h-20 object-cover rounded-md mr-2">
                <div class="flex-1">
                  <p class="text-sm font-semibold mb-1"><?= htmlspecialchars($item['product_name']) ?></p>
                  <span class="block text-gray-700 mb-1 text-xs"><?= htmlspecialchars($item['price']) . " EGP" ?></span>
                  <span class="block text-gray-500 text-xs"><?= htmlspecialchars($item['quantity']) ?></span>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <div class="text-right font-semibold text-lg mb-4">Total Price: <?= htmlspecialchars($totalPrice) ?> EGP</div>
      <?php endif; ?>

    </div>
  </div>
</main>

<?php view('/partials/foot.php') ?>
