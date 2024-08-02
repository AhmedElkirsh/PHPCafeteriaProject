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

                $this->login($email,$user['upload_dir']);
        
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

            if(FileNameGenerator::checkUpload($img["tmp_name"], $uploadDir)){

                App::resolve(Database::class)->query('insert into users (name, email, password, upload_dir ,role) values (:name, :email,:password,:upload_dir,:role)',[
                    'name' => $name,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_BCRYPT),
                    'upload_dir' => $uploadDir,
                    'role' => 'user'
                ]);

                $this->login($email,$uploadDir);
                return true;
            }
            return false;
        }
            
    }

    function login($email, $uploadDir)
    {
        $_SESSION['user'] = [
            'email' => $email,
            'img' => $uploadDir,
            'role' => 'user'
        ];

        session_regenerate_id(true);
    }

    function logout()
    {
        Session::destroy();
    }    
    
}