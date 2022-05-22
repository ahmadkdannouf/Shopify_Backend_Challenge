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
?>