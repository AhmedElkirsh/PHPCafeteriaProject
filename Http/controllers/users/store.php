<?php
use Core\App;
use Core\Authenticator;
use Core\Database;
use Core\Session;
use Http\Forms\AddUserForm;

$db = App::resolve(Database::class);
$form = AddUserForm::validateAttributes($attributes = [
    
    'name' => $_POST['name'],
    'email' => $_POST['email'],
    'password' => $_POST['password'],
    'passwordconfirm' => $_POST['passwordconfirm'],
    'role' => $_POST['role'],
    'image' => $_SESSION['image'],

]);

authorize(Session::get('user')['role'] === 'admin');

$notRegistered = (new Authenticator)->attemptAddUser($attributes['name'],$attributes['email'],$attributes['password'],$attributes['image'],$attributes['role']);
if(! $notRegistered ) {

    Session::flash('errors',[
        'email' => "there's already a user with that email"
    ]);
    
    Session::flash('old',[
        'email' => $_POST['email'],
        'name' => $_POST['name'],
        'role' => $_POST['role'],
    ]);
    redirect('/users/create');

}

redirect('/users');

