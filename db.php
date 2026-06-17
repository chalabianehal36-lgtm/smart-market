<?php


define('DB_HOST', 'localhost');           
define('DB_USER', 'your_db_username');    
define('DB_PASS', 'your_db_password');    
define('DB_NAME', 'your_db_name');        

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit;
}

$conn->set_charset('utf8mb4');
