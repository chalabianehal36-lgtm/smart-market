<?php

session_start();
include 'db.php';
 
header('Content-Type: application/json');
 
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    exit;
}
 
$nom      = trim($_POST['nom']   ?? '');
$prenom   = trim($_POST['pre']   ?? '');
$phone    = trim($_POST['num']   ?? '');
$email    = trim($_POST['email'] ?? '');
$address  = trim($_POST['add']   ?? '');
$password = $_POST['mdp']        ?? '';
 
// Validation
if (empty($nom) || empty($prenom) || empty($email) || empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'Required fields missing']);
    exit;
}
 
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email format']);
    exit;
}
 
if (strlen($password) < 8) {
    echo json_encode(['status' => 'error', 'message' => 'Password must be at least 8 characters']);
    exit;
}
 
// Check duplicate email
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->store_result();
 
if ($stmt->num_rows > 0) {
    echo json_encode(['status' => 'exists']);
    exit;
}
 
// Hash & insert
$hashed = password_hash($password, PASSWORD_DEFAULT);
 
$stmt = $conn->prepare(
    "INSERT INTO users (nom, prenom, phone, email, address, password) VALUES (?, ?, ?, ?, ?, ?)"
);
$stmt->bind_param('ssssss', $nom, $prenom, $phone, $email, $address, $hashed);
 
if ($stmt->execute()) {
    $last_id = $stmt->insert_id;
 
    session_regenerate_id(true);
    $_SESSION['user_id'] = $last_id;
 
    echo json_encode([
        'status' => 'success',
        'id'     => $last_id,
        'nom'    => $nom,
        'email'  => $email
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Registration failed']);
}