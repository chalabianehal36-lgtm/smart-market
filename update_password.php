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
 
$current_password = $data['current_password'] ?? '';
$new_password     = $data['new_password']     ?? '';
 
if (empty($current_password) || empty($new_password)) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
    exit;
}
 
if (strlen($new_password) < 8) {
    echo json_encode(['status' => 'error', 'message' => 'Password must be at least 8 characters']);
    exit;
}
 
$user_id = (int) $_SESSION['user_id'];
 
// Fetch current hash
$stmt = $conn->prepare("SELECT password FROM users WHERE id = ? LIMIT 1");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
 
if ($result->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'User not found']);
    exit;
}
 
$row = $result->fetch_assoc();
 
if (!password_verify($current_password, $row['password'])) {
    echo json_encode(['status' => 'error', 'message' => 'Current password is incorrect']);
    exit;
}
 
$new_hashed = password_hash($new_password, PASSWORD_DEFAULT);
 
$stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
$stmt->bind_param('si', $new_hashed, $user_id);
 
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Password updated successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update password']);
}