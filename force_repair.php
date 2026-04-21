<?php
/**
 * FORCE REPAIR SCRIPT for Nexus Elite
 * This script forces the creation of all missing tables on Aiven Cloud.
 */
$host = 'mysql-8d474cb-gounderdivakaran-0f47.g.aivencloud.com';
$user = 'avnadmin';
$pass = 'AVNS_S7QTFAZrai9x7WfPn4F';
$db   = 'defaultdb';
$port = 12863;

echo "<h2>Force Repairing Cloud Database...</h2>";

$con = mysqli_connect($host, $user, $pass, $db, $port);

if (!$con) {
    die("<p style='color:red;'>Connection Failed: " . mysqli_connect_error() . "</p>");
}

echo "<p style='color:green;'>Connected Successfully!</p>";

$tables = [
    "admin" => "CREATE TABLE admin (id int(11) NOT NULL AUTO_INCREMENT, username varchar(255) NOT NULL, password varchar(255) NOT NULL, updationDate varchar(255) DEFAULT NULL, PRIMARY KEY (id))",
    "category" => "CREATE TABLE category (id int(11) NOT NULL AUTO_INCREMENT, categoryName varchar(255) DEFAULT NULL, categoryDescription longtext, creationDate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, updationDate varchar(255) DEFAULT NULL, PRIMARY KEY (id))",
    "subcategory" => "CREATE TABLE subcategory (id int(11) NOT NULL AUTO_INCREMENT, categoryid int(11) DEFAULT NULL, subcategory varchar(255) DEFAULT NULL, creationDate timestamp NULL DEFAULT CURRENT_TIMESTAMP, updationDate varchar(255) DEFAULT NULL, PRIMARY KEY (id))",
    "products" => "CREATE TABLE products (id int(11) NOT NULL AUTO_INCREMENT, category int(11) NOT NULL, subCategory int(11) DEFAULT NULL, productName varchar(255) DEFAULT NULL, productCompany varchar(255) DEFAULT NULL, productPrice int(11) DEFAULT NULL, productPriceBeforeDiscount int(11) DEFAULT NULL, productDescription longtext, productImage1 varchar(255) DEFAULT NULL, productImage2 varchar(255) DEFAULT NULL, productImage3 varchar(255) DEFAULT NULL, shippingCharge int(11) DEFAULT NULL, productAvailability varchar(255) DEFAULT NULL, postingDate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, updationDate varchar(255) DEFAULT NULL, PRIMARY KEY (id))",
    "users" => "CREATE TABLE users (id int(11) NOT NULL AUTO_INCREMENT, name varchar(255) DEFAULT NULL, email varchar(255) DEFAULT NULL, contactno bigint(11) DEFAULT NULL, password varchar(255) DEFAULT NULL, shippingAddress longtext, shippingState varchar(255) DEFAULT NULL, shippingCity varchar(255) DEFAULT NULL, shippingPincode int(11) DEFAULT NULL, billingAddress longtext, billingState varchar(255) DEFAULT NULL, billingCity varchar(255) DEFAULT NULL, billingPincode int(11) DEFAULT NULL, regDate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, updationDate varchar(255) DEFAULT NULL, PRIMARY KEY (id))",
    "orders" => "CREATE TABLE orders (id int(11) NOT NULL AUTO_INCREMENT, userId int(11) DEFAULT NULL, productId varchar(255) DEFAULT NULL, quantity int(11) DEFAULT NULL, orderDate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, paymentMethod varchar(50) DEFAULT NULL, orderStatus varchar(55) DEFAULT NULL, PRIMARY KEY (id))",
    "productreviews" => "CREATE TABLE productreviews (id int(11) NOT NULL AUTO_INCREMENT, productId int(11) DEFAULT NULL, quality int(11) DEFAULT NULL, price int(11) DEFAULT NULL, value int(11) DEFAULT NULL, name varchar(255) DEFAULT NULL, summary varchar(255) DEFAULT NULL, review longtext, reviewDate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (id))",
    "wishlist" => "CREATE TABLE wishlist (id int(11) NOT NULL AUTO_INCREMENT, userId int(11) DEFAULT NULL, productId int(11) DEFAULT NULL, postingDate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (id))"
];

foreach ($tables as $name => $sql) {
    echo "Creating table <b>$name</b>... ";
    if (mysqli_query($con, $sql)) {
        echo "<span style='color:green;'>SUCCESS</span><br>";
    } else {
        $error = mysqli_error($con);
        if (strpos($error, 'already exists') !== false) {
            echo "<span style='color:blue;'>ALREADY EXISTS</span><br>";
        } else {
            echo "<span style='color:red;'>FAILED: $error</span><br>";
        }
    }
}

// Create Admin User
$hash = password_hash('admin', PASSWORD_DEFAULT);
mysqli_query($con, "DELETE FROM admin WHERE username='admin'");
mysqli_query($con, "INSERT INTO admin (username, password) VALUES ('admin', '$hash')");
echo "<p><b>Admin account created (admin / admin)</b></p>";

// Seed Categories
mysqli_query($con, "INSERT IGNORE INTO category (id, categoryName) VALUES (1, 'Elite Electronics'), (2, 'Premium Lifestyle')");

echo "<h2 style='color:green;'>FORCE REPAIR COMPLETE!</h2>";
echo "<p>All tables are now ready. Please refresh your live site.</p>";
?>
