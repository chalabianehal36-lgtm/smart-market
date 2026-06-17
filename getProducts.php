<?php

error_reporting(0);
include 'db.php';
 
header('Content-Type: application/json; charset=utf-8');
 
$sql = "
    SELECT
        p.id,
        p.name,
        p.description,
        p.price,
        p.image,
        p.colors,
        p.stock,
        c.name AS category
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    ORDER BY p.id DESC
";
 
$result = $conn->query($sql);
 
if (!$result) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Query failed']);
    exit;
}
 
$data = [];
while ($row = $result->fetch_assoc()) {
    // Parse colors string → array
    $row['colors'] = !empty($row['colors'])
        ? array_map('trim', explode(',', $row['colors']))
        : [];
 
    // Fallback image
    if (empty($row['image'])) {
        $row['image'] = 'https://via.placeholder.com/400x400?text=No+Image';
    }
 
    $data[] = $row;
}
 
echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
 