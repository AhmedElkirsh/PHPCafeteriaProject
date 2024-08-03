<?php 
session_start();

use Core\Router;
use Core\Session;
use Core\ValidationException;

const BASE_PATH = __DIR__ . "/../" ;
require BASE_PATH . 'Core/functions.php';

spl_autoload_register(function($class){
    $class = str_replace('\\',DIRECTORY_SEPARATOR,$class);
    require base_path("{$class}.php");
});

require base_path('bootstrap.php');

$_SESSION['image'] = $_FILES['photo']??[];

$router = new Router();
$routes = require base_path('routes.php');

$uri = parse_url($_SERVER["REQUEST_URI"])["path"];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

try {

    $router->route($uri,$method);

} catch (ValidationException $exception) {
    
    Session::flash('old',$exception->old);
    Session::flash('errors', $exception->errors);
    return redirect($router->previousUrl());
    
}

Session::unflash();