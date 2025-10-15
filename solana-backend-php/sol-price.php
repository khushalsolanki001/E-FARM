<?php
/**
 * SOL price endpoint
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

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
?>
