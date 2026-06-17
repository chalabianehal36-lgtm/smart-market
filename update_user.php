<?php

session_start();
include 'db.php';
 
header('Content-Type: application/json');
 
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
    exit;
}
 
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    exit;
}
 
$data = json_decode(file_get_contents('php://input'), true);
 
if (!$data) {
    echo json_encode(['status' => 'error', 'message' => 'No data received']);
    exit;
}
 
$user_id    = (int) $_SESSION['user_id'];
$first_name = trim($data['first_name'] ?? '');
$last_name  = trim($data['last_name']  ?? '');
$email      = trim($data['email']      ?? '');
$phone      = trim($data['phone']      ?? '');
$address    = trim($data['address']    ?? '');
 
if (empty($first_name) || empty($last_name) || empty($email)) {
    echo json_encode(['status' => 'error', 'message' => 'Required fields missing']);
    exit;
}
 
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email format']);
    exit;
}
 
// Check email not used by another user
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ? LIMIT 1");
$stmt->bind_param('si', $email, $user_id);
$stmt->execute();
$stmt->store_result();
 
if ($stmt->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Email already in use']);
    exit;
}
 
$stmt = $conn->prepare(
    "UPDATE users SET nom = ?, prenom = ?, email = ?, phone = ?, address = ? WHERE id = ?"
);
$stmt->bind_param('sssssi', $first_name, $last_name, $email, $phone, $address, $user_id);
 
if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Update failed']);
}