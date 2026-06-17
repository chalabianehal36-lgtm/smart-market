<?php

error_reporting(0);
include 'db.php';
 
header('Content-Type: application/json; charset=utf-8');
 
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
 
if (!$id || $id <= 0) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid product ID']);
    exit;
}
 
$stmt = $conn->prepare(
    "SELECT p.*, c.name AS category
     FROM products p
     LEFT JOIN categories c ON p.category_id = c.id
     WHERE p.id = ? LIMIT 1"
);
$stmt->bind_param('i', $id);
$stmt->execute();
 
$result = $stmt->get_result();
$row    = $result->fetch_assoc();
 
if (!$row) {
    http_response_code(404);
    echo json_encode(['status' => 'error', 'message' => 'Product not found']);
    exit;
}
 
// Parse colors
$row['colors'] = !empty($row['colors'])
    ? array_map('trim', explode(',', $row['colors']))
    : [];
 
// Fallback image
if (empty($row['image'])) {
    $row['image'] = 'https://via.placeholder.com/450x400?text=No+Image';
}
 
// Ensure name field
if (empty($row['name'])) {
    $row['name'] = $row['nom'] ?? 'Produit';
}
 
echo json_encode($row, JSON_UNESCAPED_UNICODE);
 