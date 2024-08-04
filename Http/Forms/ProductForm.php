<?php

namespace Http\Forms;

use Core\App;
use Core\Database;
use Core\Validator;

class ProductForm extends Form{

    protected function validate() 
    {
        if ($this->attributes['image']['size']) {
            if (!Validator::image($this->attributes['img'])) {
                $this->errors['image'] = 'Please provide a valid img.';
            } 
        }
        if (!Validator::productStatus($this->attributes['status'])) {
            $this->errors['status'] = 'Please provide a valid status.';
        } 
        if (!Validator::name($this->attributes['category'])) {
            $this->errors['category'] = 'Please provide a valid category name.';
        }
        if (!Validator::name($this->attributes['name'])) {
            $this->errors['name'] = 'Please provide a valid product name.';
        }
        if (!Validator::time($this->attributes['time'])) {
            $this->errors['time'] = 'Please provide a valid time.';
        }
        if (!Validator::price($this->attributes['price'])) {
            $this->errors['price'] = 'Please provide a valid price.';
        }
    } 
    public static function getCategoryId($categoryname,$categories)
    {
        foreach ($categories as $category) {
            if ($category['categoryname']===$categoryname) {
                return $category['categoryid'];
            }
        }
        $db = App::resolve(Database::class);
        $db->query("insert into category (categoryname) values (:categoryname)",[
            'categoryname' => $categoryname,
        ]);
        $category = $db->query("select * from category where categoryname = :categoryname",[
            'categoryname' => $categoryname,
        ])->find();
        return $category['categoryid'];
    }
}