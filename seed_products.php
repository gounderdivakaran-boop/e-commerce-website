<?php
include('includes/config.php');

if (!db_ready()) {
    die("Database not ready. Please check XAMPP.");
}

// Ensure at least one category exists
$cat_check = mysqli_query($con, "SELECT id FROM category LIMIT 1");
if (mysqli_num_rows($cat_check) == 0) {
    mysqli_query($con, "INSERT INTO category (categoryName, categoryDescription) VALUES ('Premium Electronics', 'High-end gadgets and accessories')");
    $category_id = mysqli_insert_id($con);
} else {
    $cat_row = mysqli_fetch_array($cat_check);
    $category_id = $cat_row['id'];
}

// Sample Products Data
$products = [
    [
        'id' => 101,
        'category' => $category_id,
        'name' => 'Aura Wireless Headphones',
        'company' => 'Nexus Elite',
        'price' => 12500,
        'priceBefore' => 15000,
        'desc' => 'Experience pure sound with the Aura Wireless Headphones. Features active noise cancellation and 40-hour battery life.',
        'image' => 'headphones.png'
    ],
    [
        'id' => 102,
        'category' => $category_id,
        'name' => 'Zenith Chronograph Watch',
        'company' => 'Nexus Elite',
        'price' => 24000,
        'priceBefore' => 30000,
        'desc' => 'A masterpiece of timing. The Zenith Chronograph features a deep blue dial and genuine Italian leather strap.',
        'image' => 'watch.png'
    ],
    [
        'id' => 103,
        'category' => $category_id,
        'name' => 'Lumina Smart Lamp',
        'company' => 'Nexus Elite',
        'price' => 4500,
        'priceBefore' => 5500,
        'desc' => 'Elegant smart lighting for your modern workspace. Touch-sensitive controls and adjustable color temperature.',
        'image' => 'lamp.png'
    ]
];

foreach ($products as $p) {
    // Check if product exists
    $check = mysqli_query($con, "SELECT id FROM products WHERE id=" . $p['id']);
    if (mysqli_num_rows($check) == 0) {
        $sql = "INSERT INTO products (id, category, productName, productCompany, productPrice, productPriceBeforeDiscount, productDescription, productImage1, productAvailability) 
                VALUES ({$p['id']}, {$p['category']}, '{$p['name']}', '{$p['company']}', {$p['price']}, {$p['priceBefore']}, '{$p['desc']}', '{$p['image']}', 'In Stock')";
        if (mysqli_query($con, $sql)) {
            echo "Added product: " . $p['name'] . "<br>";
        } else {
            echo "Error adding product " . $p['name'] . ": " . mysqli_error($con) . "<br>";
        }
    } else {
        echo "Product " . $p['name'] . " already exists.<br>";
    }
}

echo "Seeding complete. <a href='index.php'>Go to Shop</a>";
?>
