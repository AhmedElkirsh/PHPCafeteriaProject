<?php
use Core\Database;
use Core\Validator;
use Core\App;

$db = App::resolve(Database::class);

$errors =[];

if (! Validator::string($_POST['body'],1,1000)) {
    $errors['body']='Body length must not exceed 1000 characters';
}

if (! empty($errors)) {
    return view("/notes/create.view.php",[
        'heading' => "Create Note",
        'errors' => $errors,
    ]);
}

if (empty($errors)) {
    $db->query("insert into notes (body,user_id) values (:body, :id)",[
        'body' => $_POST['body'],
        'id' => 1
    ]);
    header('location: /notes');
    die();
}