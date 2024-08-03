<?php

use Core\Session;

view('/registeration/create.view.php',[
    'errors' => Session::get('errors')
]);