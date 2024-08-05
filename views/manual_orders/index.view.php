<?php view('/partials/head.php'); ?>
<?php view('/partials/nav.php'); ?>
<main class="w-full flex justify-center">
  <div class="w-full max-w-4xl p-4 bg-white rounded-md shadow-md mt-7">
    <!-- <h1 class="text-2xl font-bold text-gray-900 text-center mb-3">MANUAL ORDERS</h1> -->
    <div class="overflow-x-auto">
    <?php
    $previousDate = '';
    $itemBuffer = [];
    $totalPrice = 0; // Initialize total price accumulator
    ?>
    <?php foreach ($orders as $key => $order) : ?>
      <?php
      $currentDate = $order['date']; // Get the current order date
      
      // Check if we need to flush the itemBuffer
      if ($previousDate && $previousDate !== $currentDate) {
          // Output the buffered items for the previous date
          echo '<div class="flex flex-wrap gap-4">';
          foreach ($itemBuffer as $item) : ?>
              <div class="bg-white border border-gray-200 rounded-lg shadow-md p-4 mb-4 flex-none w-64">
                  <div class="flex items-center mb-2">
                      <img src="<?= '/serve_image_product.php?image=' . $item['image']?>" alt="<?= htmlspecialchars($item['product_name']) ?>" class="w-24 h-24 object-cover rounded-md mr-4">
                      <div class="flex-1">
                          <p class="text-lg font-semibold mb-1"><?= htmlspecialchars($item['product_name']) ?></p>
                          <span class="block text-gray-700 mb-1"><?= htmlspecialchars($item['price']) . " EGP" ?></span>
                          <span class="block text-gray-500"><?= htmlspecialchars($item['quantity']) ?></span>
                      </div>
                  </div>
              </div>
          <?php endforeach;
          echo '</div>'; // End of flex container

          // Output the total price for the previous date
          echo '<div class="text-right font-semibold text-lg mb-4">Total Price: ' . htmlspecialchars($totalPrice) . ' EGP</div>';

          // Clear the itemBuffer and reset the total price
          $itemBuffer = [];
          $totalPrice = 0;
      }

      // Add the current order to the buffer
      $itemBuffer[] = [
        'product_name' => $order['product_name'],
        'image' => $order['image'],
        'price' => $order['price'],
        'quantity' => $order['quantity']
      ];

      // Accumulate the total price
      $totalPrice += $order['price'] * $order['quantity'];

      // Output the order details table
      if (!$key) {
        // Skip table output for the first item if needed
        continue;
      }
      ?>
      <table class="min-w-full divide-y divide-gray-200">
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
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= $order["date"] ?></td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $order["name"] ?></td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $order["roomnumber"] ?></td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $order["type"] ?></td>
            <!-- <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
              <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
              <a href="#" class="text-red-600 hover:text-red-900 ml-4">Delete</a>
            </td> -->
          </tr>
          <!-- More rows here -->
        </tbody>
      </table>

    <?php
      // Update previousDate for the next iteration
      $previousDate = $currentDate;
    endforeach;

    // Flush remaining items if any
    if (!empty($itemBuffer)) : ?>
        <div class="flex flex-wrap gap-4">
            <?php foreach ($itemBuffer as $item) : ?>
                <div class="bg-white border border-gray-200 rounded-lg shadow-md p-4 mb-4 flex-none w-64">
                    <div class="flex items-center mb-2">
                        <img src="<?= '/serve_image_product.php?image=' . $item['image']?>" alt="<?= htmlspecialchars($item['product_name']) ?>" class="w-24 h-24 object-cover rounded-md mr-4">
                        <div class="flex-1">
                            <p class="text-lg font-semibold mb-1"><?= htmlspecialchars($item['product_name']) ?></p>
                            <span class="block text-gray-700 mb-1"><?= htmlspecialchars($item['price']) . " EGP" ?></span>
                            <span class="block text-gray-500"><?= htmlspecialchars($item['quantity']) ?></span>
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
