<?php
session_start();
include('includes/config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Terms of Service | Nexus Elite</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/smart-modern.css">
</head>
<body>
    <?php include('includes/top-header.php');?>
    <?php include('includes/main-header.php');?>
    <?php include('includes/menu-bar.php');?>

    <div class="container" style="padding: 80px 0;">
        <h1 style="font-family: 'Playfair Display', serif; margin-bottom: 40px;">Terms of Service</h1>
        <div class="content" style="color: #555; line-height: 1.8;">
            <p>Welcome to Nexus Elite. By using our website, you agree to the following terms.</p>
            <h3>1. Account Responsibility</h3>
            <p>You are responsible for maintaining the confidentiality of your account and password.</p>
            <h3>2. Product Accuracy</h3>
            <p>We strive to be as accurate as possible with product descriptions and pricing.</p>
            <h3>3. Governing Law</h3>
            <p>These terms are governed by the laws of our global operating headquarters.</p>
        </div>
    </div>

    <?php include('includes/footer.php');?>
</body>
</html>
