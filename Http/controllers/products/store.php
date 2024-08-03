<?php
/************************************Connection to database*****************************************/
use Http\Forms\FileNameGenerator;
use Core\App;
use Core\Database;
$db = App::resolve(Database::class);
/************************************validation on data*****************************************/
// if (isset($_POST['saveData'])) {
    $product = $_POST["product"];
    $price = $_POST["price"];
    $category = $_POST["category"];
    echo $category;
    // $image=$_POST["image"];
    $time = $_POST["time"]; 
    $status = $_POST["status"]; 
    $img=$_POST["image"];
    
    // $image_name=$_FILES['image']['name'];
    // $tmp_name=$_FILES['image']['tmp_name'];
    // $path="uploads/".$image_name;
    // $uploaded=move_uploaded_file($tmp_name,$path); 
    // $image=$path;
/***************************get category id to insert it into product table******************************* */
        // $result = $db->query("select categoryid from category where categoryname = :category")->get();
        // $x=$result['categoryid'];
        // echo $x;
/***************************insert new product into table*********************************************** */
    // $db->query("INSERT INTO product (name, productStatus, price, image,time,categoryid) VALUES ($product, $status, $price, $image,$time,$x)");
// }
/****************************************adding new category validation**************************/
// if(isset($_POST["newCategory"]))
    global $db;
    $addedCategory=$_POST["addedCategory"];
    echo $addedCategory;
    $db->query("INSERT INTO category (categoryname) VALUES $addedCategory");
// header("location:index.php");
?>