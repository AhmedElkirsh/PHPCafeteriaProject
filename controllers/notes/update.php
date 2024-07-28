<?php
use Core\Database;
use Core\Validator;
use Core\App;

$db = App::resolve(Database::class);

$currentUserId = 1;

$note = $db->query("select * from notes where id=:id",[
    'id'=>$_POST['id']
])->findOrfail();

authorize($note['user_id'] === $currentUserId);


$errors =[];

if (! Validator::string($_POST['body'],1,1000)) {
    $errors['body']='Body length must not exceed 1000 characters';
}

if (! empty($errors)) {
    return view("/notes/edit.view.php",[
        'heading' => "Edit Note",
        'errors' => $errors,
        'body' => $_POST['body'],
        'note' => $note
    ]);
}

$db->query("update notes set body=:body where id=:id",[
    'body' => $_POST['body'],
    'id' => $_POST['id']
]);
header('location: /notes');
die();