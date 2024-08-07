<nav class="bg-gray-800 w-full">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <img class="h-8 w-8" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company"/>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <!-- Conditional Navigation Links -->
                        <?php if($_SESSION['user'] ?? false )  :?>
                            <?php if ($_SESSION['user']['role']==='admin') : ?> 
                                <a href="/" class=" <?= isUrl("/") ? "bg-gray-900 text-white" : "hover:bg-gray-700 text-gray-300 hover:text-white" ?> rounded-md px-3 py-2 text-sm font-medium" aria-current="page">Home</a>
                                <a href="/products" class=" <?= isUrl("/products") ? "bg-gray-900 text-white" : "hover:bg-gray-700 text-gray-300 hover:text-white" ?> rounded-md px-3 py-2 text-sm font-medium">Products</a>
                                <a href="/users" class=" <?= isUrl("/users") ? "bg-gray-900 text-white" : "hover:bg-gray-700 text-gray-300 hover:text-white" ?> rounded-md px-3 py-2 text-sm font-medium">Users</a>
                                <a href="/manual_orders" class=" <?= isUrl("/manual_orders") ? "bg-gray-900 text-white" : "hover:bg-gray-700 text-gray-300 hover:text-white" ?> rounded-md px-3 py-2 text-sm font-medium">Manual Orders</a>
                                <a href="/checks" class=" <?= isUrl("/checks") ? "bg-gray-900 text-white" : "hover:bg-gray-700 text-gray-300 hover:text-white" ?> rounded-md px-3 py-2 text-sm font-medium">Check</a>
                            <?php elseif ($_SESSION['user']['role']==='user') : ?>
                                <a href="/" class=" <?= isUrl("/") ? "bg-gray-900 text-white" : "hover:bg-gray-700 text-gray-300 hover:text-white" ?> rounded-md px-3 py-2 text-sm font-medium">Home</a>
                                <a href="/my_orders" class=" <?= isUrl("/my_orders") ? "bg-gray-900 text-white" : "hover:bg-gray-700 text-gray-300 hover:text-white" ?> rounded-md px-3 py-2 text-sm font-medium">My Orders</a>
                            <?php  endif ?> 
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6">
                    <!-- Profile pic or register button -->
                    <?php if ($_SESSION['user'] ?? false) : ?>
                        <div class="flex items-center space-x-3">
                            <button type="button" class="flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Open user menu</span>
                                <img class="h-8 w-8 rounded-full" src="<?= "/serve_image_user.php?image="  . $_SESSION['user']['img'] ?>" alt="user image"/>
                            </button>
                            <form method="POST" action="/session" class="inline">
                                <input type="hidden" name="_method" value="DESTROY" />
                                <button type="submit" class="bg-red-600 text-white rounded-md px-4 py-2 text-sm font-medium hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">Log Out</button>
                            </form>
                        </div>
                    <?php else : ?>
                        <a href="/register" class=" <?= isUrl("/register") ? "bg-gray-900 text-white" : "hover:bg-gray-700 text-gray-300 hover:text-white" ?> rounded-md px-3 py-2 text-sm font-medium" aria-current="page">Register</a>
                        <a href="/login" class=" <?= isUrl("/login") ? "bg-gray-900 text-white" : "hover:bg-gray-700 text-gray-300 hover:text-white" ?> rounded-md px-3 py-2 text-sm font-medium" aria-current="page">Login</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="-mr-2 flex md:hidden">
                
            </div>
        </div>
    </div>
</nav>