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

<style>
    /* Set additional styling options for the columns */
    .column {
    float: left;
    }

    /* Set width length for the left, right and middle columns */
    .left {
    width: 50%;
    }
    .right {
    width: 50%;
    }

    .row:after {
    content: "";
    display: table;
    clear: both;
    }
    </style>

<center>

<h2>Inventory</h2>

<div class="row">
        <div class="column left">
            <table class = "styled-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product ID</th>
                        <th>Total Price</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($products_orders_Query as $OP): ?>
                    <tr>
                        <td><?=$OP['orders']?></td>
                        <td><?=$OP['product']?></td>
                        <td><?=$OP['total_price']?></td>
                        <td><?=$OP['quantity']?></td>
                    </tr>
                </tbody>
                <?php endforeach; ?>
                
            </table>

            <form action = "Inventory/Insert.php" method = "POST">
                <label for="product">Product:</label>
                <br>
                <select id="product" name="product" type="product" class="form-control">
                    <?php
                    $ID_of_product = "SELECT productID FROM products";
                    $sql = $conn->prepare($ID_of_product);
                    $sql->execute();
                    $ID = $sql->fetchAll(PDO::FETCH_COLUMN);
                    ?>
                    <option></option>
                    <?php foreach($ID as $product):?>
                        <option><?=$product?></option>
                    <?php endforeach; ?>    
                </select>
                <br>
                <label for="quantity">Quantity:</label><br>
                <input type="number" id="quantity" name="quantity"><br>

                <br>
                <button type="submit" name="insert_order">Make Order</button>

            </form>

                        

        </div>

    <div class="column right">
        <table class = "styled-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Warehouse ID</th>
                    <th>Update Warehouse ID</th>
                    <th>Delete Order</th>
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
                    </td>
                    <td>
                        <form action = "Inventory/Delete.php" method = "POST">
                            <?php echo '<input type="hidden" name="orderID" id = "orderID" value = "'.$order["orderID"].'" />' ?>
                            <button type="submit" name="delete_order">Delete Order</button>
                        </form>
                    </td>


                </tr>
            </tbody>
            <?php endforeach; ?>
            
        </table>
    </div>

</div>

<h1>______________________________________________________________________________________________________</h1>

<h2>Products</h2>

<table class = "styled-table">
    <thead>
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Supplier ID</th>
            <th>Price</th>
            <th>Color</th>
            <th>Delete Product</th>
        </tr>
    </thead>
    <?php foreach($productQuery as $product): ?>
    <tbody>
        <tr>
            <td><?=$product['productID']?></td>
            <td><?=$product['name']?></td>
            <td><?=$product['store_number']?></td>
            <td><?=$product['price']?></td>
            <td><?=$product['color']?></td>
            <td>
            <form action = "Inventory/Delete.php" method = "POST">
                <?php echo '<input type="hidden" name="productID" id = "productID" value = "'.$product["productID"].'" />' ?>
                <button type="submit" name="delete_product">Delete Product</button>
            </form>
            </td>
        </tr>
    </tbody>
    <?php endforeach; ?>
</table>

<form action = "Inventory/Insert.php" method = "POST">
    <label for="name">Product Name:</label><br>
    <input type="text" id="name" name="name"><br>

    <label for="price">Price:</label><br>
    <input type="text" id="price" name="price"><br>

    <label for="color">Color:</label><br>
    <input type="text" id="color" name="color"><br>

    <br>
    <button type="submit" name="insert_product">Add Product</button>

</form>

<h1>______________________________________________________________________________________________________</h1>

<h2>Suppliers/AliExpress Stores</h2>

<table class = "styled-table">
    <thead>
        <tr>
            <th>Store Number</th>
            <th>Store Name</th>
            <th>Delete Store<th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($aliexpress_stores_Query as $store): ?>
        <tr>
            <td><?=$store['store_number']?></td>
            <td><?=$store['name']?></td>
            <td>
            <form action = "Inventory/Delete.php" method = "POST">
                <?php echo '<input type="hidden" name="store_number" id = "store_number" value = "'.$store["store_number"].'" />' ?>
                <button type="submit" name="delete_store">Delete Store</button>
            </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<form action = "Inventory/Insert.php" method = "POST">
    <label for="store_number">Store Number:</label><br>
    <input type="text" id="store_number" name="store_number"><br>

    <label for="name">Store Name:</label><br>
    <input type="text" id="name" name="name"><br>

    <br>
    <button type="submit" name="insert_store">Add Store</button>

</form>

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
            <form action = "Inventory/Delete.php" method = "POST">
                <?php echo '<input type="hidden" name="warehouseID" id = "warehouseID" value = "'.$warehouse["warehouseID"].'" />' ?>
                <button type="submit" name="delete_warehouse">Delete Warehouse</button>
            </form>
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

</center>
    
</body>
</html>