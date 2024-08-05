<?php view('/partials/head.php'); ?>
<?php view('/partials/nav.php'); ?>
<main class="w-full flex justify-center">
  <div class="w-full max-w-4xl p-4 bg-white rounded-md shadow-md mt-7">
    <div class="overflow-x-auto">
      <div class="max-h-96 overflow-y-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order Date</th>
              
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Price</th>
            
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($orders as $order) : ?>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 flex items-center">
                  <?= htmlspecialchars($order['order_date'])?>
                  <form class="ml-2" action="/checks" method="POST">
                    <input type="hidden" name="orderid" value="<?= $order['orderid'] ?>">
                    <button type="submit" class="text-blue-500 hover:text-blue-700">
                      <i class="fas fa-plus ml-8"></i>
                    </button>
                  </form>
                </td>
                
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($order['total'])?> EGP</td>
                
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>

<?php view('/partials/foot.php') ?>