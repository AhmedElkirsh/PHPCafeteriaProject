<?php 

namespace Http\Forms;

class FileNameGenerator {

    const USERS_DIR = '../storage/user_profile_images';
    const PRODUCTS_DIR = '../storage/product_images';

    public static function generatePath($img,$dir) {
        $fileExtension = strtolower(pathinfo($img["name"], PATHINFO_EXTENSION));
        $newFileName = bin2hex(random_bytes(16)) . '.' . $fileExtension;    
        return $dir . $newFileName;
    }

    public static function checkUpload($fileTmpPath, $uploadDir) {
        return move_uploaded_file($fileTmpPath, $uploadDir);
    }
    

    
}