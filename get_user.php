<?php

session_start();
include 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}

$user_id = (int) $_SESSION['user_id'];

$stmt = $conn->prepare(
    "SELECT nom AS first_name, prenom AS last_name, email, phone, address
     FROM users WHERE id = ? LIMIT 1"
);
$stmt->bind_param('i', $user_id);
$stmt->execute();

$result = $stmt->get_result();
$user   = $result->fetch_assoc();

if ($user) {
    // إرجاع البيانات مسطّحة مباشرة حتى يقرأها الـ frontend بـ user.first_name
    echo json_encode($user);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'User not found']);
}