<?php view('/partials/head.php'); ?>
<?php view('/partials/nav.php'); ?>
<main>

<?php foreach ($users as $user) :?>
    <ul>
   
        <li><?= $user['name'] ?></li>
        <li><?= $user['total_price'] ?></li>

    </ul>
<?php endforeach ?>
</main>

<?php view('/partials/foot.php') ?>