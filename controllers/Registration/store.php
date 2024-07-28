<?php

use Core\App;
use Core\Database;
use Core\Validator;

$email = $_POST['email'];
$password = $_POST['password'];

// validate input 
$errors = [];
if(!Validator::string($password,7,255)) {
    $errors['password']="please enter a valid password";
}

if(!Validator::email($email)) {
    $errors['email']="please enter a valid password";
}

if(! empty($errors)) {
    view('Registration/create.view.php',[
        'errors' => $errors,
    ]);
    exit();
}

$db = App::resolve(Database::class);
$user = $db->query("select * from users where email=:email",[
    'email' => $email,
])->find();

if ($user) {
    header('location: /');
    exit();
} else {
    $db->query('insert into users (email, password) values (:email,:password)',[
        'email' => $email,
        'password' => $password,
    ]);
    $_SESSION['user'] = [
        'email' => $email
    ];
    header('location: /');
}
