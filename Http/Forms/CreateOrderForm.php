<?php

namespace Http\Forms;

use Core\Validator;


class CreateOrderForm extends Form{
    protected function validate()
    {
        
        if (!Validator::notes($this->attributes['notes'])) {
            $this->errors['notes']= 'Please provide a note.';
        }
        if (!Validator::room($this->attributes['room'])) {
            $this->errors['room']= 'Please choose a room.';
        }
        if (!Validator::productChosen($this->attributes['productChosen'])) {
            $this->errors['productChosen']= 'Please choose a product.';
        }
        if (!Validator::userChosen($this->attributes['userChosen'])) {
            $this->errors['userChosen']= 'Please choose a user.';
        }
        
    }
}