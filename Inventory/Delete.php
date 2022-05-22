<?php
require_once('../connection.php');
if(isset($_POST['delete_warehouse'])){  
    try {
    
    $warehouseID = $_POST['warehouseID'];
        
    $stmt = $conn->prepare("DELETE FROM warehouse WHERE warehouseID=:warehouseID");
    $stmt->bindParam(':warehouseID', $warehouseID);

    if($stmt->execute()){
        echo '<script>alert("Warehouse Deleted Successfully!"); window.location = "../index.php";</script>';
    }
    else{
        echo '<script>alert("An error occured")</script>';
    }
        
    }catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
    }

}

if(isset($_POST['delete_product'])){  
    try {
    
    $productID = $_POST['productID'];
        
    $stmt = $conn->prepare("DELETE FROM products WHERE productID=:productID");
    $stmt->bindParam(':productID', $productID);

    if($stmt->execute()){
        echo '<script>alert("Product Deleted Successfully!"); window.location = "../index.php";</script>';

    }
    else{
        echo '<script>alert("An error occured")</script>';
    }
        
    }catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
    }

}

if(isset($_POST['delete_store'])){  
    try {
    
    $store_number = $_POST['store_number'];
        
    $stmt = $conn->prepare("DELETE FROM aliexpress_stores WHERE store_number=:store_number");
    $stmt->bindParam(':store_number', $store_number);

    if($stmt->execute()){
        echo '<script>alert("Store Deleted Successfully!"); window.location = "../index.php"; </script>';

    }
    else{
        echo '<script>alert("An error occured")</script>';
    }
        
    }catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
    }

}

if(isset($_POST['delete_order'])){  
    try {

    $orders = $_POST['orderID'];
        
    $stmt = $conn->prepare("DELETE FROM orders WHERE orderID=:orders");
    $stmt->bindParam(':orders', $orders);

    //Include Trigger to delete order from products_orders after delete on orders

    if($stmt->execute()){
        echo '<script>alert("Order Deleted Successfully!"); window.location = "../index.php"; </script>';


    }
    else{
        echo $orders;
    }
        
    }catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
    }

}
?>