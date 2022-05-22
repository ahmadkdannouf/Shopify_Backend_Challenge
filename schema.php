<?php


//file here just in case I need my script for creating tables

//My Triggers:

/*

Drop Trigger If Exists Insert_Random_Warehouse;
DELIMITER //
Create Trigger Insert_Random_Warehouse
After Insert on products_orders
for each ROW
BEGIN	
	Declare v_warehouse_ID	int;
	
	SELECT warehouseID into v_warehouse_ID
    FROM warehouse 
    ORDER BY RAND() LIMIT 1;
	
    Insert Into orders (orderID, warehouse) VALUES (new.orders, v_warehouse_ID);
END //
DELIMITER ;

Drop Trigger If Exists Delete_Order;
DELIMITER //
Create Trigger Delete_Order
After Delete on orders
for each ROW
BEGIN	
    Delete From products_orders WHERE orders = old.orderID;
END //
DELIMITER ;

*/

//My Tables:
/*

Drop table if exists products;
Create Table products(
    productID	int		AUTO_INCREMENT,
    name	varchar(255),
    price	decimal(6,2),
    color	varchar(15),
    PRIMARY KEY (productID)
);

Insert Into products (name, price, color) VALUES ('Dog Hair Clipper pet Hair Trimmer Puppy Grooming Electric Shaver Set Cat Accessories Ceramic Blade Recharge Profession supplies', 14.35, 'standard');
Insert Into products (name, price, color) VALUES ('Dog Harness with Handle Adjustable Outdoor Pet Dog Vest Reflective Nylon Material Vest Easy Control for Small Medium Large Dogs', 6.35, 'black');    
    
Drop table if exists warehouse;    
Create Table warehouse(
    warehouseID     int     AUTO_INCREMENT,
    name        varchar(255),
    street      varchar(255),
    city        varchar(25),
    state       char(2),
    zip_code    char(5),
    PRIMARY KEY (warehouseID)
);

Insert Into warehouse (name, street, city, state, zip_code) VALUES ('Puppy Warehouse', '8324 Routy Road', 'Richmond', 'VA', '25312');
Insert Into warehouse (name, street, city, state, zip_code) VALUES ('Doggy Warehouse', '6142 Lame Ave', 'Richmond', 'VA', '25312');

Drop table if exists products_orders;
Create Table products_orders(
    product         int     not null,
    orders           int    AUTO_INCREMENT      ,
    total_price     decimal(6,2)    check (total_price > 0),
    quantity        int             check (quantity > 0),
    PRIMARY KEY (orders),
    FOREIGN KEY (product) REFERENCES products (productID)
);

Insert Into products_orders (product, total_price, quantity) values (2, 6.35, 1);

Drop table if exists orders;
Create Table orders(
    orderID		int,
    warehouse	int,
    PRIMARY KEY (orderID),
    FOREIGN KEY (orderID) REFERENCES products_orders (orders),
    FOREIGN KEY (warehouse) REFERENCES warehouse(warehouseID)
);

Insert Into orders(orderID, warehouse) values (1,1);
Insert Into orders(orderID, warehouse) values (2,2);

Drop table if exists aliExpress_stores;
Create Table aliExpress_stores (
    store_number    int     not null,
    name            varchar(255)    not null,
    PRIMARY KEY(store_number)
);

Insert Into aliExpress_stores (store_number, name) VALUES (912229444, 'LIUXDIV AliExpress Store');

Drop table if exists orders_aliExpress_stores;
Create Table orders_aliExpress_store(
    orders                       int     not null,
    aliExpress_store           int     not null,
    PRIMARY KEY (orders, aliExpress_store),
    FOREIGN KEY (aliExpress_store) REFERENCES aliExpress_stores (store_number),
    FOREIGN KEY (orders) REFERENCES orders (orderID)
);

Insert Into orders_aliExpress_store (orders, aliExpress_store) Values (1, 912229444);

*/

?>