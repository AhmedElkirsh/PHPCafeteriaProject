<?php

namespace Http\Forms;

use Core\Validator;


class LoginForm extends Form{

    protected function validate()
    {
        if (!Validator::email($this->attributes['email'])) {
            $this->error('email', 'Please provide a valid email address.');
        }
        if (!Validator::password($this->attributes['password'])) {
            $this->error('password', 'Please provide a valid password.');
        }
    }
}