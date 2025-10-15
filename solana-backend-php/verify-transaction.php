<?php
// Ensure errors don't render as HTML and are returned as JSON
ini_set('display_errors', '0');
error_reporting(E_ALL);

set_error_handler(function ($severity, $message, $file, $line) {
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'error' => 'Server error: ' . $message,
        'file' => basename($file),
        'line' => $line
    ]);
    exit;
});
// Set headers to allow requests from your frontend and return JSON
header("Access-Control-Allow-Origin: http://localhost");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

// Handle preflight request for CORS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

// --- Database Connection ---
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "alb";

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

// --- Read and Decode JSON Input ---
$json_data = file_get_contents('php://input');
if ($json_data === false || $json_data === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Empty request body']);
    exit;
}

$data = json_decode($json_data);
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid JSON: ' . json_last_error_msg()]);
    exit;
}

// --- Validate Input Data ---
if (
    !isset($data->signature) || !isset($data->usersId) || !isset($data->itemsId) ||
    !isset($data->rupeesAmount) || !isset($data->qty)
) {
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'error' => 'Missing required fields.']);
    exit;
}

// --- Sanitize and Prepare Data ---
$signature = $conn->real_escape_string($data->signature);
$users_id = intval($data->usersId);
$items_id = intval($data->itemsId);
$qty = intval($data->qty);
$total_rupees = intval(round(floatval($data->rupeesAmount)));
$payment_type = 'sol';
$order_status = 'Completed';

// Optional crypto metadata
$wallet_address = isset($data->walletAddress) ? $conn->real_escape_string($data->walletAddress) : null;
$usd_amount = isset($data->usdAmount) ? floatval($data->usdAmount) : null;
$sol_amount = isset($data->solAmount) ? floatval($data->solAmount) : null;

// --- Insert into Database matching existing schema ---
$sql = "INSERT INTO sales (users_id, items_id, qty, total, date, payment_type, order_status) VALUES (?, ?, ?, ?, NOW(), ?, ?)";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Failed to prepare statement: ' . $conn->error]);
    exit;
}

$stmt->bind_param("iiiiss", $users_id, $items_id, $qty, $total_rupees, $payment_type, $order_status);

if ($stmt->execute()) {
    // Ensure crypto_payments table exists
    $createCryptoTableSql = "CREATE TABLE IF NOT EXISTS crypto_payments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        users_id INT NOT NULL,
        items_id INT NOT NULL,
        signature VARCHAR(255) NOT NULL,
        wallet_address VARCHAR(100) NULL,
        total_rupees INT NOT NULL,
        usd_amount DECIMAL(18,6) NULL,
        sol_amount DECIMAL(18,9) NULL,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_signature (signature),
        INDEX idx_users (users_id),
        INDEX idx_items (items_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    $conn->query($createCryptoTableSql);

    // Insert crypto metadata (best-effort; ignore failures)
    $insertCrypto = $conn->prepare("INSERT INTO crypto_payments (users_id, items_id, signature, wallet_address, total_rupees, usd_amount, sol_amount) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if ($insertCrypto) {
        $insertCrypto->bind_param("iissidd", $users_id, $items_id, $signature, $wallet_address, $total_rupees, $usd_amount, $sol_amount);
        $insertCrypto->execute();
        $insertCrypto->close();
    }

    // Deduct stock from items table
    $updateStockSql = "UPDATE items SET stock = stock - ? WHERE items_id = ?";
    $updateStockStmt = $conn->prepare($updateStockSql);
    if ($updateStockStmt) {
        $updateStockStmt->bind_param("ii", $qty, $items_id);
        $updateStockStmt->execute();
        $updateStockStmt->close();
    }
    echo json_encode([
        'success' => true,
        'message' => 'Order placed successfully.',
        'signature' => $signature
    ]);
} else {
    // Database update failed
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Failed to save order: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>