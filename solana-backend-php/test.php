<?php
/**
 * Simple test file for Solana backend
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

echo json_encode([
    'status' => 'working',
    'message' => 'Solana PHP backend is running',
    'timestamp' => date('c'),
    'php_version' => phpversion()
]);
?>
