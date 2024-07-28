<?php
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$note = $db->query("select * from notes where id=:id",['id'=>$_GET['id']])->findOrfail();
$currentUserId = 1;
authorize($note['user_id'] === $currentUserId); 
view("/notes/edit.view.php",[
    'heading' => "Edit Note",
    'note' => $note,
    'errors' => [],
]);