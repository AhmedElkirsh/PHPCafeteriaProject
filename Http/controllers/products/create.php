<?php

use Core\Session;

view("/products/create.view.php",[
    'errors' => Session::get('errors'),
]);