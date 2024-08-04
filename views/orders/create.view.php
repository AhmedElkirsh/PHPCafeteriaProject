<?php view('/partials/head.php'); ?>
<?php view('/partials/nav.php'); ?>

<main>
    <form action="/orders" method="POST">
        <input type = "text" name = "test" >
        <input type = "text" name = "room" >
        <input type = "text" name = "test" >
        <input type = "text" name = "test" >
        <button type="submit">Test</button>
    </form>
</main>

<?php view('/partials/foot.php') ?>