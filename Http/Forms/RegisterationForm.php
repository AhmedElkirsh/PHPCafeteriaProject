<?php

namespace Http\Forms;

use Core\Validator;

class RegisterationForm extends Form{

    protected function validate() 
    {
        if (!Validator::email($this->attributes['email'])) {
            $this->errors['email'] = 'Please provide a valid email address.';
        } 
        if (!Validator::password($this->attributes['password'])) {
            $this->errors['password'] = 'Please provide a valid password.';
        } 
        if (!Validator::name($this->attributes['name'])) {
            $this->errors['name'] = 'Please provide a valid name.';
        } 
        if (!Validator::image($this->attributes['image'])) {
            $this->errors['image'] = 'Please provide a valid img.';
        } 
    } 
}