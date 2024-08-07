<?php view('/partials/head.php'); ?>
<?php view('/partials/nav.php'); ?>
<main class="w-full flex flex-col items-center overflow-hidden py-6 " style="height: calc(100vh - 4rem);">
<form id="filterForm" class="mb-4 w-full max-w-4xl flex items-center">
 
    <div class="flex-1">
        <input list="usernames" name="username" id="username" class="form-input block w-full border border-gray-300 rounded-md shadow-sm" placeholder="Username">
        <datalist id="usernames">
            <option value="John Doe">
            <option value="Jane Smith">
            <option value="Alice Johnson">
            <option value="Bob Brown">
        </datalist>
    </div>
    
    <!-- Vertical line -->
    <div class="mx-4 border-l-2 border-gray-300 h-10"></div>
    
    <div class="flex-1">
        <input type="date" name="start_date" class="form-input block w-full border border-gray-300 rounded-md shadow-sm" placeholder="Start Date" required>
    </div>
    <div class="ml-4 flex-1">
        <input type="date" name="end_date" class="form-input block w-full border border-gray-300 rounded-md shadow-sm" placeholder="End Date" required>
    </div>
    
    <div class="ml-4">
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md">Filter</button>
    </div>
</form>

<div class="w-full max-w-4xl p-4 bg-white rounded-md shadow-md flex-1 overflow-hidden">
    <div class="h-1/3 overflow-x-auto">
        <div class="max-h-full overflow-y-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 sticky top-0">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-right">Money Spent</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="userTableBody">
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 flex items-center">
                                <p class="w-[120px]"><?= htmlspecialchars($user['name'])?></p>
                                <button class="showOrdersBtn text-blue-500 hover:text-blue-700 ml-2" data-user-id="<?= $user['id'] ?>">
                                    <i class="fas fa-plus ml-8"></i>
                                </button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right"><?= htmlspecialchars($user['total'])?> EGP</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div id="showorders" class="h-2/5 overflow-x-auto w-full justify-center"></div>
    <div id="showproducts"></div>
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
            },
            error: function(xhr, status, error) {
                console.error("Error filtering users:", error);
            }
        });
    });
});

</script>
<?php view('/partials/foot.php') ?>