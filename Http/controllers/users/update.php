<?php
use Core\App;
use Core\Authenticator;
use Core\Database;
use Core\Session;
use Http\Forms\EditUserForm;

$db = App::resolve(Database::class);
$form = EditUserForm::validateAttributes($attributes = [
    
    'name' => $_POST['name'],
    'password' => $_POST['password'],
    'passwordconfirm' => $_POST['passwordconfirm'],
    'image' => $_SESSION['image'],

]);

authorize(Session::get('user')['role'] === 'admin');

$notRegistered = (new Authenticator)->attemptEditUser($attributes['name'],$attributes['email'],$attributes['password'],$attributes['image'],$attributes['role']);


if(! $notRegistered ) {
    Session::flash('errors',[
        'email' => "there's already a user with that email"
    ]);
    Session::flash('old',[
        'email' => $_POST['email'],
        'name' => $_POST['name'],
    ]);
    redirect('/users/edit');

}

redirect('/users');