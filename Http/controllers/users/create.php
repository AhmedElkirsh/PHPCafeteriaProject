<?php

use Core\Session;

view("/users/create.view.php",[
    'errors' => Session::get('errors'),
]);