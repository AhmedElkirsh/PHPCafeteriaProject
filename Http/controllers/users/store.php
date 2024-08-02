<?php

use Core\App;
use Core\Validator;
use Core\Database;

$db = App::resolve(Database::class);
if (isset($_POST['submit'])) {
    $username = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    $errors = [];
    if (!Validator::name($username, 1, 10)) {
        $errors['body'] = "Username must be between 1 and 10 characters.";
    }
    if (!Validator::password($password)) {
        $errors['body'] = "Password must be at least 8 characters long and include at least one letter and one number.";
    }
    if ($password !== $confirmPassword) {
        $errors['body'] = "Passwords do not match.";
    }
    if (!Validator::email($email)) {
        $errors['body'] = "Please enter a valid email address.";
    }
    $existingUser = $db->query("select * from user where email = :email", [
        'email' => $email,
    ])->find();

    if ($existingUser) {
        $errors['body'] = "Email already exists. Please choose another email.";
    }

    if (!empty($errors)) {
        return view("/users/create.view.php", [
            'errors' => $errors,
        ]);
    }
}
if (empty($errors)) {
    $db->query("insert into user (name, email, password, role) VALUES (:name, :email,:password,:role)", [
        'name' => $_POST["name"],
        'email' => $_POST["email"],
        'password' => $_POST["password"],
        'role' => "user",
    ]);
}
