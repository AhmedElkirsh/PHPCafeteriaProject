<?php view('/partials/head.php'); ?>
<?php view('/partials/nav.php'); ?>

<main class="w-full flex justify-center">
    <div class="w-full max-w-md p-4 bg-white rounded-md shadow-md mt-7">
        <h1 class="text-2xl font-bold text-gray-900 text-center mb-3">ADD PRODUCT</h1>
        <form action="/products" method="POST" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-900">Name</label>
                <input id="name" name="name" type="text" autocomplete="name" value ="<?=  old('name') ?>" required class="block w-full rounded-md border-gray-300 py-1 text-gray-900 shadow-sm focus:ring-indigo-600 sm:text-sm">
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-900">Price</label>
                <input id="price" name="price" value ="<?= old('price') ?>" class="block w-full rounded-md border-gray-300 py-1 text-gray-900 shadow-sm focus:ring-indigo-600 sm:text-sm">
            </div>

            <div>
                <label for="time" class="block text-sm font-medium text-gray-900">Time</label>
                <input id="time" name="time" value ="<?= old('time') ?>"  class="block w-full rounded-md border-gray-300 py-1 text-gray-900 shadow-sm focus:ring-indigo-600 sm:text-sm">
            </div>
            <div>
                <label for="categoryname" class="block text-sm font-medium text-gray-900">Category</label>
                <input id="categoryname" name="categoryname" value ="<?= old('category') ?>" list="categoryOptions" autocomplete="off" required class="block w-full rounded-md border-gray-300 py-1 text-gray-900 shadow-sm focus:ring-indigo-600 sm:text-sm">
                <datalist id="categoryOptions">
                    <?php foreach ($categories as $category) : ?>
                    <option value="<?= $category['categoryname'] ?>">
                    <?php endforeach ?>
                </datalist>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-900">Product Status</label>
                <div class="flex items-center mt-2">
                    <input id="productStatus" name="productStatus" type="radio" <?= old('status')==='available'? 'checked' : '' ?> value="available" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-600">
                    <label for="productStatus" class="ml-2 block text-sm font-medium text-gray-900">available</label>
                </div>
                <div class="flex items-center mt-2">
                    <input id="productStatus" name="productStatus" type="radio" <?= old('status')==='unavailable'? 'checked' : '' ?> value="unavailable" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-600">
                    <label for="productStatus" class="ml-2 block text-sm font-medium text-gray-900">unavailable</label>
                </div>
            </div>

            <div>
                <label for="photo" class="block text-sm font-medium text-gray-900">Upload a product picture</label>
                <input type="file" id="photo" name="photo" class="hidden" accept="image/png, image/jpeg, image/jpg">
                <div class="mt-2 flex items-center gap-x-2">
                    <svg id="defaultSvg" class="h-10 w-10 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd" />
                    </svg>
                    <img id="profilePicture" class="h-10 w-10 rounded-full hidden" alt="Profile Picture">
                    <button type="button" id="changeButton" class="rounded-md bg-white px-2 py-1 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Change</button>
                    <p id="filePath" class="ml-2 text-sm text-gray-600">No Photo chosen</p>
                </div>
            </div>
            <ul>
                <?php if (isset($errors['name'])) : ?>
                    <li class="text-red-500 text-xs"><?= $errors['name'] ?></li>
                <?php endif; ?>
                <?php if (isset($errors['category'])) : ?>
                    <li class="text-red-500 text-xs"><?= $errors['category'] ?></li>
                <?php endif; ?>
                <?php if (isset($errors['status'])) : ?>
                    <li class="text-red-500 text-xs"><?= $errors['status'] ?></li>
                <?php endif; ?>
                <?php if (isset($errors['price'])) : ?>
                    <li class="text-red-500 text-xs"><?= $errors['price'] ?></li>
                <?php endif; ?>
                <?php if (isset($errors['image'])) : ?>
                    <li class="text-red-500 text-xs"><?= $errors['image'] ?></li>
                <?php endif; ?>
                <?php if (isset($errors['time'])) : ?>
                    <li class="text-red-500 text-xs"><?= $errors['time'] ?></li>
                <?php endif; ?>
            </ul>
            <div>
                <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" name="submit">Submit</button>
            </div>
        </form>
    </div>
</main>

<script>
    document.getElementById('changeButton').addEventListener('click', function() {
        document.getElementById('photo').click();
    });

    document.getElementById('photo').addEventListener('change', function() {
        const fileInput = this;
        const filePathElement = document.getElementById('filePath');
        const profilePicture = document.getElementById('profilePicture');
        const defaultSvg = document.getElementById('defaultSvg');
        const file = fileInput.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profilePicture.src = e.target.result;
                profilePicture.classList.remove('hidden');
                defaultSvg.classList.add('hidden');
            };
            reader.readAsDataURL(file);
            filePathElement.textContent = file.name;
        } else {
            filePathElement.textContent = 'No file chosen';
            profilePicture.classList.add('hidden');
            defaultSvg.classList.remove('hidden');
        }
    });

    document.getElementById('togglePasswordButton').addEventListener('click', function() {
        const passwordFields = document.getElementById('passwordFields');
        if (passwordFields.classList.contains('hidden')) {
            passwordFields.classList.remove('hidden');
        } else {
            passwordFields.classList.add('hidden');
        }
    });
</script>
<?php view('/partials/foot.php'); ?>