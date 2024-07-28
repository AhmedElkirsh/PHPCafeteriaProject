<?php view('/partials/start.php'); ?>
<?php view('/partials/nav.php') ?>

<main>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <p class="mb-6">
            <a href="/notes" class="text-blue-500 undrline">Go back...</a>
        </p>
        <p><?= htmlspecialchars($note['body'])?></p>
        <footer>
            <a href="/note/edit?id=<?= $note['id'] ?>" class="text-grey-500 border border-current">Edit</a>
        </footer>
    </div>
</main>

<?php view('/partials/footer.php') ?>
<?php view('/partials/end.php') ?>