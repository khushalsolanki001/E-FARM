<?php
/**
 * Health check endpoint
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

echo json_encode([
    'status' => 'healthy',
    'timestamp' => date('c'),
    'version' => '1.0.0-php',
    'environment' => 'development'
]);
?>
