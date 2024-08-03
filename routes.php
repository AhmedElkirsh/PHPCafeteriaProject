<?php
// to create a route for a controller follow the conventions bellow, meaning note the request type (get, destroy, patch, post) 
// and note convention of the naming of the files and folders, below is a commented out example to follow
// very small changes might apply in the future 
$router->get('/','orders/create.php');

$router->get('/register','registeration/create.php')->only('guest');
$router->post('/register', 'registeration/store.php')->only('guest');

$router->get('/login', 'session/create.php')->only('guest');
$router->post('/session', 'session/store.php')->only('guest');
$router->destroy('/session', 'session/destroy.php')->only('auth');

$router->get('/checks', 'checks/index.php');
$router->post('/checks', 'checks/show.php');
$router->post('/checks/order', 'checks/showOrder.php');

$router->get('/users', 'users/index.php');
$router->destroy('/users/destroy', 'users/destroy.php');

$router->post('/users/edit', 'users/edit.php');

$router->get('/users/create', 'users/create.php');
$router->post('/users', 'users/store.php');

$router->patch('/users', 'users/update.php');

$router->get('/products', 'products/index.php');
$router->destroy('/products/destroy', 'products/destroy.php');

$router->post('/products/edit', 'products/edit.php');

$router->get('/products/create', 'products/create.php');
$router->post('/products', 'products/store.php');
$router->patch('/products', 'products/update.php');