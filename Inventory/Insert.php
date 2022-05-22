<?php
require_once('../connection.php');
if(isset($_POST['insert_warehouse'])){  
    try {
    
    $name = $_POST['name'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip_code = $_POST['zip_code'];
        
    $stmt = $conn->prepare("INSERT INTO warehouse (name, street, city, state, zip_code) VALUES (:name, :street, :city, :state, :zip_code)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':street', $street);
    $stmt->bindParam(':city', $city);
    $stmt->bindParam(':state', $state);
    $stmt->bindParam(':zip_code', $zip_code);

    if($stmt->execute()){
        echo '<script>alert("Warehouse Added Successfully!")</script>';
        header("Location:../index.php");

    }
    else{
        echo '<script>alert("An error occured")</script>';
    }
        
    }catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
    }

}

if(isset($_POST['insert_product'])){  
    try {
    
    $name = $_POST['name'];
    $price = $_POST['price'];
    $color = $_POST['color'];
        
    $stmt = $conn->prepare("INSERT INTO products (name, price, color) VALUES (:name, :price, :color)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':color', $color);
    
    if($stmt->execute()){
        echo '<script>alert("Product Added Successfully!")</script>';
        header("Location:../index.php");

    }
    else{
        echo '<script>alert("An error occured")</script>';
    }
        
    }catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
    }

}

if(isset($_POST['insert_store'])){  
    try {
    
    $store_number = $_POST['store_number'];
    $name = $_POST['name'];

    $stmt = $conn->prepare("INSERT INTO aliexpress_stores (store_number, name) VALUES (:store_number, :name)");
    $stmt->bindParam(':store_number', $store_number);
    $stmt->bindParam(':name', $name);
    
    if($stmt->execute()){
        echo '<script>alert("Store Added Successfully!")</script>';
        header("Location:../index.php");

    }
    else{
        echo '<script>alert("An error occured")</script>';
    }
        
    }catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
    }

}
?>