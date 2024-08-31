<?php view('/partials/head.php'); ?>
<?php view('/partials/nav.php'); ?>

<main>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
      <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <img class="mx-auto h-10 w-auto" src="./assets/imgs/cafeteria_logo.svg" alt="Cafe">
        <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Register</h2>
      </div>
    
      <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form class="space-y-6" action="/register" method="POST" enctype="multipart/form-data" autocomplete="off">

        <div>
  <label for="name" class="block text-sm font-medium leading-3 text-gray-900">Name</label>
  <div class="mt-2">
    <input id="name" name="name" type="text" autocomplete="off" value="<?= old('name') ?>"
      required class="pl-4 block w-full rounded-md border border-accent-500 py-1.5 text-gray-900 shadow-sm sm:text-sm sm:leading-6">
  </div>
</div>


          <div>
            <label for="email" class="block text-sm font-medium leading-3 text-gray-900">Email address</label>
            <div class="mt-2">
              <input id="email" name="email" type="email" autocomplete="off" value = " <?= old('email') ?>"
              required class="pl-4 block w-full rounded-md border border-accent-500 py-1.5 text-gray-900 shadow-sm sm:text-sm sm:leading-6">
            </div>
          </div>
    
          <div>
            <div class="flex items-center justify-between">
              <label for="password" class="block text-sm font-medium leading-3 text-gray-900">Password</label>
            </div>
            <div class="mt-2">
              <input id="password" name="password" type="password" autocomplete="new-password" required class="pl-4 block w-full rounded-md border border-accent-500 py-1.5 text-gray-900 shadow-sm sm:text-sm sm:leading-6">
            </div>
          </div>

          <div>
            <label for="photo" class="block text-sm font-medium leading-6 text-gray-900">Upload a profile picture</label>
            <input type="file" id="photo" name="photo" class="hidden" accept="image/png, image/jpeg, image/jpg">
            <div class="mt-2 flex items-center gap-x-3">
              <svg id="defaultSvg" class="h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd" />
              </svg>
              <img id="profilePicture" class="h-12 w-12 rounded-full hidden" alt="Profile Picture">
              <button type="button" id="changeButton" class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Change</button>
              <p id="filePath" class="ml-3 text-sm text-gray-600">No Photo chosen</p>
            </div>
          </div>

          <div>
            <button type="submit" class="flex w-full justify-center rounded-md bg-accent-700 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Register</button>
          </div>
          <ul>
                <?php if (isset($errors['name'])) : ?>
                    <li class="text-red-500 text-xs mt-2"><?= $errors['name'] ?></li>
                <?php endif; ?>

                <?php if (isset($errors['password'])) : ?>
                    <li class="text-red-500 text-xs mt-2"><?= $errors['password'] ?></li>
                <?php endif; ?>

                <?php if (isset($errors['email'])) : ?>
                    <li class="text-red-500 text-xs mt-2"><?= $errors['email'] ?></li>
                <?php endif; ?>

                <?php if (isset($errors['image'])) : ?>
                    <li class="text-red-500 text-xs mt-2"><?= $errors['image'] ?></li>
                <?php endif; ?>
          </ul>
        </form>
      </div>
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
      filePathElement.textContent = truncateFilePath(file.name,20);

    } else {

      filePathElement.textContent = 'No file chosen';
      profilePicture.classList.add('hidden');
      defaultSvg.classList.remove('hidden');
    }

  })

  function truncateFilePath(filePath, maxLength) {

    if (filePath.length <= maxLength) {return filePath};

    const start = filePath.substring(0, Math.floor(maxLength / 2));
    const end = filePath.substring(filePath.length - Math.floor(maxLength / 2));
    return `${start}...${end}`;

  }

</script>
<?php view('/partials/foot.php') ?>