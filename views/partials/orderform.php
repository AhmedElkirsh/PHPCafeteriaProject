<form action="/orders" method="POST" class="w-[35%]">
    <!-- User selection input with datalist -->
    <section class="sticky top-3 bg-secondary-50 mx-6 antialiased p-4 rounded-lg">
        <div class="md:gap-6 lg:flex lg:items-start xl:gap-8">
            <!-- Ordered items -->
            <input id="productChosen" type="hidden" name="productChosen" value="false">
            <div id="hidden_inputs"></div>
            <div class="mx-auto w-full flex-none lg:max-w-2xl xl:max-w-4xl">
                <!-- User input with datalist -->
                <?php if($_SESSION['user']['role']==='admin') : ?>
                    <div class="mb-4">
                    <input list="users" name="user-id" id="userList" class="bg-accent-50 text-text2 font-xs text-sm rounded-lg placeholder-accent-800 w-full p-4" placeholder="Start typing to search for users..." required>
                    <datalist id="users">
                        <?php foreach ($users as $user): ?>
                            <option value="<?= htmlspecialchars($user['id']); ?>"><?= htmlspecialchars($user['name']); ?></option>
                        <?php endforeach; ?>
                    </datalist>
                </div>
                <?php endif?>
                <!-- Ordered items list continues... -->
                <div class="blank h-[155px] border border-secondary-500 overflow-auto rounded-lg products-container">
                    <?php if($products) :?>
                        <div class="mylist flex justify-center items-center w-full h-full text-text2 font-medium">
                            No Items Added Yet!
                        </div>
                    <?php else :?>                         
                    <!-- elements will be added here -->
                    <?php endif ?>
                </div>
                <!-- Order notes -->
                <div class="w-full">
                    <textarea name="notes" id="message" rows="2" placeholder="Additional Notes ..." spellcheck="false" class="w-full block p-4 my-5 text-sm text-gray-900 bg-accent-50 rounded-lg resize-none placeholder-accent-800"></textarea>
                </div>
                <!-- Choosing delivery or in-house -->
                <div class="flex my-5 gap-5 w-full">
                    <div class="flex items-center bg-accent-50 hover:bg-secondary-200 py-4 px-4 basis-1/2 rounded-lg">
                        <input id="default-radio-1" type="radio" value="in-house" name="type" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                        <label for="default-radio-1" class="ms-2 text-sm font-medium text-gray-900">in-house</label>
                    </div>
                    <div class="flex items-center bg-accent-50 hover:bg-secondary-200 py-4 px-4 basis-1/2 rounded-lg">
                        <input id="default-radio-2" type="radio" value="delivery" name="type" checked class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                        <label for="default-radio-2" class="ms-2 text-sm font-medium text-gray-900">delivery</label>
                    </div>
                </div>
                <!-- Choosing room -->
                <div class="w-full flex items-center justify-between">
                    <label for="roomList" class="ml-6 block w-1/3 font-bold text-sm text-gray-900">Table No.</label>
                    <div class="custom-select-wrapper w-full">
                        <select name="room" id="roomList" class="bg-accent-50 text-rext2 text-sm font-medium rounded-lg w-full p-4" style="padding-right: 2.5rem; background-position: right 0.5rem center;">
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div> 
                </div>
                <!-- Error Handling -->
                <div class="ms-4 mb-4">
                    <?php foreach (['notes', 'room', 'productChosen', 'user-id'] as $error): ?>
                        <?php if (isset($errors[$error])): ?>
                            <li class="text-red-500 text-md"><?= $errors[$error] ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <!-- Order summary and total -->
                <div class="mx-auto mt-6 max-w-4xl flex-1 space-y-6 lg:mt-0 lg:w-full">
                    <div class="space-y-4 rounded-lg border border-secondary-500 bg-accent-50 p-4 shadow-sm sm:p-6 order-summary">
                        <dl class="flex items-center justify-between gap-4 border-gray-200 pt-2">
                            <dt class="text-base font-bold text-gray-900">Total</dt>
                            <dd id="total-price-display" class="text-base font-bold text-gray-900">$0.00</dd>
                        </dl>
                        <button type="submit" class="w-full bg-accent-900 hover:bg-accent-700 text-white font-semibold py-2 px-4 rounded">Place Order</button>
                    </div>
                </div>
            </div>
        </div>      
    </section>
</form>