<?php
include('includes/config.php');

$query_term = $_GET['q'] ?? '';

if (strlen($query_term) < 2) {
    echo json_encode([]);
    exit;
}

$find = "%" . $query_term . "%";
$stmt = safe_query_prepare("SELECT id, productName, productPrice, productImage1 FROM products WHERE productName LIKE ? LIMIT 5");

$results = [];
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $find);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_array($res)) {
        $results[] = [
            'id' => $row['id'],
            'name' => $row['productName'],
            'price' => $row['productPrice'],
            'image' => "admin/productimages/" . $row['id'] . "/" . $row['productImage1']
        ];
    }
    mysqli_stmt_close($stmt);
}

header('Content-Type: application/json');
echo json_encode($results);
?>
