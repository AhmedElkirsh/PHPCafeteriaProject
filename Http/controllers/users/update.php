<?php

use Core\App;
use Core\Validator;
use Core\Database;

$db = App::resolve(Database::class);

if (isset($_POST['edit'])) {

    $id = isset($_POST['id']);
    $username = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $room = $_POST['room'];
    $ext = $_POST['ext'];
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
    $currentEmailData = $db->query("select email from user where email = :email", [
        'email' => $email
    ])->find();

    if ($currentEmailData === false || !is_array($currentEmailData)) {
        $errors['body'] = "User not found.";
    } else {
        $currentEmail = $currentEmailData['email'];

        if ($email !== $currentEmail) {
            $errors['body'] = "You can't change your email.";
        }
    }
    if (!empty($errors)) {
        return view("/users/edit.view.php", [
            'errors' => $errors,
            'id' => $id
        ]);
    }
    if (empty($errors)) {
        $updateQuery = $db->query("update user set name = :name, password = :password where email= :email", [
            'name' => $username,
            'email' => $currentEmail,
            'password' => $password,
        ]);
        if ($updateQuery) {
            header("Location: /users");
            exit();
        } else {
            echo "Error: Could not update the user.";
        }
    }
}
