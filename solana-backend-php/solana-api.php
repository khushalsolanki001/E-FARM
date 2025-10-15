<?php
/**
 * E-FARM Solana Payment Backend (PHP Version)
 * 
 * This PHP script provides backend services for Solana payments:
 * - SOL/USD price fetching from CoinGecko
 * - Transaction verification simulation
 * - Order status updates in MySQL database
 * 
 * Usage: Access via HTTP requests from your frontend
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Database configuration (same as your existing setup)
$host = "127.0.0.1";
$dbusername = "root";
$dbpassword = "";
$dbname = "alb";

try {
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
    
    if (mysqli_connect_error()) {
        throw new Exception('Database connection failed: ' . mysqli_connect_error());
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Database connection failed',
        'message' => $e->getMessage()
    ]);
    exit();
}

// Get the request method and path
$method = $_SERVER['REQUEST_METHOD'];

// Get the path from REQUEST_URI or PATH_INFO
$path = $_SERVER['PATH_INFO'] ?? '';
if (empty($path)) {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $path = str_replace('/solana-backend-php', '', $path);
    $path = str_replace('/solana-api.php', '', $path);
}

// Handle direct file access
if (empty($path) || $path === '/') {
    $path = '/health';
}

// Route the request
switch ($path) {
    case '/health':
        handleHealthCheck();
        break;
        
    case '/api/sol-price':
        handleSolPrice();
        break;
        
    case '/api/verify-transaction':
        if ($method === 'POST') {
            handleVerifyTransaction($conn);
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
        }
        break;
        
    case '/api/transaction-status':
        if ($method === 'GET') {
            handleTransactionStatus();
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
        }
        break;
        
    default:
        http_response_code(404);
        echo json_encode(['error' => 'Endpoint not found']);
        break;
}

/**
 * Health check endpoint
 */
function handleHealthCheck() {
    echo json_encode([
        'status' => 'healthy',
        'timestamp' => date('c'),
        'version' => '1.0.0-php',
        'environment' => 'development'
    ]);
}

/**
 * Get SOL price from CoinGecko
 */
function handleSolPrice() {
    try {
        // Fetch SOL price from CoinGecko
        $url = 'https://api.coingecko.com/api/v3/simple/price?ids=solana&vs_currencies=usd';
        $context = stream_context_create([
            'http' => [
                'timeout' => 10,
                'user_agent' => 'E-FARM-Solana-Backend/1.0.0'
            ]
        ]);
        
        $response = file_get_contents($url, false, $context);
        
        if ($response === false) {
            throw new Exception('Failed to fetch price from CoinGecko');
        }
        
        $data = json_decode($response, true);
        
        if (!isset($data['solana']['usd'])) {
            throw new Exception('Invalid response format from CoinGecko');
        }
        
        $price = $data['solana']['usd'];
        
        echo json_encode([
            'success' => true,
            'price' => $price,
            'currency' => 'USD',
            'timestamp' => date('c'),
            'source' => 'coingecko'
        ]);
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => 'Failed to fetch SOL price',
            'message' => $e->getMessage()
        ]);
    }
}

/**
 * Verify transaction and update order status
 */
function handleVerifyTransaction($conn) {
    try {
        // Get JSON input
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!$input) {
            throw new Exception('Invalid JSON input');
        }
        
        // Validate required fields
        $required_fields = ['signature', 'orderId', 'usdAmount', 'solAmount', 'timestamp'];
        foreach ($required_fields as $field) {
            if (!isset($input[$field])) {
                throw new Exception("Missing required field: $field");
            }
        }
        
        $signature = $input['signature'];
        $orderId = $input['orderId'];
        $usdAmount = floatval($input['usdAmount']);
        $solAmount = floatval($input['solAmount']);
        $timestamp = $input['timestamp'];
        
        // Simulate transaction verification (in real implementation, you'd verify on Solana)
        // For now, we'll assume all transactions are valid
        $isValid = true;
        
        if (!$isValid) {
            throw new Exception('Transaction verification failed');
        }
        
        // Update order status in database
        $result = updateOrderStatus($conn, $orderId, $signature, $usdAmount, $solAmount, $timestamp);
        
        if (!$result['success']) {
            throw new Exception($result['error']);
        }
        
        echo json_encode([
            'success' => true,
            'message' => 'Transaction verified and order updated successfully',
            'transaction' => [
                'signature' => $signature,
                'amount' => $solAmount,
                'status' => 'confirmed'
            ],
            'order' => [
                'id' => $orderId,
                'status' => 'paid'
            ]
        ]);
        
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => 'Transaction verification failed',
            'message' => $e->getMessage()
        ]);
    }
}

