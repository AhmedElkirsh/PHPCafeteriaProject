<?php view('/partials/head.php'); ?>
<?php view('/partials/nav.php'); ?>
<main>

<?php foreach ($users as $user) :?>
    <ul>
        <li><?= $user['id'] ?></li>
        <li><?= $user['name'] ?></li>
        <li><?= $user['email'] ?></li>
        <li><?= $user['role'] ?></li>
`    </ul>
<?php endforeach ?>
</main>

<?php view('/partials/foot.php') ?>