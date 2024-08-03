<?php
namespace Http\Forms;
use Core\ValidationException;

class Form {

    protected $errors = [];
    protected $attributes = [];

    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
        $this->validate();
    }
    protected function validate()
    {
        //overridden by subclasses
    }

    public static function validateAttributes($attributes) 
    {
        $instance = new static($attributes);
        
        return $instance->failed() ? $instance->throw() : $instance;     
    } 
    public function failed()
    {
        return count($this->errors);
    }
    public function throw() 
    {
        ValidationException::throw($this->errors(),$this->attributes);
    }
    public function errors()
    {
        return $this->errors;
    }

    public function error($field,$message)
    {
        $this->errors[$field]=$message;
        return $this;
    }
}