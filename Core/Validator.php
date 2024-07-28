<?php

namespace Core;

class Validator {
    public static function string($value,$min=1,$max=INF) {
        return strlen(trim($value))>=$min && strlen(trim($value))<=$max;
    }
    public static function email($value) {
        return preg_match("/^\w+([\.-]?\w)+@\w+([\.]?\w)+(\.[a-zA-Z]{2,3})+$/",$value);
    }
}