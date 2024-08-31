<?php view('/partials/head.php'); ?>
<?php view('/partials/nav.php'); ?>
<style>
    .custom-select-wrapper {
    position: relative; 
    display: inline-block;
    }

    .custom-select-wrapper::after {
        content: ""; 
        position: absolute;
        right: 16px; 
        top: 50%; 
        transform: translateY(-50%); 
        pointer-events: none;
        width: 16px; 
        height: 16px; 
        background: url('data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20fill%3D%22none%22%20stroke%3D%22currentColor%22%20stroke-width%3D%221.5%22%20class%3D%22size-6%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20d%3D%22m19.5%208.25-7.5%207.5-7.5-7.5%22%2F%3E%3C%2Fsvg%3E') no-repeat center;
        background-size: contain;
    }
    select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background: transparent;
        padding: 10px; 
        font-size: 16px;
        position: relative; 
        padding-right: 30px;
    }

    #hidden_inputs {
    position: absolute; /* Takes the element out of the normal flow */
    top: -9999px; /* Moves it far off the screen */
    left: -9999px; /* Moves it far off the screen */
    visibility: hidden; /* Hides the element but still allows form submission */
}

</style>
<main class="flex justify-between w-full mt-4">
    
    <!-- Order Form -->
    <?php view('/partials/orderform.php',[
        'products'=>$products,
        'users' => $users,
    ]); ?>
    <!-- Product Section -->
    <section class="relative mb-4 bg-secondary-50 block px-4 py-4 border-bottom border-gray-100 rounded-lg max-w-xlg me-6 w-[67%] ">
        
        <!-- Filtering -->
        <div class="flex gap-4 items-center w-full">
            <!-- Choosing category -->
            <div class="custom-select-wrapper flex items-center justify-between basis-1/4">
                <select name="room" id="category" class="bg-accent-50 text-text2 text-sm rounded-lg w-full p-4">
                    <option value="all">All</option>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category['categoryid'] ?>"><?= $category['categoryname'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <!-- Later Order (if "user") -->
            <?php if ($_SESSION['user']['role']==='user') :?>          
                <div class="rounded-lg p-4 bg-accent-50 text-text2 text-sm" style="flex-basis: 24.5%;">
                    Lastest Order
                </div> 
            <?php else : ?>
                <div class="none rounded-lg p-4 opacity-0 text-sm" style="flex-basis: 24.5%;">
                    testing
                </div> 
            <?php endif ?>
            <!-- searching for product -->
            <div class="relative" style="flex-basis: 52%;">
                <input 
                    id="search-input" 
                    class="bg-accent-50 placeholder-accent-800 text-sm rounded-lg w-full p-4" 
                    placeholder="Start typing to search for Products..." 
                    required 
                    oninput="filterProducts()"
                >
                <svg class="pr-2 text-accent-800 size-7 absolute top-1/2 right-2 transform -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path 
                        stroke-linecap="round" 
                        stroke-linejoin="round" 
                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" 
                    />
                </svg>
            </div>
        </div>
        <!-- products container -->
        <div class="flex flex-wrap gap-4 mt-4">
    <!-- one product -->
    <?php foreach ($products as $product) : ?>
        <?php $encodedName = str_replace(' ', '_', $product['name']); ?>
        <div id="<?= "product-" . str_replace(' ', '-' , $product['name'])  ?>" style="flex-basis: calc(25% - 12px);" class=" relative overflow-hidden bg-accent-600 rounded-lg shadow-lg product-item h-60" data-name="<?= $product['name']; ?>" data-category="<?= $product['categoryid']; ?>" data-product-price="<?= $product['price']?>" >
            <svg class="absolute bottom-0 left-0 mb-8" viewBox="0 0 375 283" fill="none" style="transform: scale(1.5); opacity: 0.1;">
                <rect x="159.52" y="175" width="152" height="152" rx="8" transform="rotate(-45 159.52 175)" fill="white" />
                <rect y="107.48" width="152" height="152" rx="8" transform="rotate(-45 0 107.48)" fill="white" />
            </svg>
            <div class="relative p-8 flex items-center justify-center">
                <div class="block absolute w-48 h-48 bottom-0 left-0 -mb-24 ml-3" style="background: radial-gradient(black, transparent 60%); transform: rotate3d(0, 0, 1, 20deg) scale3d(1, 0.6, 1); opacity: 0.2;">
                </div>
                <img class="size-24 object-contain" src="<?= "/serve_image_product.php?image="  . $product['image'] ?>" alt="product_img">
            </div>
            <div class="relative text-white px-6 ">
                <div class="flex justify-between items-start h-[56px]">
                    <span class="block font-semibold text-lg font-semibold"><?php echo $product['name']; ?></span>
                    <span class="block bg-white rounded-lg text-accent-800 text-sm font-bold px-2 py-2 leading-none flex items-center self-stretch"><?= $product['price']; ?>$</span>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>



    
    </section>
