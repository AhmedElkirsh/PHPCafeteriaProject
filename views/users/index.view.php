<?php view('/partials/head.php'); ?>
<?php view('/partials/nav.php'); ?>

<div class="container mx-auto mt-8">
    <div class="flex justify-between items-center mb-5">
        <h1 class="text-3xl font-bold text-gray-900 text-center">All Users</h1>
        <a href="/users/create">
            <button type="button" class="rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2">
                Add User
            </button>
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse table-auto text-sm">
            <thead>
                <tr>
                    <th class="border-b border-gray-200 dark:border-gray-600 font-medium p-4 text-gray-700 dark:text-gray-300 text-center">Image</th>
                    <th class="border-b border-gray-200 dark:border-gray-600 font-medium p-4 text-gray-700 dark:text-gray-300 text-center">Name</th>
                    <th class="border-b border-gray-200 dark:border-gray-600 font-medium p-4 text-gray-700 dark:text-gray-300 text-center">Email</th>
                    <th class="border-b border-gray-200 dark:border-gray-600 font-medium p-4 text-gray-700 dark:text-gray-300 text-center">Action</th>
                    
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800">
                <?php if (!empty($users)) : ?>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td class="border-b border-gray-200 dark:border-gray-700 p-4 text-gray-700 dark:text-gray-300 text-center">
                                <img src="<?= "/serve_image_user.php?image=" . $user['upload_dir']; ?>" alt="User Image" class="w-24 h-24 object-cover rounded-full mx-auto">
                            </td>
                            <td class="border-b border-gray-200 dark:border-gray-700 p-4 text-gray-700 dark:text-gray-300 text-center">
                                <?= htmlspecialchars($user['name']); ?>
                            </td>
                            <td class="border-b border-gray-200 dark:border-gray-700 p-4 text-gray-700 dark:text-gray-300 text-center">
                                <?= htmlspecialchars($user['email']); ?>
                            </td>
                            <td class="border-b border-gray-200 dark:border-gray-700 p-4 text-gray-700 dark:text-gray-300 text-center">
                                <div class="flex justify-center gap-4">
                                    <form action="/users/edit" method="POST">
                                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                        <button type="submit" class="rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2">Edit</button>
                                    </form>
                                    <form action="/users/destroy" method="POST">
                                        <input type="hidden" name="_method" value="DESTROY">
                                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                        <button type="submit" class="rounded-md bg-red-600 px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4" class="border-b border-gray-200 dark:border-gray-700 p-4 text-gray-700 dark:text-gray-300 text-center">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php view('/partials/foot.php'); ?>
