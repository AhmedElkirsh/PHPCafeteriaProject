<?php

use Core\Authenticator;
use Http\Forms\RegisterationForm;

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$photo = $_SESSION['photo'];
// validate input 
$form = new RegisterationForm;
if ($form->validate($name,$email,$password,$photo)) {
    if((new Authenticator)->attemptResgister($name,$email,$password,$photo)) {
        redirect('/');
    } else {
        $form->error('email','No matching account found for that email address and password');
    }
}
view('/registeration/create.view.php',[
    $form->errors()
]);