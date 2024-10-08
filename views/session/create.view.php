<?php view('/partials/head.php'); ?>
<?php view('/partials/nav.php'); ?>
<main>
    <div class="flex min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8">
            <div>
                <img class="mx-auto h-12 w-auto" src="./assets/imgs/cafeteria_logo.svg"
                     alt="Your Company">
                <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Log In</h2>
            </div>

            <form class="mt-8 space-y-6" action="/session" method="POST" autocomplete="off">
                <div class="-space-y-px rounded-md shadow-sm">
                    
                    <div>
                        <label for="email" class="sr-only">Email address</label>
                        <input id="email" name="email" type="email" required
                               class="relative block w-full appearance-none rounded-none rounded-t-md border border-secondary-500 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-accent-400 focus:outline-none focus:ring-accent-400 sm:text-sm"
                               placeholder="Email address"
                               autocomplete="off"
                               value = "<?= old('email') ?>">
                    </div>

                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" name="password" type="password" required
                               class="relative block w-full appearance-none rounded-none rounded-b-md border border-secondary-500 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-accent-400 focus:outline-none focus:ring-accent-400 sm:text-sm"
                               placeholder="Password"
                               autocomplete="new-password">
                    </div>

                </div>
                
                
                <div>
                    <button type="submit"
                            class="group relative flex w-full justify-center rounded-md border border-transparent bg-accent-700 py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Log In
                    </button>
                </div>

                <ul>
                    <?php if (isset($errors['email'])) : ?>
                        <li class="text-red-500 text-xs mt-2"><?= $errors['email'] ?></li>
                    <?php endif; ?>

                    <?php if (isset($errors['password'])) : ?>
                        <li class="text-red-500 text-xs mt-2"><?= $errors['password'] ?></li>
                    <?php endif; ?>
                </ul>
            </form>
            
        </div>
    </div>
</main>

<?php view('/partials/foot.php') ?>