<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
// $heading = "add user";

view("/users/create.view.php", []);