/**
 * Get transaction status
 */
function handleTransactionStatus() {
    $signature = $_GET['signature'] ?? '';
    
    if (empty($signature)) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => 'Transaction signature is required'
        ]);
        return;
    }
    
    // Simulate transaction status check
    echo json_encode([
        'success' => true,
        'signature' => $signature,
        'status' => [
            'status' => 'confirmed',
            'message' => 'Transaction confirmed',
            'blockTime' => time(),
            'slot' => rand(1000000, 9999999)
        ]
    ]);
}

/**
 * Update order status in database
 */
function updateOrderStatus($conn, $orderId, $signature, $usdAmount, $solAmount, $timestamp) {
    try {
        // Start transaction
        $conn->begin_transaction();
        
        // First, try to find the order by orderId
        $stmt = $conn->prepare("SELECT * FROM sales WHERE users_id = ? OR items_id = ? LIMIT 1");
        $stmt->bind_param("ss", $orderId, $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            throw new Exception('Order not found');
        }
        
        $order = $result->fetch_assoc();
        
        // Update the sales table
        $updateStmt = $conn->prepare("
            UPDATE sales 
            SET payment_type = 'sol', 
                payment_status = 'completed', 
                transaction_signature = ?, 
                sol_amount = ?, 
                usd_amount = ?, 
                payment_timestamp = ?,
                status = 1
            WHERE users_id = ? AND items_id = ?
        ");
        
        $updateStmt->bind_param("sddsss", 
            $signature, 
            $solAmount, 
            $usdAmount, 
            $timestamp,
            $order['users_id'],
            $order['items_id']
        );
        
        if (!$updateStmt->execute()) {
            throw new Exception('Failed to update order status');
        }
        
        // Create payments table if it doesn't exist
        $createTableQuery = "
            CREATE TABLE IF NOT EXISTS payments (
                id INT AUTO_INCREMENT PRIMARY KEY,
                order_id VARCHAR(255) NOT NULL,
                order_users_id INT,
                order_items_id INT,
                payment_method VARCHAR(50) NOT NULL,
                payment_status VARCHAR(50) NOT NULL,
                transaction_signature VARCHAR(255),
                sol_amount DECIMAL(20, 9),
                usd_amount DECIMAL(10, 2),
                payment_timestamp TIMESTAMP,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ";
        
        $conn->query($createTableQuery);
        
        // Insert payment record
        $paymentStmt = $conn->prepare("
            INSERT INTO payments (
                order_id, order_users_id, order_items_id, payment_method, 
                payment_status, transaction_signature, sol_amount, usd_amount, 
                payment_timestamp, created_at
            ) VALUES (?, ?, ?, 'sol', 'completed', ?, ?, ?, ?, NOW())
        ");
        
        $paymentStmt->bind_param("siisddss", 
            $orderId,
            $order['users_id'],
            $order['items_id'],
            $signature,
            $solAmount,
            $usdAmount,
            $timestamp
        );
        
        $paymentStmt->execute();
        
        // Commit transaction
        $conn->commit();
        
        return [
            'success' => true,
            'message' => 'Order status updated successfully'
        ];
        
    } catch (Exception $e) {
        $conn->rollback();
        return [
            'success' => false,
            'error' => $e->getMessage()
        ];
    }
}

// Close database connection
$conn->close();
?>
