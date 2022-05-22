<?php 
require_once('connection.php');

$productQuery = $conn->prepare('SELECT * FROM products');
$productQuery->execute();

$aliexpress_stores_Query = $conn->prepare('SELECT * FROM aliexpress_stores');
$aliexpress_stores_Query->execute();

$warehouse_Query = $conn->prepare('SELECT * FROM warehouse');
$warehouse_Query->execute();

$products_orders_Query = $conn->prepare('SELECT * FROM products_orders');
$products_orders_Query->execute();

$orders_Query = $conn->prepare('SELECT * FROM orders');
$orders_Query->execute();

$Aliexpress_order = $conn->prepare('SELECT * FROM orders_aliexpress_store');
$Aliexpress_order->execute();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link href="Inventory/inventoryTable.css" rel="stylesheet">
</head>
<body>

<center>
<h2>Products</h2>

<table class = "styled-table">
    <thead>
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Color</th>
        </tr>
    </thead>
    <?php foreach($productQuery as $product): ?>
    <tbody>
        <tr>
            <td><?=$product['productID']?></td>
            <td><?=$product['name']?></td>
            <td><?=$product['price']?></td>
            <td><?=$product['color']?></td>
        </tr>
    </tbody>
    <?php endforeach; ?>
</table>

<h1>______________________________________________________________________________________________________</h1>

<h2>Suppliers/AliExpress Stores</h2>

<table class = "styled-table">
    <thead>
        <tr>
            <th>Store Number</th>
            <th>Store Name</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($aliexpress_stores_Query as $store): ?>
        <tr>
            <td><?=$store['store_number']?></td>
            <td><?=$store['name']?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h1>______________________________________________________________________________________________________</h1>

<h2>Warehouses</h2>

<table class = "styled-table">
    <thead>
        <tr>
            <th>Warehouse ID</th>
            <th>Warehouse Name</th>
            <th>Street</th>
            <th>City</th>
            <th>State</th>
            <th>Zip Code</th>
            <th>Delete Warehouse</th>
        
        </tr>
    </thead>
    <tbody>
        <?php foreach($warehouse_Query as $warehouse): ?>
        <tr>
            <td><?=$warehouse['warehouseID']?></td>
            <td><?=$warehouse['name']?></td>
            <td><?=$warehouse['street']?></td>
            <td><?=$warehouse['city']?></td>
            <td><?=$warehouse['state']?></td>
            <td><?=$warehouse['zip_code']?></td>
            <td>
                <?php echo '<input type="hidden" name="warehouseID" id = "warehouseID" value = "'.$warehouse["warehouseID"].'" />' ?>
                <button type="submit" name="delete_warehouse">Delete Warehouse</button>
            </td>
        </tr>
    </tbody>
    <?php endforeach; ?>
    
</table>

<form action = "Inventory/Insert.php" method = "POST">
    <label for="name">Warehouse Name:</label><br>
    <input type="text" id="name" name="name"><br>

    <label for="street">Street:</label><br>
    <input type="text" id="street" name="street"><br>

    <label for="city">City:</label><br>
    <input type="text" id="city" name="city"><br>

    <label for="state">State:</label><br>
    <input type="text" id="state" name="state"><br>

    <label for="zip_code">Zip Code:</label><br>
    <input type="text" id="zip_code" name="zip_code"><br>
    <br>
    <button type="submit" name="insert_warehouse">Add Warehouse</button>

</form>

<h1>______________________________________________________________________________________________________</h1>

<h2>Ordered Products</h2>

<table class = "styled-table">
    <thead>
        <tr>
            <th>Product ID</th>
            <th>Order ID</th>
            <th>Quantity</th>
            <th>Total Price</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($products_orders_Query as $OP): ?>
        <tr>
            <td><?=$OP['product']?></td>
            <td><?=$OP['orders']?></td>
            <td><?=$OP['total_price']?></td>
            <td><?=$OP['quantity']?></td>
        </tr>
    </tbody>
    <?php endforeach; ?>
    
</table>

<table class = "styled-table">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Warehouse ID</th>
            <th>Update Warehouse ID</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($orders_Query as $order): ?>
        <tr>
            <td><?=$order['orderID']?></td>
            <td><?=$order['warehouse']?></td>
            <td>
            <form action = "Inventory/Update.php" method = "post">
                <?php echo '<input type="hidden" name="orderID" id = "orderID" value = "'.$order["orderID"].'" />' ?>
                <select id="warehouse" name="warehouse" type="warehouse" class="form-control">

                    <?php
                    $ID_of_warehouse = "SELECT warehouseID FROM warehouse";
                    $sql = $conn->prepare($ID_of_warehouse);
                    $sql->execute();
                    $ID = $sql->fetchAll(PDO::FETCH_COLUMN);
                    ?>
                    <option></option>
                    <?php foreach($ID as $warehouse):?>
                        <option><?=$warehouse?></option>
                    <?php endforeach; ?>    
                </select>
                <button class="w-100 btn btn-lg btn-dark" type="submit" name="change_warehouse">Save Change</button>
            </form>


        </tr>
    </tbody>
    <?php endforeach; ?>
    
</table>

<table class = "styled-table">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>AliExpress Store Number</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($Aliexpress_order as $AO): ?>
        <tr>
            <td><?=$AO['orders']?></td>
            <td><?=$AO['aliExpress_store']?></td>
        </tr>
    </tbody>
    <?php endforeach; ?>
    
</table>

</center>
    
</body>
</html>