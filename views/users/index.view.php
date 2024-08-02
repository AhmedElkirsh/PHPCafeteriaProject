<?php view('/partials/head.php'); ?>
<div>
    <h1 class="text-3xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight mb-5 m-5 pt-5 text-center">All Users</h1>
    <a href="/users/create"><button type="reset" class="flex justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 mb-5 mr-5" name="reset" style="float: right;">Add User</button></a>
</div>
<table class="border-collapse table-fixed w-full text-sm">
    <tr>
        <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 :text-slate-200 text-center">Image</th>
        <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 :text-slate-200 text-center">Name</th>
        <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 :text-slate-200 text-center">Email</th>
        <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 :text-slate-200 text-center">Action</th>
    </tr>
    <tbody class="bg-white dark:bg-slate-800 p-10">
        <?php if (!empty($users)) : ?>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400 text-center">
                        <img src="<?php echo htmlspecialchars($user['image']); ?>" alt="User Image" width="100" height="100">
                    </td>
                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400 text-center">
                        <?php echo htmlspecialchars($user['name']); ?>
                    </td>
                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400 text-center">
                        <?php echo htmlspecialchars($user['email']); ?>
                    </td>
                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400 text-center">
                        <div style="display: flex; justify-content: center; gap: 10px;">
                            <form action="/users/edit" method="POST">
                                <input type="hidden" name="_method" value="PATCH">
                                <input type="hidden" name="id" value=<?= $user['id'] ?>>
                                <button class="flex justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 mb-5" name="edit" style="float: right;">Edit</button>
                            </form>
                            <form action="/users/destroy" method="POST">
                                <input type="hidden" name="_method" value="DESTROY">
                                <input type="hidden" name="id" value=<?= $user['id'] ?>>
                                <button type="submit" class="flex justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 mb-5" name="delete">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>

    <?php view('/partials/foot.php') ?>