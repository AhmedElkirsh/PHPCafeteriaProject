<?php
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$note = $db->query("select * from notes where id=:id",['id'=>$_POST['id']])->findOrfail();
$currentUserId = 1;
authorize($note['user_id'] === $currentUserId);

$db->query("delete from notes where id=:id",[
    'id' => $_POST['id'],
]);
header("location: /notes");
exit;