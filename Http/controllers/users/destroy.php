<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$user = $db->query("select * from user where id= :id", ['id' => $_POST['id']])->find();
if (isset($_POST['delete'])) {

    $currentID = 1;
    authorize(1 === $currentID);

    $db->query("delete from user where id=:id", [
        'id' => $_POST['id'],
    ]);
}
$users = $db->query("select * from user")->get();
view("/users/index.view.php", [
    'users' => $users,
]);
