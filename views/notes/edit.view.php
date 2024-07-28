<?php view('/partials/start.php'); ?>
<?php view('/partials/nav.php') ?>
<?php view('/partials/header.php',[
    'heading' => $heading,
]) ?>

<main>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <form method="POST" action="/note">
            <input type="hidden" name="id" value=<?= $note['id'] ?>>
            <input type="hidden" name="_method" value="PATCH">
            <div class="col-span-full">
                <label for="about" class="block text-sm font-medium leading-6 text-gray-900">Note</label>
                <div class="mt-2">
                    <textarea id="note" name="body" rows="3" 
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    ><?= $body ?? $note['body'] ?></textarea>
                </div>
            </div>
            <?php if(!empty($errors)): ?>
                <p class="text-red-500 text-xs mt-2"><?=$errors['body']?></p>
            <?php endif ?> 
            <div class="mt-6 flex items-center justify-end gap-x-6">
                
                <a href="/notes" class="rounded-md bg-gray-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Cancel</a>
                <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Update</button>
            </div>
        </form>
        <form action="/note" class="mt-6" method="POST">
                    <input type="hidden" name="_method" value="DESTROY">
                    <input type="hidden" name="id" value=<?= $note['id'] ?>>
                    <button class="text-ms text-red-500">Delete Note</button>
        </form>
    </div>
</main>

<?php view('/partials/footer.php') ?>
<?php view('/partials/end.php') ?>