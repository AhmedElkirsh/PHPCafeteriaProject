<?php

namespace Http\Forms;

use Core\Validator;

class RegisterationForm {
    protected $img = [];
    protected $errors = [];

    public function validate($name,$email,$password,$img) 
    {
        if (!Validator::email($email)) {
            $this->errors['email'] = 'Please provide a valid email address.';
        } 
        if (!Validator::password($password,1,255)) {
            $this->errors['password'] = 'Please provide a valid password.';
        } 
        if (!Validator::name($name)) {
            $this->errors['name'] = 'Please provide a valid name.';
        } 
        if (!Validator::image($img)) {
            $this->errors['image'] = 'Please provide a valid img.';
        } 
        return (empty($this->errors));
    }

    public function errors()
    {
        return $this->errors;
    }

    public function error($field,$message)
    {
        $this->errors[$field]=$message;
    }
}