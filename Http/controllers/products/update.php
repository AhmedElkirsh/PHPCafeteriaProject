<?php
/*********************************************Connection to database************************************/
    use Core\App;
    use Core\Database;
    $db = App::resolve(Database::class);
/*********************************************Data validation********************************************/
if (isset($_POST['updateProduct'])) {
    $product=$_POST["product"];
    $newPrice = $_POST["newPrice"];
    // $image = $_POST["image"];
    // $category = $_POST['category'];
    $newTime=$_POST["newTime"];
    $newStatus = $_POST["newStatus"];
    // echo $product;
/***************************************fetch all categories*******************************************/
   
    if ($db !== null) {
           $db->query("update product set price=:newPrice,time=:newTime,productStatus=:newStatus where name=:product");
            
    } else {
        die('Database connection is not established.');
    }
    // header("location:index.php");
}
?>