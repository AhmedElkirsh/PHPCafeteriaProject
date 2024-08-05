<?php 

namespace Core;

use Http\Forms\FileNameGenerator;
use Http\Forms\ProductForm;

class Authenticator { 

    public function attemptLogin($email,$password) 
    {
        $user = App::resolve(Database::class)->query('select * from users where email = :email', [
            'email' => $email
        ])->find();

        if ($user) {

            if (password_verify($password, $user['password'])) {

                $this->login($user);
        
                return true;
            }
        }
        return false;
    }

    public function attemptResgister($name,$email,$password,$img) 
    {
        $user = App::resolve(Database::class)->query('select * from users where email = :email', [
            'email' => $email
        ])->find();

        if (!$user) {
            $uploadDir = FileNameGenerator::generatePath($img,FileNameGenerator::USERS_DIR);
            //fix issue related to handling failed upload
            if(FileNameGenerator::checkUpload($img["tmp_name"], $uploadDir)){

                App::resolve(Database::class)->query('insert into users (name, email, password, upload_dir ,role) values (:name, :email,:password,:upload_dir,:role)',[
                    'name' => $name,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_BCRYPT),
                    'upload_dir' => $uploadDir,
                    'role' => 'admin'
                ]);

                $newUser = App::resolve(Database::class)->query('select * from users where email = :email', [
                    'email' => $email
                ])->find();

                $this->login($newUser);
                return true;
            }
            return false;
        }
    }
    public function attemptAddUser($name,$email,$password,$img,$role) 
    {
        $user = App::resolve(Database::class)->query('select * from users where email = :email', [
            'email' => $email
        ])->find();

        if (!$user) {
            $uploadDir = FileNameGenerator::generatePath($img,FileNameGenerator::USERS_DIR);
            
            //fix issue related to handling failed upload
            if(FileNameGenerator::checkUpload($img["tmp_name"], $uploadDir)){

                App::resolve(Database::class)->query('insert into users (name, email, password, upload_dir ,role) values (:name, :email,:password,:upload_dir,:role)',[
                    'name' => $name,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_BCRYPT),
                    'upload_dir' => $uploadDir,
                    'role' => $role
                ]);
               
                return true;
            }
            return false;
        }
            
    }
    public function attemptEditUser($name,$email,$password,$img) 
    {

        $user = App::resolve(Database::class)->query('select * from users where email = :email', [
            'email' => $email
        ])->find();
       if ($user) {

            $uploadDir = $img['size'] ? FileNameGenerator::generatePath($img,FileNameGenerator::USERS_DIR) : $user['upload_dir'];
            $password = $password ? password_hash($password, PASSWORD_BCRYPT) : $user['password'] ;
            //fix issue related to handling failed upload
            //fix duplication of storage when editing photo
            if($img['size']) {
                FileNameGenerator::checkUpload($img["tmp_name"], $uploadDir);
            } 
                
            App::resolve(Database::class)->query('update users set name = :name, password = :password, upload_dir = :upload_dir where email= :email',[
                'name' => $name,
                'password' => $password,
                'email' => $email,
                'upload_dir' => $uploadDir ?? $user['upload_dir'] , 
            ]);

            return true;
        }

        return false;
    }
    // I need to handle image uploading
    public function attemptAddProduct($name,$categoryname,$price,$time,$productStatus,$img)
    {
        $product = App::resolve(Database::class)->query("select * from product where name = :name",[
            'name' => $name,
        ])->find();
        if (!$product) {
            $upload_dir =  FileNameGenerator::generatePath($img,FileNameGenerator::PRODUCTS_DIR);
            FileNameGenerator::checkUpload($img["tmp_name"], $upload_dir);
            $categories = App::resolve(Database::class)->query("select * from category")->get();
            $categoryId = ProductForm::getCategoryId($categoryname,$categories);
            
            
            App::resolve(Database::class)->query("insert into product (name,productStatus,price,image,time,categoryid) values (:name,:productStatus,:price,:image,:time,:categoryid)",[
                'name' => $name,
                'productStatus' => $productStatus,
                'price' => $price,
                'image' => $upload_dir,
                'time' => $time,
                'categoryid' => $categoryId,
            ]);
                                        
            return true;
        }
        return false;
    }
    // I need to handle image uploading
    public function attemptEditProduct($name,$categoryname,$price,$time,$productStatus,$img)
    {
        $product = App::resolve(Database::class)->query("select * from product where name = :name",[
            'name' => $name,
        ])->find();
        if ($product) {
            $upload_dir = $img['size'] ? FileNameGenerator::generatePath($img,FileNameGenerator::USERS_DIR) : $product['image'];
            $categories = App::resolve(Database::class)->query("select * from category")->get();

            $categoryId = ProductForm::getCategoryId($categoryname,$categories);          
            
            App::resolve(Database::class)->query("update product set productStatus=:productStatus,price=:price,image=:image,time=:time,categoryid=:categoryid where name=:name",[
                'productStatus' => $productStatus,
                'price' => $price,
                'image' => $upload_dir,
                'time' => $time,
                'categoryid' => $categoryId,
                'name' => $name,
            ]);
                                        
            return true;
        }
        return false;
    }     
    function login($user)
    {
        $_SESSION['user'] = [
            'email' => $user['email'],
            'img' => $user['upload_dir'],
            'role' => $user['role'],
            'id' => $user['id']
        ];

        session_regenerate_id(true);
    }

    function logout()
    {
        Session::destroy();
    }    
    
}