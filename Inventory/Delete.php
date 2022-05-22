<?php
require_once('../connection.php');
if(isset($_POST['delete_warehouse'])){  
    try {
    
    $warehouseID = $_POST['warehouseID'];
        
    $stmt = $conn->prepare("DELETE FROM warehouse WHERE warehouseID=:warehouseID");
    $stmt->bindParam(':warehouseID', $warehouseID);

    if($stmt->execute()){
        echo '<script>alert("Warehouse Deleted Successfully!")</script>';
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