</main>
<!-- Script for + and - buttons, adding and removing products, and updating total price -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    const updateProductVisibility = (encodedName, quantity) => {
        const productElement = document.getElementById(`chosenproduct-${encodedName}`);
        const productCard = document.getElementById(`product-${encodedName}`);
        if (productElement) {
            if (quantity > 0) {
                productElement.style.display = 'block';
            } else {
                productElement.remove();
                if (productCard) {
                    productCard.classList.remove("opacity-50");
                    productCard.classList.add("opacity-100");
                    productCard.style.pointerEvents = "auto";
                }
            }
            updateChosenProductStatus(); 
        }
    };

    const updateTotalPrice = () => {
        let total = 0;
        document.querySelectorAll('.products').forEach((product) => {
            if (product.style.display !== 'none') {
                const price = parseFloat(product.getAttribute("data-product-price"));
                const quantityInput = product.querySelector('input[type="text"]');
                const quantity = parseInt(quantityInput.value, 10);
                total += price * quantity;
            }
        });
        const totalPriceElement = document.querySelector(".order-summary .total-price");
        if (totalPriceElement) {
            totalPriceElement.textContent = `$${total.toFixed(2)}`;
        }
    };

    const updateTotalTotalPrice = () => {
        // Select the <dd> element where the total price should be displayed
        const totalPriceElement = document.querySelector("#total-price-display");
        if (totalPriceElement) {
            // Calculate the total price
            let total = 0;
            document.querySelectorAll('.products').forEach((product) => {
                if (product.style.display !== 'none') {
                    const price = parseFloat(product.getAttribute("data-product-price"));
                    const quantityInput = product.querySelector('input[type="text"]');
                    const quantity = parseInt(quantityInput.value, 10);
                    total += price * quantity;
                }
            });
            // Update the <dd> element with the total price
            totalPriceElement.textContent = `$${total.toFixed(2)}`;
        }
    };

    const addProductElement = (encodedName, price, name) => {
        const productsContainer = document.querySelector(".products-container");
        if (!productsContainer) {
            console.error("Container `.products-container` not found.");
            return;
        }

        const existingProduct = document.getElementById(`chosenproduct-${encodedName}`);
        if (existingProduct) {
            const inputElement = existingProduct.querySelector('input[type="text"]');
            if (inputElement) {
                inputElement.value = "1";
            }
            return;
        }

        const myList = productsContainer.querySelector(".mylist");
        if (myList) {
            myList.remove();
        }

        const productHTML = `
    <div class="px-2 py-4 products border-b border-gray-100 bg-white shadow-sm " 
        data-product-id="${encodedName}" 
        data-product-price="${price}" 
        id="chosenproduct-${encodedName}" 
        style="display: block;">
        <div class="flex items-center " style="justify-content: flex-end; gap: 10px" >
            <!-- Close Button and Product Name -->
            <div class="flex items-center space-x-2" style="margin-right: auto">
                <button type="button" class="remove-button inline-flex items-center text-sm font-medium text-red-600 hover:underline">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
                <div class="text-base truncate font-medium text-gray-900 hover:underline">${name}</div>
            </div>
            
            <!-- Quantity Controls -->
            <div class="flex items-center space-x-1">
                <button type="button" class="decrement-button" data-input-counter-decrement="counter-input-${encodedName}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </button>
                <input name="quantities[${name}]" type="text" id="counter-input-${encodedName}" 
                    class="w-12 shrink-0 border-0 bg-transparent text-center text-sm font-medium text-gray-900 focus:outline-none focus:ring-0" 
                    value="1" required>
                <button type="button" class="increment-button" data-input-counter-increment="counter-input-${encodedName}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </button>
            </div>
            
            <!-- Product Price -->
            <div class="text-end font-bold product-price text-gray-900" style="width: 40px">$${price}</div>
        </div>
    </div>
`;


        productsContainer.insertAdjacentHTML('beforeend', productHTML);

        bindEventListeners(); // Re-bind event listeners to the newly added product
    };

    const bindEventListeners = () => {
        document.querySelectorAll(".increment-button").forEach((button) => {
            button.addEventListener("click", () => {
                const inputId = button.getAttribute("data-input-counter-increment");
                const inputElement = document.getElementById(inputId);
                if (inputElement) {
                    let quantity = parseInt(inputElement.value, 10);
                    inputElement.value = ++quantity;
                    updateTotalPrice();
                    updateTotalTotalPrice(); //called here
                }
            });
        });

        document.querySelectorAll(".decrement-button").forEach((button) => {
            button.addEventListener("click", () => {
                const inputId = button.getAttribute("data-input-counter-decrement");
                const inputElement = document.getElementById(inputId);
                if (inputElement) {
                    let quantity = parseInt(inputElement.value, 10);
                    if (quantity > 0) {
                        inputElement.value = --quantity;
                        const encodedName = inputId.replace("counter-input-", "");
                        updateProductVisibility(encodedName, quantity);
                        updateTotalPrice();
                        updateTotalTotalPrice(); //called here
                    }
                }
            });
        });

        document.querySelectorAll(".remove-button").forEach((button) => {
            button.addEventListener("click", () => {
                const productElement = button.closest(".products");
                if (productElement) {
                    const inputElement = productElement.querySelector('input[type="text"]');
                    if (inputElement) {
                        inputElement.value = "0";
                        const encodedName = inputElement.id.replace("counter-input-", "");
                        updateProductVisibility(encodedName, 0);
                        updateTotalPrice();
                        updateTotalTotalPrice();
                    }
                }
            });
        });
    };

    const updateChosenProductStatus = () => {
        const orderedProducts = document.querySelectorAll('.products[style="display: block;"]');
        const chosenProductInput = document.querySelector("#productChosen");
        if (chosenProductInput) {
            if (orderedProducts.length > 0) {
                chosenProductInput.value = "true";
            } else {
                chosenProductInput.value = "false";
                const Blank = document.querySelector(".blank");
                Blank.innerHTML = `<div class="mylist flex justify-center items-center w-full h-full text-text2 font-medium">
                    No Items Added Yet!
                </div>`;
            }
        }
    };

    const filterProducts = () => {
        const searchQuery = document.getElementById("search-input").value.toLowerCase();
        const selectedCategory = document.getElementById("category").value;
        const products = document.querySelectorAll(".product-item");

        products.forEach((product) => {
            const productName = product.getAttribute("data-name").toLowerCase();
            const productCategory = product.getAttribute("data-category");
            const isCategoryMatch = selectedCategory === "all" || productCategory === selectedCategory;
            const isSearchMatch = productName.includes(searchQuery);

            product.style.display = isCategoryMatch && isSearchMatch ? "block" : "none";
        });
    };

    bindEventListeners();

    document.getElementById("search-input").addEventListener("input", filterProducts);
    const categorySelect = document.getElementById("category");
    if (categorySelect) {
        categorySelect.addEventListener("change", filterProducts);
    }

    document.querySelectorAll(".product-item").forEach((card) => {
        card.addEventListener("click", function () {
            const productName = this.getAttribute("data-name").replace(/ /g, "-");
            const productPrice = this.getAttribute("data-product-price");

            this.classList.add("opacity-50");
            this.classList.remove("opacity-100");
            this.style.pointerEvents = "none";

            addProductElement(productName, productPrice, this.getAttribute("data-name"));
            updateTotalPrice();
            updateChosenProductStatus();
            updateTotalTotalPrice() // called here
        });
    });

    function collectList(event) {
    // Prevent the default form submission
    event.preventDefault();

    // Select all product elements
    let products = Array.from(document.querySelectorAll('.products'));

    // Clear any existing hidden inputs
    let container = document.querySelector('#hidden_inputs');
    container.innerHTML = ''; // Clear existing hidden inputs

    products.forEach(product => {
        // Extract product id and quantity
        let name = product.getAttribute('data-product-id');
        let quantityElement = document.querySelector(`#counter-input-${name}`);
        let quantity = quantityElement ? quantityElement.value : '0'; // Handle case where quantityElement is not found

        // Create and append hidden input for each product
        let input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = quantity;
        container.appendChild(input);
        
    });

    // Now submit the form
    event.target.submit();
}

// Add event listener to the form
document.querySelector('form').addEventListener('submit', collectList);


});
</script>
<?php view('/partials/foot.php') ?>