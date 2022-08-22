<?php

session_start();

if (!isset($_SESSION["verified"])) {
    header("location: login_file.php");
}

if (isset($_SESSION["verified"])) {
    header("location: home.php");
}

$SQL_connection = new mysqli("localhost", "root", "", "codeweekend");

if ($SQL_connection->connect_error) {
    die();
}

if (isset($_POST["save_Products"])) {

    $product_Id = $_POST["product_Id"];
    $product_Name = $_POST["product_Name"];
    $product_Price = $_POST["product_Price"];
    $product_Expiry_date = $_POST["product_Expiry_date"];

    $product_Image = $_FILES["product_Image"];
    $tmp_Name = $product_Image["tmp_name"];
    $image_Name = $product_Image["name"];

    move_uploaded_file($tmp_Name, "file_storage/products_files/" .$image_Name);


    $SQL_query = " INSERT INTO products (name, price, expiry_date, image) VALUES ('$product_Name', $product_Price, ";
    
    if ($product_Expiry_date) {
        $SQL_query .= " '$product_Expiry_date' ";
    } else {
        $SQL_query .= " NULL ";
    }

    $SQL_query .= " , '$image_Name') ";

    $SQL_connection->query($SQL_query);

    header("location: home.php");

} 
    else if(isset($_POST["update_Products"])) {

    $product_Id = $_POST["product_Id"];
    $product_Name = $_POST["product_Name"];
    $product_Price = $_POST["product_Price"];
    $product_Expiry_date = $_POST["product_Expiry_date"];

    $SQL_query_for_Image = " SELECT image FROM products WHERE id = $product_Id ";
    $query_for_Image_result = $SQL_connection->query($SQL_query_for_Image);
    $query_for_Image_selected_Data = $query_for_Image_result->fetch_assoc();

    $image_Name = $query_for_Image_selected_Data["image"];

    if ( isset ($_FILES['product_Image'] ) ) {

        unlink('file_storage/products_files/' .$image_Name); 

        $product_Image = $_FILES["product_Image"];
        $tmp_Name = $product_Image["tmp_name"];
        $image_Name = $product_Image["name"];
    
        move_uploaded_file($tmp_Name, "file_storage/products_files/" .$image_Name);
    } 

    $SQL_query = " UPDATE products SET name = '$product_Name', price = $product_Price, expiry_date";
    
    if ($product_Expiry_date) {
        $SQL_query .= " = '$product_Expiry_date' ";
    } else {
        $SQL_query .= " = NULL ";
    }

    $SQL_query .= " , image = '$image_Name' WHERE id = $product_Id; ";

    $SQL_connection->query($SQL_query);
    header("location: home.php");
}

else if (isset($_GET["delete_product"])) {
    $product_Id = $_GET["delete_product"];

    $SQL_query_for_Image = " SELECT image FROM products WHERE id = $product_Id ";
    $query_for_Image_result = $SQL_connection->query($SQL_query_for_Image);
    $query_for_Image_selected_Data = $query_for_Image_result->fetch_assoc();

    unlink("file_storage/products_files/" .$query_for_Image_selected_Data["image"]);
    
    $SQL_query = " DELETE FROM products WHERE id = $product_Id ";

    $SQL_connection->query($SQL_query);

    if ($SQL_connection->error) {
        echo $SQL_connection->error;
    } else {
        header("location: home.php");
    }
}


?>