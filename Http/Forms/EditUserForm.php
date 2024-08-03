<?php

namespace Http\Forms;

use Core\Validator;

class EditUserForm extends Form{

    protected function validate() 
    {
        if (!Validator::name($this->attributes['name'])) {
            $this->errors['name'] = 'Please provide a valid name.';
        } 
        if ($this->attributes['password']) {
            if (!Validator::password($this->attributes['password'])) {
                $this->errors['password'] = 'Please provide a valid password.';
            }
            if (!Validator::passwordconfirm($this->attributes['password'],$this->attributes['passwordconfirm'])) {
                $this->errors['passwordconfirm'] = 'your passwords do not match.';
            }
        }  

        if ($this->attributes['image']['size']) {
            if (!Validator::image($this->attributes['image'])) {
                $this->errors['image'] = 'Please provide a valid img.';
            } 
        }
        
    } 
}