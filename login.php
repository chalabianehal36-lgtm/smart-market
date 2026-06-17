<?php

session_start();
include 'db.php';
 
header('Content-Type: application/json');
 
// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    exit;
}
 
$email    = trim($_POST['email']    ?? '');
$password = trim($_POST['password'] ?? '');
 
// Basic validation
if (empty($email) || empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
    exit;
}
 
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email format']);
    exit;
}
 
// Check if email exists
$stmt = $conn->prepare(
    "SELECT id, nom, prenom, email, password, phone, address FROM users WHERE email = ? LIMIT 1"
);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();
 
if ($result->num_rows === 0) {
    echo json_encode(['status' => 'email_not_found']);
    exit;
}
 
$user = $result->fetch_assoc();
 
// Verify password
if (!password_verify($password, $user['password'])) {
    echo json_encode(['status' => 'wrong_password']);
    exit;
}
 
// Regenerate session ID to prevent session fixation
session_regenerate_id(true);
 
$_SESSION['user_id'] = $user['id'];
 
echo json_encode([
    'status'  => 'success',
    'id'      => $user['id'],
    'nom'     => $user['nom'],
    'prenom'  => $user['prenom'],
    'email'   => $user['email'],
    'phone'   => $user['phone'],
    'address' => $user['address']
]);