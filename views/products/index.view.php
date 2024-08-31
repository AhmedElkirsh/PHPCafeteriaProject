<?php view('/partials/head.php'); ?>
<?php view('/partials/nav.php'); ?>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search');
    
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            filterProductsByText();
        });
    }

    const filterProductsByText = () => {
        const searchText = searchInput.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            // Get the product name from the row
            const productNameCell = row.querySelector('td:nth-child(2)');
            const productName = productNameCell ? productNameCell.textContent.toLowerCase() : '';

            // Check if the product name includes the search text
            if (productName.includes(searchText)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    };
});
</script>

<main class="w-full flex justify-center">
    <div class="w-full max-w-4xl p-4 bg-white rounded-md shadow-md mt-7">
        
        <!-- Search Bar and Add Product Button -->
        <div class="flex items-center justify-between mb-4">
            <div class="relative w-full max-w-xs">
                <input type="text" id="search" placeholder="Search Products..." class="block w-full px-4 py-2 border border-secondary-500 rounded-md shadow-sm placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
            </div>
            <a href="/products/create" class="inline-block px-4 py-2 bg-accent-900 text-white text-sm font-medium rounded-md shadow-sm hover:bg-accent-700">Add Product</a>
        </div>

        <!-- Products Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-secondary-50 sticky top-0">
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium text-text2 uppercase tracking-wider text-center">Image</th>
                        <th class="px-6 py-3 text-xs font-medium text-text2 uppercase tracking-wider text-center">Name</th>
                        <th class="px-6 py-3 text-xs font-medium text-text2 uppercase tracking-wider text-center">Price</th>
                        <th class="px-6 py-3 text-xs font-medium text-text2 uppercase tracking-wider text-center">Time</th>
                        <th class="px-6 py-3 text-xs font-medium text-text2 uppercase tracking-wider text-center">Status</th>
                        <th class="px-6 py-3 text-xs font-medium text-text2 uppercase tracking-wider text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (!empty($products)) : ?>
                        <?php foreach ($products as $product) : ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-text2 text-center">
                                    <img src="<?= "/serve_image_product.php?image=" . $product["image"]; ?>" alt="Product Image" class="w-20 h-20 object-contain rounded-full mx-auto">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-text2 text-center">
                                    <?= htmlspecialchars($product["name"]); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-text2 text-center">
                                    <?= htmlspecialchars($product["price"]); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-text2 text-center">
                                    <?= htmlspecialchars($product["time"]); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-text2 text-center">
                                    <?= htmlspecialchars($product["productStatus"]); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-text2 text-center">
                                    <div class="flex justify-center gap-4">
                                        <form action="/products/edit" method="POST">
                                            <input type="hidden" name="name" value="<?= $product['name'] ?>">
                                            <button type="submit" class="text-accent-800 hover:text-accent-400">
                                                <!-- Edit Icon -->
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </button>
                                        </form>
                                        <form action="/products" method="POST">
                                            <input type="hidden" name="_method" value="DESTROY">
                                            <input type="hidden" name="name" value="<?= $product['name'] ?>">
                                            <button type="submit" class="text-red-600 hover:text-red-800">
                                                <!-- Delete Icon -->
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No products found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php view('/partials/foot.php'); ?>
