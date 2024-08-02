<?php view('/partials/head.php'); ?>
<div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
    <h1 class="text-3xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight mb-5 m-5 pt-5 text-center">ADD USER</h1>
    <form action="/users" method="POST" enctype="multipart/form-data" class="space-y-6">
        <div>
            <label for="name" class="block text-sm font-medium leading-3 text-gray-900">Name</label>
            <div class="mt-2">
                <input id="name" name="name" type="text" autocomplete="name" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </div>
        </div>

        <div>
            <label for="email" class="block text-sm font-medium leading-3 text-gray-900">Email address</label>
            <div class="mt-2">
                <input id="email" name="email" type="email" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </div>
        </div>
        <div>
            <div class="flex items-center justify-between">
                <label for="password" class="block text-sm font-medium leading-3 text-gray-900">Password</label>
            </div>
            <div class="mt-2">
                <input id="password" name="password" type="password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </div>
        </div>
        <div>
            <div class="flex items-center justify-between">
                <label for="password" class="block text-sm font-medium leading-3 text-gray-900">Confirm Password</label>
            </div>
            <div class="mt-2">
                <input id="confirm" name="confirm_password" type="password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </div>
        </div>

        <div>
            <label for="room" class="block text-sm font-medium leading-3 text-gray-900">Room Number</label>
            <div class="mt-2">
                <input id="room" name="room" type="number" autocomplete="name" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" min="1" step="1">
            </div>
        </div>
        <div>
            <label for="ext" class="block text-sm font-medium leading-3 text-gray-900">EXT Number</label>
            <div class="mt-2">
                <input id="ext" name="ext" type="number" autocomplete="name" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" min="1" step="1">
            </div>
        </div>

        <label for="photo" class="block text-sm font-medium leading-6 text-gray-900">Upload a profile picture</label>
        <input type="file" id="photo" name="photo" accept="image/png, image/jpeg, image/jpg">
        <!-- <div class="mt-2">
            <textarea id="about" name="body" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
        </div> -->
        <?php if (!empty($errors)) : ?>
            <?php foreach ($errors as $error) : ?>
                <p><?= $errors['body'] ?></p>
            <?php endforeach; ?>
        <?php endif; ?>

        <div>
            <button type="reset" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" name="reset">Reset</button>
        </div>
        <div>
            <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" name="submit">Submit</button>
        </div>
    </form>
</div>
<?php view('/partials/foot.php') ?>