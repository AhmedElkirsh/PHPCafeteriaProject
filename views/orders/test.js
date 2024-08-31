document.addEventListener("DOMContentLoaded", () => {
  // Function to update visibility of the product in the list
  const updateProductVisibility = (encodedName, quantity) => {
    const productElement = document.getElementById(`product-${encodedName}`);
    if (productElement) {
      productElement.style.display = quantity > 0 ? "block" : "none";
    }
  };

  // Function to update total price after changing the quantity
  const updateTotalPrice = () => {
    let total = 0;
    document
      .querySelectorAll('.products[style="display: block;"]')
      .forEach((product) => {
        const price = parseFloat(product.getAttribute("data-product-price"));
        const quantityInput = product.querySelector('input[type="text"]');
        const quantity = parseInt(quantityInput.value, 10);
        total += price * quantity;
      });
    const totalPriceElement = document.querySelector(
      ".order-summary .total-price"
    );
    if (totalPriceElement) {
      totalPriceElement.textContent = `$${total.toFixed(2)}`;
    }
  };

  // Function to add a new product element using innerHTML
  const addProductElement = (encodedName, price, name) => {
    const productsContainer = document.querySelector(".products-container"); // Ensure this matches your container class

    if (!productsContainer) {
      console.error("Container `.products-container` not found.");
      return;
    }

    // Remove the "No Items Added Yet!" message if it exists
    const myList = productsContainer.querySelector(".mylist");
    if (myList) {
      myList.remove();
    }

    // Create the outer div
    const productDiv = document.createElement("div");
    productDiv.className =
      "p-2 products border-b border-gray-100 bg-white shadow-sm";
    productDiv.setAttribute("data-product-id", encodedName);
    productDiv.setAttribute("data-product-price", price);
    productDiv.id = `product-${encodedName}`;
    productDiv.style.display = "block";

    // Create the inner content
    const innerDiv = document.createElement("div");
    innerDiv.className = "md:flex md:items-center md:justify-between md:gap-6";

    // Quantity Increment/Decrement Buttons
    const quantityDiv = document.createElement("div");
    quantityDiv.className = "flex items-center space-x-4 md:order-3";

    const decrementButton = document.createElement("button");
    decrementButton.type = "button";
    decrementButton.className =
      "decrement-button border-2 border-gray-600 p-2 rounded-md bg-white hover:bg-gray-200 active:bg-gray-300";
    decrementButton.setAttribute(
      "data-input-counter-decrement",
      `counter-input-${encodedName}`
    );
    decrementButton.innerHTML = `
        <svg class="h-2.5 w-2.5 text-gray-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
        </svg>
    `;

    const incrementButton = document.createElement("button");
    incrementButton.type = "button";
    incrementButton.className =
      "increment-button border-2 border-gray-600 p-2 rounded-md bg-white hover:bg-gray-200 active:bg-gray-300";
    incrementButton.setAttribute(
      "data-input-counter-increment",
      `counter-input-${encodedName}`
    );
    incrementButton.innerHTML = `
        <svg class="h-2.5 w-2.5 text-gray-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
        </svg>
    `;

    const quantityInput = document.createElement("input");
    quantityInput.name = `quantities[${name}]`;
    quantityInput.type = "text";
    quantityInput.id = `counter-input-${encodedName}`;
    quantityInput.className =
      "w-12 shrink-0 border-0 bg-transparent text-center text-sm font-medium text-gray-900 focus:outline-none focus:ring-0";
    quantityInput.value = "1";
    quantityInput.required = true;

    quantityDiv.append(decrementButton, quantityInput, incrementButton);

    // Price Display
    const priceDiv = document.createElement("div");
    priceDiv.className = "text-end md:order-3 md:w-20 mt-2 md:mt-0";
    const priceP = document.createElement("p");
    priceP.className = "text-base font-bold product-price text-gray-900";
    priceP.textContent = price;
    priceDiv.append(priceP);

    // Product Name and Remove Button
    const detailsDiv = document.createElement("div");
    detailsDiv.className =
      "w-full flex min-w-0 flex-1 items-center justify-between md:order-2 md:max-w-md";

    const detailsInnerDiv = document.createElement("div");
    detailsInnerDiv.className = "flex items-center space-x-2";

    const removeButton = document.createElement("button");
    removeButton.type = "button";
    removeButton.className =
      "remove-button inline-flex items-center text-sm font-medium text-red-600 hover:underline";
    removeButton.innerHTML = `
        <svg class="me-1.5 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L17.94 6M18 18L6.06 6" />
        </svg>
    `;

    const nameDiv = document.createElement("div");
    nameDiv.className = "text-base font-medium text-gray-900 hover:underline";
    nameDiv.textContent = name;

    detailsInnerDiv.append(removeButton, nameDiv);
    detailsDiv.append(detailsInnerDiv);

    // Append all parts to the main productDiv
    innerDiv.append(quantityDiv, priceDiv, detailsDiv);
    productDiv.append(innerDiv);

    // Append the new productDiv to the container
    productsContainer.appendChild(productDiv);

    // Re-bind event listeners for newly added buttons
    bindEventListeners();
  };

  // Function to bind event listeners for increment, decrement, and remove buttons
  const bindEventListeners = () => {
    document.querySelectorAll(".increment-button").forEach((button) => {
      button.addEventListener("click", () => {
        const inputId = button.getAttribute("data-input-counter-increment");
        const inputElement = document.getElementById(inputId);
        if (inputElement) {
          let quantity = parseInt(inputElement.value, 10);
          inputElement.value = ++quantity;

          const encodedName = inputId.replace("counter-input-", "");
          updateProductVisibility(encodedName, quantity);
          updateTotalPrice();
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
          }
        }
      });
    });

    document.querySelectorAll(".remove-button").forEach((button) => {
      button.addEventListener("click", () => {
        const productElement = button.closest(".products");
        if (productElement) {
          const inputElement =
            productElement.querySelector('input[type="text"]');
          if (inputElement) {
            inputElement.value = "0";

            const encodedName = inputElement.id.replace("counter-input-", "");
            updateProductVisibility(encodedName, 0);
            updateTotalPrice();
          }
        }
      });
    });
  };

  // Function to update the chosen product status
  const updateChosenProductStatus = () => {
    const orderedProducts = document.querySelectorAll(
      '.products[style="display: block;"]'
    );
    const chosenProductInput = document.querySelector("#productChosen");
    if (chosenProductInput) {
      if (orderedProducts.length > 0) {
        chosenProductInput.value = "true";
      } else {
        chosenProductInput.value = "false";
        const Blank = document.querySelector(".blank");
        Blank.innerHTML = `No Items Added Yet!`;
      }
    }
  };

  // Function to filter products based on search and category
  const filterProducts = () => {
    const searchQuery = document
      .getElementById("search-input")
      .value.toLowerCase();
    const selectedCategory = document.getElementById("category").value;
    const products = document.querySelectorAll(".product-item");

    products.forEach((product) => {
      const productName = product.getAttribute("data-name").toLowerCase();
      const productCategory = product.getAttribute("data-category");
      const isCategoryMatch =
        selectedCategory === "all" || productCategory === selectedCategory;
      const isSearchMatch = productName.includes(searchQuery);

      product.style.display =
        isCategoryMatch && isSearchMatch ? "block" : "none";
    });
  };

  // Initial binding of event listeners
  bindEventListeners();

  // Event listeners for input changes and search functionality
  document
    .getElementById("search-input")
    .addEventListener("input", filterProducts);
  const categorySelect = document.getElementById("category");
  if (categorySelect) {
    categorySelect.addEventListener("change", filterProducts);
  }

  // Example of adding a new product element (use with actual data)
  // addProductElement('example-product', '9.99', 'Example Product');

  document.querySelectorAll(".product-item").forEach((card) => {
    card.addEventListener("click", function () {
      // Get product attributes
      const productName = this.getAttribute("data-name").replace(/ /g, "-");
      const productPrice = this.getAttribute("data-product-price");
      const orderProduct = document.querySelector(`#product-${productName}`);

      if (orderProduct) {
        // Update the quantity and show the product
        const inputField = orderProduct.querySelector('input[type="text"]');
        if (inputField) {
          inputField.value = "1";
        }
        // Disable the card
        this.classList.add("opacity-50");
        this.style.pointerEvents = "none";

        // Update total price and chosen product status
        addProductElement(
          productName,
          productPrice,
          this.getAttribute("data-name")
        );
        const Blank = document.querySelector(".mylist");
        Blank.innerHTML = "";
      } else {
        console.log(`Order product with ID #product-${productName} not found.`);
      }
    });
  });
});
