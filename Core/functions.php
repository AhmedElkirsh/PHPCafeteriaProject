<?php 
// this file contains helper functions that u can use throughout the project 
// hint: use dd() to check if a varaible is holding the value you expect when just creating a new file 
use Core\Response;

function dd($value) {
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
}

function isUrl($url) {
    return $_SERVER["REQUEST_URI"]===$url;
}

function abort($uri = 404) {
    http_response_code($uri);
    require base_path("views/{$uri}.php");
    exit;
} 

function authorize($condition, $status = Response::FORBIDDEN) {
    if (!$condition) {
        abort($status);
    }
} 

function base_path($path) {
    return BASE_PATH . $path;
}

function view($path,$attributes=[]) {
    extract($attributes);
    require BASE_PATH . "/views" . $path;
}

function redirect($path) {
    header("location: {$path}");
    die();
}