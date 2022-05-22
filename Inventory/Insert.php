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
        echo '<script>alert("Warehouse Added Successfully!"); window.location = "../index.php";</script>';

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
        echo '<script>alert("Product Added Successfully!"); window.location = "../index.php";</script>';

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
        echo '<script>alert("Store Added Successfully!"); window.location = "../index.php";</script>';

    }
    else{
        echo '<script>alert("An error occured")</script>';
    }
        
    }catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
    }

}

if(isset($_POST['insert_order'])){  
    try {
    
    $productID = $_POST['product'];
    $quantity = $_POST['quantity'];

    //Getting the price for the product ID that was selected
    $price_for_quantity = $conn->prepare("SELECT price FROM products WHERE productID=:product");
    $price_for_quantity->bindParam(":product", $productID);
    $price_for_quantity->execute();
    $p_f_q = $price_for_quantity->fetch(PDO::FETCH_COLUMN);
    
    //Muliplying the price with the quantity that the user selected
    $_SESSION['total_price'] = $quantity * $p_f_q;
    $total_price = $_SESSION['total_price'];
        
    $stmt = $conn->prepare("INSERT INTO products_orders (product, total_price, quantity) VALUES (:product, :total_price, :quantity)");
    $stmt->bindParam(':product', $productID);
    $stmt->bindParam(':total_price', $total_price);
    $stmt->bindParam(':quantity', $quantity);

    //Use Trigger in MySQL database to insert into orders after insert on products_orders
    //update: Trigger works on Local, but not remote. Therefore PHP Logic is needed here



    if($stmt->execute()){
        echo '<script>alert("Order Made Successfully!"); window.location = "../index.php";</script>';
        //PHP Logic: Best way to do it is a trigger, for now I'll do this
        //Select the recently added order ID
        $OrderID = $conn->prepare("SELECT max(orders) FROM products_orders");
        $OrderID->execute();
        $ID = $OrderID->fetch(PDO::FETCH_COLUMN);

        //get random warehouse ID 
        $stmt2 = $conn -> prepare('SELECT warehouseID FROM warehouse ORDER BY RAND() LIMIT 1');
        $stmt2 -> execute();
        $warehouse = $stmt2->fetchColumn();

        $stmt3 = $conn->prepare("INSERT INTO orders (orderID, warehouse) VALUES (:orderID, :warehouse)");
        $stmt3->bindParam(':orderID', $ID);
        $stmt3->bindParam(':warehouse', $warehouse);
        $stmt3->execute();


    }
    else{
        echo $total_price;
        echo '<BR>';
        echo $p_f_q;
        echo '<BR>';
        echo $productID;
        echo '<BR>';
        echo $quantity;
    }
        
    }catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
    }

}
?>