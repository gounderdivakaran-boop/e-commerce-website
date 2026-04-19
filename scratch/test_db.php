<?php
$con = mysqli_connect("127.0.0.1", "root", "", "shopping");
if (mysqli_connect_errno()) {
    echo "Connection failed: " . mysqli_connect_error();
} else {
    echo "Connected successfully";
}
?>
