<?php
use Core\App;
use Core\Authenticator;
use Core\Database;
use Core\Session;
use Http\Forms\ProductForm;
$db = App::resolve(Database::class);

$form = ProductForm::validateAttributes($attributes = [
    
    'name' => $_POST["name"],
    'price' => $_POST["price"],
    'category' => $_POST["categoryname"],
    'time' => $_POST["time"],
    'status' => $_POST["productStatus"],
    'img'=>$_SESSION["image"],

]);
authorize(Session::get('user')['role'] === 'admin');
$Exists = (new Authenticator)->attemptEditProduct($attributes['name'],$attributes['category'],$attributes['price'],$attributes['time'],$attributes['status'],$attributes['img']);
if(! $Exists ) {
    
    Session::flash('errors',[
        'name' => "there's no product with that name"
    ]);
    Session::flash('old',[
        'price' => $_POST['price'],
        'productStatus' => $_POST['productStatus'],
        'time' => $_POST['time'],
        'name' => $_POST['name'],
        'status' => $_POST["status"],
    ]);
    redirect('/products/edit');

}

redirect('/products');