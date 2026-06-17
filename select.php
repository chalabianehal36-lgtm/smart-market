<?php

error_reporting(0);
include 'db.php';
 
header('Content-Type: application/json; charset=utf-8');
 
$category = filter_input(INPUT_GET, 'category', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
 
if (!empty($category)) {
    $stmt = $conn->prepare(
        "SELECT p.*, c.name AS category
         FROM products p
         LEFT JOIN categories c ON p.category_id = c.id
         WHERE c.name = ?"
    );
    $stmt->bind_param('s', $category);
} else {
    $stmt = $conn->prepare(
        "SELECT p.*, c.name AS category
         FROM products p
         LEFT JOIN categories c ON p.category_id = c.id"
    );
}
 
$stmt->execute();
$result   = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);
 
echo json_encode($products, JSON_UNESCAPED_UNICODE);
 