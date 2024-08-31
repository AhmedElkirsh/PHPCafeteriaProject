<nav class="border-text2-50 border-b-[1px]">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
    <a href="/" class="flex items-center gap-1">
      <img src="./assets/imgs/cafeteria_logo.svg" class="h-8" alt="Cafe Logo" />
      <span class="self-center text-2xl font-semibold whitespace-nowrap text-text2">afe</span>
    </a>
    <?php if($_SESSION['user'] ?? false ) :?>
      <div class="relative flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
        <button type="button" class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
          <img class="w-8 h-8 rounded-full" src="<?= "/serve_image_user.php?image="  . $_SESSION['user']['img'] ?>" alt="user photo">
        </button>
        <!-- Dropdown menu -->
        <div class="absolute right-0 z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow" id="user-dropdown" style="top: 100%; min-width: 12rem;">
          <div class="px-4 py-3">
            <span class="block text-sm text-gray-900"><?= $_SESSION['user']['name'] ?></span>
            <span class="block text-sm text-gray-500 truncate"><?= $_SESSION['user']['email'] ?></span>
          </div>
          <ul class="py-2" aria-labelledby="user-menu-button">
            <li>
              <form method="POST" action="/session" class="inline">
                <input type="hidden" name="_method" value="DESTROY" />
                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-accent">Log Out</button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    <?php else :?>
      <div>
        <a href="/login" class=" <?= isUrl("/login") ? "bg-accent-50 text-text2" : "hover:bg-accent-50 text-text2 hover:text-text2" ?> rounded-md px-3 py-2 text-sm font-medium" aria-current="page">Login</a>
        <a href="/register" class=" <?= isUrl("/register") ? "bg-accent-50 text-text2" : "hover:bg-accent-50 text-text2 hover:text-text2" ?> rounded-md px-3 py-2 text-sm font-medium">Register</a>           
      </div>
    <?php endif ?>
    <?php if($_SESSION['user'] ?? false )  :?>
      <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1 gap-4" id="navbar-user">
        <!-- Conditional Navigation Links -->
          <?php if ($_SESSION['user']['role']==='admin') : ?> 
              <a href="/orders" class=" <?= isUrl("/orders") ? "bg-accent-50 text-text2" : "hover:bg-accent-50 text-text2 hover:text-text2" ?> rounded-md px-3 py-2 text-sm font-medium" aria-current="page">Order</a>
              <a href="/products" class=" <?= isUrl("/products") ? "bg-accent-50 text-text2" : "hover:bg-accent-50 text-text2 hover:text-text2" ?> rounded-md px-3 py-2 text-sm font-medium">Products</a>
              <a href="/users" class=" <?= isUrl("/users") ? "bg-accent-50 text-text2" : "hover:bg-accent-50 text-text2 hover:text-text2" ?> rounded-md px-3 py-2 text-sm font-medium">Users</a>
              <a href="/manual_orders" class=" <?= isUrl("/manual_orders") ? "bg-accent-50 text-text2" : "hover:bg-accent-50 text-text2 hover:text-text2" ?> rounded-md px-3 py-2 text-sm font-medium">Manual Orders</a>
              <a href="/checks" class=" <?= isUrl("/checks") ? "bg-accent-50 text-text2" : "hover:bg-accent-50 text-text2 hover:text-text2" ?> rounded-md px-3 py-2 text-sm font-medium">Check</a>
          <?php elseif ($_SESSION['user']['role']==='user') : ?>
              <a href="/orders" class=" <?= isUrl("/orders") ? "bg-accent-50 text-text2" : "hover:bg-accent-50 text-text2 hover:text-text2" ?> rounded-md px-3 py-2 text-sm font-medium">Order</a>
              <a href="/my_orders" class=" <?= isUrl("/my_orders") ? "bg-accent-50 text-text2" : "hover:bg-accent-50 text-text2 hover:text-text2" ?> rounded-md px-3 py-2 text-sm font-medium">My Orders</a>
          <?php  endif ?> 
      </div>
    <?php endif ?>
  </div>
</nav>

<script>
    document.getElementById('user-menu-button').addEventListener('click', function() {
        const dropdown = document.getElementById('user-dropdown');
        dropdown.classList.toggle('hidden');
    });
</script>