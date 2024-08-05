<?php view('/partials/head.php'); ?>
<?php view('/partials/nav.php'); ?>
<main class="w-full flex justify-center">
<h2 class="text-2xl font-bold mb-4">User Orders</h2>
    
    
    <form method="POST" class="mb-4" action="/checks">
        <div class="grid grid-cols-3 gap-4">
            <div>
                <input type="date" name="start_date" class="form-input mt-1 block w-full" placeholder="Start Date"  required>
            </div>
            <div>
                <input type="date" name="end_date" class="form-input mt-1 block w-full" placeholder="End Date"  required>
            </div>
            <div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Filter</button>
            </div>
        </div>
    </form>

    <div class="w-full max-w-4xl p-4 bg-white rounded-md shadow-md mt-7">
    <div class="overflow-x-auto">
      <div class="max-h-96 overflow-y-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
        
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Price</th>
              
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($users as $user) : ?>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 flex items-center">
                  <?= htmlspecialchars($user['name'])?>
                  <form class="ml-2" action="/checks" method="POST">
                    <input type="hidden" name="userid" value="<?= $user['userid'] ?>">
                    <button type="submit" class="text-blue-500 hover:text-blue-700">
                      <i class="fas fa-plus ml-8"></i>
                    </button>
                  </form>
                </td>
                
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($user['total'])?> EGP</td>
               
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
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