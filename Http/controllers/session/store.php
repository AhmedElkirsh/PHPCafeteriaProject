<?php

use Core\Authenticator;
use Http\Forms\LoginForm;

$form = LoginForm::validateAttributes($attributes = [
    'email' => $_POST['email'],
    'password' => $_POST['password'],
]);

$signedIn = (new Authenticator)->attemptLogin($attributes['email'],$attributes['password']);

if(! $signedIn) {
    $form->error('email','No matching account found for that email address and password')
    ->throw();
}

redirect('/');