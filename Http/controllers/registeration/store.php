<?php

use Core\Authenticator;
use Core\Session;
use Http\Forms\RegisterationForm;

$form = RegisterationForm::validateAttributes($attributes = [

    'name' => $_POST['name'],
    'email' => $_POST['email'],
    'password' => $_POST['password'],
    'image' => $_SESSION['image'],
    
]);

$notRegistered = (new Authenticator)->attemptResgister($attributes['name'],$attributes['email'],$attributes['password'],$attributes['image']);

if(! $notregistered) {
    Session::flash('errors',[
        'email' => 'you already have an account'
    ]);
    Session::flash('old',[
        'email' => $_POST['email'],
        'name' => $_POST['name']
    ]);
    redirect('/login');
};

redirect('/');