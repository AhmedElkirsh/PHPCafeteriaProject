<?php
// this class contains functions used to validate the formatting of inputs entered by the user via forms 
namespace Core;

class Validator {
    
    public static function password($value) {
        return preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/",$value);
    }
    public static function email($value) {
        return preg_match("/^\w+([\.-]?\w)+@\w+([\.]?\w)+(\.[a-zA-Z]{2,3})+$/",$value);
    }
    public static function name($value) {
        return preg_match("/^[A-Za-z]{3,}(?:[ '-][A-Za-z]{3,})*$/",$value);
    }
    public static function image($img) {

        $fileName = $img['name'];
        $fileSize = $img['size'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png'];

        if (!in_array($fileExtension, $allowedExtensions)) {         
            return false;
        }
        if ($fileSize > 1000000) {
            return false;
        }
        return true;
    }
    
}