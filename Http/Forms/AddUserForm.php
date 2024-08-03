<?php

namespace Http\Forms;

use Core\Validator;

class AddUserForm extends Form{

    protected function validate() 
    {
        if (!Validator::name($this->attributes['name'])) {
            $this->errors['name'] = 'Please provide a valid name.';
        } 
        if (!Validator::email($this->attributes['email'])) {
            $this->errors['email'] = 'Please provide a valid email address.';
        } 
        if (!Validator::password($this->attributes['password'])) {
            $this->errors['password'] = 'Please provide a valid password.';
        } 
        if (!Validator::passwordconfirm($this->attributes['password'],$this->attributes['passwordconfirm'])) {
            $this->errors['passwordconfirm'] = 'your passwords do not match.';
        }
        if (!Validator::role($this->attributes['role'])) {
            $this->errors['role'] = 'the role can only be "user" or "admin"';
        } 
        if (!Validator::image($this->attributes['image'])) {
            $this->errors['image'] = 'Please provide a valid img.';
        } 
    } 
}