<?php view('/partials/head.php'); ?>
<?php view('/partials/nav.php'); ?>
<main class="w-full flex flex-col items-center">
    <h2 class="text-2xl font-bold mb-4">User Orders</h2>
    <form id="filterForm" class="mb-4 w-full max-w-4xl">
        <div class="grid grid-cols-3 gap-4">
            <div>
                <input type="date" name="start_date" class="form-input mt-1 block w-full border border-gray-300 rounded-md shadow-sm" placeholder="Start Date" required>
            </div>
            <div>
                <input type="date" name="end_date" class="form-input mt-1 block w-full border border-gray-300 rounded-md shadow-sm" placeholder="End Date" required>
            </div>
            <div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Filter</button>
            </div>
        </div>
    </form>

    <div class="w-full max-w-4xl p-4 bg-white rounded-md shadow-md mt-7">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Price</th>
                    </tr>
                </thead>
            </table>
            <div class="max-h-64 overflow-y-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <tbody class="bg-white divide-y divide-gray-200" id="userTableBody">
                        <?php foreach ($users as $user) : ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 flex items-center">
                                    <?= htmlspecialchars($user['name'])?>
                                    <button class="showOrdersBtn text-blue-500 hover:text-blue-700 ml-2" data-user-id="<?= $user['id'] ?>">
                                        <i class="fas fa-plus ml-8"></i>
                                    </button>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($user['total'])?> EGP</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="showorders" class="max-h-64 mt-4 "></div>
        <div id="showproducts" class="max-h-64 mt-4 overflow-y-auto"></div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function(){
        $(document).on('click', '.showOrdersBtn', function(event){
            event.preventDefault();
            var userId = $(this).data('user-id');
            $.ajax({
                url: '/checks/orders',
                method: 'POST',
                data: { id: userId },
                success: function(response) {
                    $('#showorders').html(response);
                }
            });
        });

        $(document).on('click', '.showOrderBtn', function(event) {
            event.preventDefault();
            var orderId = $(this).data('orderid');
            $.ajax({
                url: '/checks/order',
                method: 'POST',
                data: { orderid: orderId },
                success: function(response) {
                    $('#showproducts').html(response);
                }
            });
        });

        $('#filterForm').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '/checks/filter',
                method: 'POST',
                data: formData,
                success: function(response) {
                    $('#userTableBody').html(response);
                }
            });
        });
    });
</script>

<?php view('/partials/foot.php') ?>
