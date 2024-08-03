<?php 

namespace Core;

use Http\Forms\FileNameGenerator;

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
                    'role' => 'user'
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

       if (!$user) {

        $uploadDir = $img ? FileNameGenerator::generatePath($img,FileNameGenerator::USERS_DIR) : null;
        $password = $password ? password_hash($password, PASSWORD_BCRYPT) : $user['password'] ;
        //fix issue related to handling failed upload
        if(FileNameGenerator::checkUpload($img["tmp_name"], $uploadDir)){

            App::resolve(Database::class)->query('update user set name = :name, password = :password, upload_dir = :upload_dir where email= :email',[
                'name' => $name,
                'password' => $password,
                'email' => $email,
                'upload_dir' => $uploadDir ?? $user['upload_dir'] , 
            ]);
        
            return true;
        }

        return false;
       }
        
    }
            
    function login($user)
    {
        $_SESSION['user'] = [
            'email' => $user['email'],
            'img' => $user['upload_dir'],
            'role' => $user['role']
        ];

        session_regenerate_id(true);
    }

    function logout()
    {
        Session::destroy();
    }    
    
}