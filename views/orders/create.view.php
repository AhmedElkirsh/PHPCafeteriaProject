<?php view('/partials/head.php'); ?>
<?php view('/partials/nav.php'); ?>


<main class="flex justify-end w-full mt-4">

    <!-- Script for + and - buttons, adding and removing products,and updating total price -->
    <script>
        //sending user id to admin for adding order to specific user
        document.addEventListener('DOMContentLoaded', () => {
            const selectElement = document.getElementById('userlist');
            const hiddenInput = document.getElementById('selected-user');
            selectElement.addEventListener('change', () => {
                hiddenInput.value = selectElement.value;
            });
        });
        document.addEventListener('DOMContentLoaded', () => {
            const updateTotalPrice = () => {
                const orderedProducts = document.querySelectorAll('.products[style="display: block;"]');
                let total = 0;
                orderedProducts.forEach(product => {
                    const price = parseFloat(product.getAttribute('data-product-price'));
                    const quantityInput = product.querySelector('input[type="text"]');
                    const quantity = parseInt(quantityInput.value, 10);
                    const productPrice = price * quantity;
                    product.querySelector('.product-price').textContent = `$${productPrice.toFixed(2)}`;
                    total += productPrice;
                });
                const totalPriceElement = document.querySelector('.order-summary .total-price');
                if (totalPriceElement) {
                    totalPriceElement.textContent = `$${total.toFixed(2)}`;
                }
            };

            const updateChosenProductStatus = () => {
                const orderedProducts = document.querySelectorAll('.products[style="display: block;"]');
                const chosenProductInput = document.querySelector('#productChosen');
                if (orderedProducts.length > 0) {
                    chosenProductInput.value = 'true';
                } else {
                    chosenProductInput.value = 'false';
                }
            };

            document.querySelectorAll('.increment-button').forEach(button => {
                button.addEventListener('click', () => {
                    const quantityInput = button.previousElementSibling;
                    let quantity = parseInt(quantityInput.value, 10);
                    quantityInput.value = ++quantity;
                    updateTotalPrice();
                });
            });

            document.querySelectorAll('.decrement-button').forEach(button => {
                button.addEventListener('click', () => {
                    const quantityInput = button.nextElementSibling;
                    let quantity = parseInt(quantityInput.value, 10);
                    if (quantity > 1) {
                        quantityInput.value = --quantity;
                        updateTotalPrice();
                    }
                });
            });

            document.querySelectorAll('.remove-button').forEach(button => {
                button.addEventListener('click', () => {
                    const product = button.closest('.products');
                    if (product) {
                        product.style.display = 'none';
                        const addButton = document.querySelector(`.add-button[data-product-name="${product.getAttribute('data-product-id')}"]`);
                        if (addButton) {
                            addButton.disabled = false;
                            addButton.classList.remove('opacity-50');
                        }
                        updateTotalPrice();
                        updateChosenProductStatus();
                    }
                });
            });

            document.querySelectorAll('input[type="text"]').forEach(input => {
                input.addEventListener('input', updateTotalPrice);
            });

            updateTotalPrice();

            document.querySelectorAll('.add-button').forEach(button => {
                button.addEventListener('click', function() {
                    const productName = this.getAttribute('data-product-name');
                    const productPrice = this.getAttribute('data-product-price');
                    const orderProduct = document.querySelector(`#product-${productName}`);
                    if (orderProduct) {
                        orderProduct.querySelector('input[type="text"]').value = '1';
                        orderProduct.style.display = 'block';
                        this.disabled = true;
                        this.classList.add('opacity-50');
                        updateTotalPrice();
                        updateChosenProductStatus();
                    }
                });
            });
        });

        // Searching products filter
        function filterProducts() {
            let query = document.getElementById('search-input').value.toLowerCase();
            let products = document.getElementsByClassName('product-item');

            for (let i = 0; i < products.length; i++) {
                let productName = products[i].getAttribute('data-name').toLowerCase();
                if (productName.includes(query)) {
                    products[i].style.display = 'block';
                } else {
                    products[i].style.display = 'none';
                }
            }
        }
    </script>




    <!-- left section (Ordered items) -->
    <form action="/orders" method="POST">
        <!-- for admin make hidden input to store the id of the chosen user order -->
        <input type="hidden" id="selected-user" name="user-id" value="">
        <section class="sticky top-3 w-[32rem] bg-white mx-6 antialiased dark:bg-gray-200 p-4 rounded-lg">
            <div class=" mx-auto max-w-screen-xl px-4 2xl:px-0">
                <!-- order cart title -->
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl pl-2">Your order</h2>
                <!-- order section -->
                <div class="mt-6 md:gap-6 lg:flex lg:items-start xl:gap-8">
                    <!-- ordered items -->
                    <input id="productChosen" type="hidden" name="productChosen" value="false">
                    <div class="mx-auto w-full flex-none lg:max-w-2xl xl:max-w-4xl">
                        <div class="h-[155px] border border-gray-300 overflow-auto rounded-lg">
                            <?php foreach ($products as $product) : ?>
                                <?php $encodedName = str_replace(' ', '_', $product['name']); ?>
                                <!-- start of item -->

                                <div class="p-2 products border-b border-gray-100  bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800" data-product-id="<?php echo $encodedName; ?>" data-product-price="<?php echo $product['price']; ?>" id="product-<?php echo $encodedName; ?>" style="display: none;">
                                    <div class="md:flex md:items-center md:justify-between md:gap-6">
                                        <div class="flex items-center space-x-4 md:order-3">
                                            <button type="button" class="decrement-button border-2 border-gray-600 p-2 rounded-md bg-white hover:bg-gray-200 active:bg-gray-300 dark:border-white dark:bg-gray-800 dark:hover:bg-gray-700 dark:active:bg-gray-600" data-input-counter-decrement="counter-input-<?php echo $encodedName; ?>">
                                                <svg class="h-2.5 w-2.5 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                                                </svg>
                                            </button>
                                            <input name="quantities[<?php echo $product['name']; ?>]" type="text" id="counter-input-<?php echo $encodedName; ?>" class="w-12 shrink-0 border-0 bg-transparent text-center text-sm font-medium text-gray-900 focus:outline-none focus:ring-0 dark:text-white" value="0" required />
                                            <button type="button" class="increment-button border-2 border-gray-600 p-2 rounded-md bg-white hover:bg-gray-200 active:bg-gray-300 dark:border-white dark:bg-gray-800 dark:hover:bg-gray-700 dark:active:bg-gray-600" data-input-counter-increment="counter-input-<?php echo $encodedName; ?>">
                                                <svg class="h-2.5 w-2.5 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="text-end md:order-3 md:w-20 mt-2 md:mt-0">
                                            <p class="text-base font-bold product-price text-gray-900 dark:text-white"><?php echo $product['price']; ?></p>
                                        </div>
                                        <div class="w-full flex min-w-0 flex-1 items-center justify-between md:order-2 md:max-w-md">
                                            <div class="flex items-center space-x-2">
                                                <button type="button" class="remove-button inline-flex items-center text-sm font-medium text-red-600 hover:underline dark:text-red-500">
                                                    <svg class="me-1.5 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                                                    </svg>
                                                </button>
                                                <div class="text-base font-medium text-gray-900 hover:underline dark:text-white"><?php echo $product['name']; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- order notes -->
                        <div class="w-full">
                            <textarea name="notes" id="message" rows="2" placeholder="Additional Notes ..." spellcheck="false" class="w-full block p-2.5 my-5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                        </div>
                        <!-- choosing room -->
                        <div class="w-full flex items-center justify-between">
                            <label for="roomList" class="block w-1/3 font-bold text-sm text-gray-900 dark:text-white">Select Room</label>
                            <select name="room" id="roomList" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-2/3 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected="">Choose a room</option>
                                <option value="101">101</option>
                                <option value="102">102</option>
                            </select>
                        </div>

                        <!-- choosing delivery or in house -->
                        <div class="flex my-5 gap-6">
                            <div class="flex items-center">
                                <input id="default-radio-1" type="radio" value="in-house" name="type" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="default-radio-1" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">in-house</label>
                            </div>
                            <div class="flex items-center">
                                <input checked="" id="default-radio-2" type="radio" value="delivery" name="type" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="default-radio-2" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">delivery</label>
                            </div>
                        </div>

                        <div class="ms-4 mb-4">
                            <?php if (isset($errors['notes'])) : ?>
                                <li class="text-red-500 text-md"><?= $errors['notes'] ?></li>
                            <?php endif; ?>
                            <?php if (isset($errors['room'])) : ?>
                                <li class="text-red-500 text-md"><?= $errors['room'] ?></li>
                            <?php endif; ?>
                            <?php if (isset($errors['productChosen'])) : ?>
                                <li class="text-red-500 text-md"><?= $errors['productChosen'] ?></li>
                            <?php endif; ?>
                            <?php if (isset($errors['userChosen'])) : ?>
                                <li class="text-red-500 text-md"><?= $errors['userChosen'] ?></li>
                            <?php endif; ?>
                        </div>
                        <!-- order summary -->
                        <div class="mx-auto mt-6 max-w-4xl flex-1 space-y-6 lg:mt-0 lg:w-full">
                            <div class="space-y-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6 order-summary">
                                <!-- total -->
                                <dl class="flex items-center justify-between gap-4 border-gray-200 pt-2 dark:border-gray-700">
                                    <dt class="text-base font-bold text-gray-900 dark:text-white">Total</dt>
                                    <dd class="text-base font-bold text-gray-900 dark:text-white total-price"></dd>
                                </dl>
                                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"> Place Order</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </form>
    <!-- right section (Product list)-->
    <section class="w-[63%]">
        <!-- latest history part-->
        <div class="relative bg-gray-200 block px-4 pb-4 border-top border-gray-100 rounded-t-lg max-w-xlg me-6 ">
            <!-- colored border  -->
            <span class="absolute inset-x-0 bottom-0 h-[1%] bg-gray-300"></span>

            <div class="my-4">
                <div class="p-1 flex flex-wrap items-center justify-center product-list">
                    <?php if ($_SESSION['user']['role'] == 'user') : ?>
                        <h2 class="px-4 py-4 relative w-full text-black text-2xl font-bold pb-2 border-b-2 border-transparent">
                            Latest Order
                            <span class="mx-4 absolute inset-x-0 bottom-0 h-1 bg-gradient-to-r from-gray-400 via-gray-300 to-gray-200"></span>
                        </h2>
                        <!-- one product history-->
                        <?php foreach ($latestOrder as $order) : ?>
                            <?php
                            // fetching the product details from product array
                            $currentProduct;
                            foreach ($products as $product)
                                if ($product['name'] == $order['productname'])
                                    $currentProduct = $product;

                            ?>
                            <div class="w-[40%] max-w-4xl flex flex-row items-stretch m-6 relative overflow-hidden bg-teal-500 rounded-lg shadow-lg h-[100px]" data-name="margreta">
                                <!-- Decorative SVG Background -->
                                <svg class="absolute bottom-0 left-0 mb-8" viewBox="0 0 375 283" fill="none" style="transform: scale(1.5); opacity: 0.1;">
                                    <rect x="159.52" y="175" width="152" height="152" rx="8" transform="rotate(-45 159.52 175)" fill="white"></rect>
                                    <rect y="107.48" width="152" height="152" rx="8" transform="rotate(-45 0 107.48)" fill="white"></rect>
                                </svg>

                                <!-- Image Container -->
                                <div class="relative flex-shrink-0 w-1/3 flex items-center justify-center overflow-hidden">
                                    <div class="absolute w-full h-full bg-black opacity-0"></div>
                                    <img src="<?= "/serve_image_product.php?image=" . $currentProduct['image'] ?>" class="object-cover w-full h-full" alt="product_img">
                                </div>

                                <!-- Text and Price Container -->
                                <div class="relative w-2/3 px-4 pt-1 pb-2 flex flex-col justify-start">
                                    <!-- Product Details and Price -->
                                    <div class="flex justify-between items-center">
                                        <span class="text-white font-semibold text-xl font-bold"><?php echo $currentProduct['name'] ?></span>
                                        <span class="block bg-white mt-3 rounded-full text-teal-500 text-s font-bold px-3 py-2 leading-none flex items-center"><?php echo $currentProduct['price'] * $order['quantity'] ?>$</span>
                                    </div>
                                    <!-- Quantity Information -->
                                    <div class="text-white">
                                        <h1 class="text-white">Quantity: <?php echo $order['quantity'] ?></h1>
                                    </div>
                                </div>
                            </div>




                        <?php endforeach ?>
                    <?php else : ?>
                        <!--  -->
                        <div class="w-1/2 mx-auto flex my-4">
                            <label for="userlist" class="block w-1/3  text-center my-auto me-4 text-sm font-medium text-gray-900">Select User</label>
                            <!-- ahlan -->
                            <select name="selected-user-input" id="userlist" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected="" value="-1">Choose a user</option>
                                <?php foreach ($users as $user) : ?>
                                    <option value="<?php echo $user['id'] ?>"><?php echo $user['name'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    <?php endif ?>
                </div>

            </div>
        </div>
        <!-- products part -->
        <div class="relative mb-4 bg-gray-200 block px-4 py-4 border-bottom border-gray-100 rounded-b-lg max-w-xlg me-6">
            <div class="my-4">

                <!-- Search Form -->
                <div class="flex justify-between items-center w-full px-4 my-4 pb-6">
                    <h2 class="relative w-full text-black text-2xl font-bold pb-2 border-b-2 border-transparent">
                        Products
                        <span class="absolute inset-x-0 bottom-0 h-1 bg-gradient-to-r from-gray-400 via-gray-300 to-gray-200"></span>
                    </h2>

                    <div class="relative w-1/3">
                        <input type="text" id="search-input" oninput="filterProducts()" class="w-full h-12 shadow p-4 rounded-full dark:text-gray-600 dark:border-gray-700 dark:bg-gray-200 border-none placeholder-gray-400" placeholder="Search for products">
                        <svg class="pr-2 text-teal-400 h-5 w-5 absolute top-3.5 right-3 fill-current dark:text-teal-300" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve">
                            <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23
        s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92
        c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17
        s-7.626,17-17,17s-17-7.626-17-17S14.61,6,23.984,6z">
                            </path>
                        </svg>
                    </div>
                </div>


                <div class="products p-1 flex flex-wrap items-center justify-center">
                    <!-- one product -->
                    <?php foreach ($products as $product) : ?>
                        <?php $encodedName = str_replace(' ', '_', $product['name']); ?>
                        <div class="w-[220px] flex-shrink-0 m-6 relative overflow-hidden bg-teal-500 rounded-lg max-w-xs shadow-lg product-item h-80" data-name="<?php echo $product['name']; ?>">
                            <svg class="absolute bottom-0 left-0 mb-8" viewBox="0 0 375 283" fill="none" style="transform: scale(1.5); opacity: 0.1;">
                                <rect x="159.52" y="175" width="152" height="152" rx="8" transform="rotate(-45 159.52 175)" fill="white" />
                                <rect y="107.48" width="152" height="152" rx="8" transform="rotate(-45 0 107.48)" fill="white" />
                            </svg>
                            <div class="relative pt-10 px-10 flex items-center justify-center">
                                <div class="block absolute w-48 h-48 bottom-0 left-0 -mb-24 ml-3" style="background: radial-gradient(black, transparent 60%); transform: rotate3d(0, 0, 1, 20deg) scale3d(1, 0.6, 1); opacity: 0.2;">
                                </div>
                                <img class="w-3/4" src="<?= "/serve_image_product.php?image="  . $product['image'] ?>" alt="product_img">
                            </div>
                            <div class="relative text-white px-6 pb-6 mt-6">
                                <div class="flex justify-between items-start">
                                    <span class="block font-semibold text-2xl font-bold"><?php echo $product['name']; ?></span>
                                    <span class="block bg-white rounded-full text-teal-500 text-s font-bold px-3 py-2 leading-none flex items-center"><?php echo $product['price']; ?>$</span>
                                </div>
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 text-center p-4 dark:bg-gray-800">
                                <?php if ($product['productStatus'] == 'available') : ?>
                                    <button class="w-full add-button bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 rounded" data-product-name="<?php echo $encodedName; ?>" data-product-price="<?php echo $product['price']; ?>">Add</button>
                                <?php else : ?>
                                    <button class="w-full bg-gray-300 py-2 rounded-md cursor-not-allowed opacity-50" disabled>
                                        <h1 class="text-red-600">Unavailable</h1>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </section>


</main>

<?php view('/partials/foot.php') ?>