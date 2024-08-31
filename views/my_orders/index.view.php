<?php view('/partials/head.php'); ?>
<?php view('/partials/nav.php'); ?>

<main class="w-full flex justify-center py-6">
  <div class="w-full max-w-4xl p-6 bg-white rounded-md shadow-md mt-6">
    <!-- Filter Form -->
    <form id="filter-form" class="flex flex-wrap items-center gap-4 pb-4 w-full border-b-4 border-accent-500">
      <div class="flex-1 min-w-[150px]">
        <input type="datetime-local" id="start_date" class=" block w-full p-2 border border-accent-500 rounded-md focus:ring-accent-500 focus:border-accent-500">
      </div>
      <div class="flex-1 min-w-[150px]">
        <input type="datetime-local" id="end_date" class=" block w-full p-2 border border-accent-500 rounded-md focus:ring-accent-500 focus:border-accent-500">
      </div>

      <button type="button" id="filter-button" class="mt-auto bg-accent-700 text-white px-6 py-2 rounded-md hover:bg-accent-800 focus:outline-none focus:ring-2 focus:ring-accent-700 w-full sm:w-auto">
        Filter
      </button>
    </form>
    <!-- Orders Table -->
    <div class="overflow-x-auto">
      <div class="h-[60vh] overflow-y-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order Date & Time</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Price</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($orders as $order) : ?>
              <tr>
                <td class="order-date px-6 py-4 whitespace-nowrap text-sm text-gray-500 flex items-center">
                  <?= date('Y-m-d H:i:s', strtotime($order['order_date'])) ?>
                  <button class="toggle-button text-accent-500 hover:text-accent-700 ml-8" data-orderid="<?= $order['orderid'] ?>">
                    <i class="fas fa-<?= $order['orderid'] == $orderid ? "minus" : "plus" ?>"></i>
                  </button>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($order['status']) ?></td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($order['total']) ?> EGP</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  <?php if ($order['status'] === "processing") : ?>
                    <form action="/my_orders" method="POST">
                      <input type="hidden" name="orderid" value="<?= $order['orderid'] ?>">
                      <input type="hidden" name="_method" value="DESTROY">
                      <button type="submit" class="text-red-500 hover:text-red-700">
                        Cancel
                      </button>
                    </form>
                  <?php endif ?>
                </td>
              </tr>
              <tr>
                <td colspan="4" class="px-6 py-0">
                  <div id="details-<?= $order['orderid'] ?>" class="order-details flex flex-wrap gap-2 justify-center <?= $order['orderid'] == $orderid ? "" : "hidden" ?>">
                    <?php foreach ($takes as $item) : ?>
                      <?php if ($item['orderid'] == $order['orderid']) : ?>
                        <div class="bg-white border my-3 w-[32%] h-[160px] border-accent-500 rounded-lg shadow-md flex flex-row">
                          <div class="w-[40%] flex-shrink-0">
                            <img src="/serve_image_product.php?image=<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['productname']) ?>" class="w-full h-full object-cover rounded-md">
                          </div>
                          <div class="w-2/3 pl-4 flex flex-col justify-center">
                            <p class="text-lg font-semibold mb-1"><?= htmlspecialchars($item['productname']) ?></p>
                            <span class="block text-gray-700 mb-1"><?= htmlspecialchars($item['price']) ?> EGP</span>
                            <span class="block text-gray-700 mb-1">Quantity: <?= htmlspecialchars($item['quantity']) ?></span>
                            <span class="block text-gray-500">Total: <?= htmlspecialchars($item['price'] * $item['quantity']) ?></span>
                          </div>
                        </div>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>

<?php view('/partials/foot.php') ?>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    // Toggle button functionality
    document.querySelectorAll('.toggle-button').forEach(button => {
      button.addEventListener('click', () => {
        const details = document.getElementById(`details-${button.dataset.orderid}`);
        const icon = button.querySelector('i');
        const isHidden = details.classList.toggle('hidden');

        icon.classList.toggle('fa-plus', isHidden);
        icon.classList.toggle('fa-minus', !isHidden);
      });
    });
    // Filter button functionality
    document.getElementById('filter-button').addEventListener('click', () => {
      const startDateInput = document.getElementById('start_date').value;
      const endDateInput = document.getElementById('end_date').value;
      // Default start date to the earliest possible date if not provided
      const startDate = startDateInput ? new Date(startDateInput) : new Date('1970-01-01T00:00:00');
      // Default end date to the latest possible date if not provided
      const endDate = endDateInput ? new Date(endDateInput) : new Date('9999-12-31T23:59:59');
      // Collapse all order details and reset toggle buttons
      document.querySelectorAll('.order-details').forEach(details => {
        details.classList.add('hidden');
        const icon = details.closest('tr').querySelector('.toggle-button i');
        if (icon) {
          icon.classList.replace('fa-minus', 'fa-plus');
        }
      });
      // Apply filter based on dates and times
      document.querySelectorAll('tbody tr').forEach(row => {
        const orderDateCell = row.querySelector('.order-date');
        if (orderDateCell) {
          const orderDateText = orderDateCell.textContent.trim();
          const [dateText, timeText] = orderDateText.split(' ');
          const orderDate = new Date(`${dateText}T${timeText}`); // Combine date and time
          // Display rows that fall within the date range
          if (!isNaN(orderDate.getTime()) && orderDate >= startDate && orderDate <= endDate) {
            row.style.display = '';
            // Ensure the details are collapsed
            const details = document.getElementById(`details-${row.querySelector('.toggle-button').dataset.orderid}`);
            if (details) {
              details.classList.add('hidden');
              const icon = row.querySelector('.toggle-button i');
              if (icon) {
                icon.classList.replace('fa-minus', 'fa-plus');
              }
            }
          } else {
            row.style.display = 'none';
          }
        }
      });
    });
  });
</script>
