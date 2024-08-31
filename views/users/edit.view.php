<?php view('/partials/head.php'); ?>
<?php view('/partials/nav.php'); ?>
<script src="https://cdn.tailwindcss.com"></script>

<main class="w-full flex justify-center">
    <div class="w-full max-w-md p-4 bg-white rounded-md shadow-md mt-7">
        <h1 class="text-2xl font-bold text-gray-900 text-center mb-3">EDIT USER</h1>
        <form action="/users" method="POST" enctype="multipart/form-data" class="space-y-4">
        <input type="hidden" name="_method" value="PATCH">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-900">Name</label>
                <input id="name" name="name" type="text" value ="<?= $user['name'] ?>" autocomplete="name" required class="block w-full rounded-md border-gray-300 py-1 text-gray-900 shadow-sm focus:ring-indigo-600 sm:text-sm">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-900">Email address</label>
                <input id="email2" name="email2" type="email" disabled  value ="<?= $user['email'] ?>" class="block w-full rounded-md border-gray-300 py-1 text-gray-900 shadow-sm focus:ring-indigo-600 sm:text-sm">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-900">Email address</label>
                <input id="email" name="email" type="hidden"  value ="<?= $user['email'] ?>" class="block w-full rounded-md border-gray-300 py-1 text-gray-900 shadow-sm focus:ring-indigo-600 sm:text-sm">
            </div>
            <div>
                <button type="button" id="togglePasswordButton" class="rounded-md bg-white px-2 py-1 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Change Password</button>
            </div>
            <div id="passwordFields" class="hidden">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-900">Password</label>
                    <input id="password" name="password" type="password" class="block w-full rounded-md border-gray-300 py-1 text-gray-900 shadow-sm focus:ring-indigo-600 sm:text-sm">
                </div>
                <div>
                    <label for="confirm" class="block text-sm font-medium text-gray-900">Confirm Password</label>
                    <input id="confirm" name="passwordconfirm" type="password" class="block w-full rounded-md border-gray-300 py-1 text-gray-900 shadow-sm focus:ring-indigo-600 sm:text-sm">
                </div>
            </div>

            <!-- <div>
                <label for="phonenumber" class="block text-sm font-medium text-gray-900">Phone Number</label>
                <input id="phonenumber" name="phonenumber" type="text" value ="<?= $user['phonenumber'] ?? '' ?>" autocomplete="off" required class="block w-full rounded-md border-gray-300 py-1 text-gray-900 shadow-sm focus:ring-indigo-600 sm:text-sm">
            </div> -->

            <div>
                <label for="photo" class="block text-sm font-medium text-gray-900">Upload a profile picture</label>
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
                <?php if (isset($errors['password'])) : ?>
                    <li class="text-red-500 text-xs"><?= $errors['password'] ?></li>
                <?php endif; ?>
                <?php if (isset($errors['email'])) : ?>
                    <li class="text-red-500 text-xs"><?= $errors['email'] ?></li>
                <?php endif; ?>
                <?php if (isset($errors['image'])) : ?>
                    <li class="text-red-500 text-xs"><?= $errors['image'] ?></li>
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
