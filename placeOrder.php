<?php


ini_set('session.cookie_samesite', 'None');
ini_set('session.cookie_secure', '0');
ini_set('session.cookie_httponly', '1');
ini_set('session.gc_maxlifetime', 3600);
ini_set('session.use_strict_mode', '1');

session_start();
include 'db.php';

header('Content-Type: application/json; charset=utf-8');

$allowed = $_SERVER['HTTP_ORIGIN'] ?? '';
header("Access-Control-Allow-Origin: $allowed");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON']);
    exit;
}

// ── Auth: Session أولاً، ثم user_id من الـ payload ──────────
if (isset($_SESSION['user_id'])) {
    $user_id = (int) $_SESSION['user_id'];
} elseif (!empty($data['user_id'])) {
    $check_id = (int) $data['user_id'];
    $chk = $conn->prepare("SELECT id FROM users WHERE id = ? LIMIT 1");
    $chk->bind_param('i', $check_id);
    $chk->execute();
    $chk->store_result();
    if ($chk->num_rows === 0) {
        http_response_code(401);
        echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
        exit;
    }
    $user_id = $check_id;
} else {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
    exit;
}

$cart    = $data['cart']    ?? [];
$payment = $data['payment'] ?? [];
$name    = trim($data['name']    ?? '');
$phone   = trim($data['phone']   ?? '');
$address = trim($data['address'] ?? '');

if (empty($cart)) {
    echo json_encode(['status' => 'error', 'message' => 'Cart is empty']);
    exit;
}
if (empty($name) || empty($phone) || empty($address)) {
    echo json_encode(['status' => 'error', 'message' => 'Missing delivery info']);
    exit;
}

$total = 0;
foreach ($cart as $item) {
    $total += max(1, (int)($item['quantity'] ?? 1)) * (float)($item['price'] ?? 0);
}

$conn->begin_transaction();
try {
    $stmt = $conn->prepare(
        "INSERT INTO orders (user_id, name, phone, address, created_at, status, total)
         VALUES (?, ?, ?, ?, NOW(), 'pending', ?)"
    );
    if (!$stmt) throw new Exception("Prepare orders failed: " . $conn->error);
    $stmt->bind_param('isssd', $user_id, $name, $phone, $address, $total);
    if (!$stmt->execute()) throw new Exception("Insert order failed: " . $stmt->error);
    $order_id = $stmt->insert_id;

    $stmt_item = $conn->prepare(
        "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)"
    );
    if (!$stmt_item) throw new Exception("Prepare order_items failed: " . $conn->error);
    foreach ($cart as $item) {
        $pid   = (int)($item['id'] ?? 0);
        $qty   = max(1, (int)($item['quantity'] ?? 1));
        $price = (float)($item['price'] ?? 0);
        $stmt_item->bind_param('iiid', $order_id, $pid, $qty, $price);
        if (!$stmt_item->execute()) throw new Exception("Insert item failed: " . $stmt_item->error);
    }

    $method = trim($payment['method'] ?? 'unknown');
    $stmt_pay = $conn->prepare(
        "INSERT INTO payments (order_id, amount, status, payment_method, created_at)
         VALUES (?, ?, 'paid', ?, NOW())"
    );
    if (!$stmt_pay) throw new Exception("Prepare payments failed: " . $conn->error);
    $stmt_pay->bind_param('ids', $order_id, $total, $method);
    if (!$stmt_pay->execute()) throw new Exception("Insert payment failed: " . $stmt_pay->error);

    $conn->commit();
    echo json_encode(['status' => 'success', 'order_id' => $order_id]);

} catch (Exception $e) {
    $conn->rollback();
    error_log("[placeOrder] " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}