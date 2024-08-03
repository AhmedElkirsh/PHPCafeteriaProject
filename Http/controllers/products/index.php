<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$products->query("select * from products")->get();