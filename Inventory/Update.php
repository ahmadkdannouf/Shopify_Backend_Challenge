<?php
require_once('../connection.php');
if(isset($_POST['change_warehouse'])){  
    try {
    
    $orderID = $_POST['orderID'];
    $warehouse = $_POST['warehouse'];
        
    $stmt = $conn->prepare("UPDATE orders SET warehouse=:warehouse WHERE orderID=:orderID");
    $stmt->bindParam(':orderID', $orderID);
    $stmt->bindParam(':warehouse', $warehouse);

    if($stmt->execute()){
        echo '<script>alert("Warehouse Changed Successfully!"); window.location = "../index.php";</script>';

    }
    else{
        echo '<script>alert("An error occured")</script>';
    }
        
    }catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
    }

}
?>