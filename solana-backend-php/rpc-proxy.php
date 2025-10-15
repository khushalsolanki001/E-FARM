<?php
// Set headers to allow requests from your frontend and to return JSON
header("Access-Control-Allow-Origin: http://localhost");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// A reliable Devnet RPC endpoint. You can change this if needed.
$solanaRpcUrl = 'https://api.devnet.solana.com';

// Get the raw POST data from the @solana/web3.js library
$jsonData = file_get_contents('php://input');

// Check if we received any data
if (!$jsonData) {
    http_response_code(400);
    echo json_encode(['error' => 'No data received']);
    exit;
}

// Initialize cURL to forward the request
$ch = curl_init($solanaRpcUrl);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
curl_setopt($ch, CURLOPT_POST, true);           // Set the request method to POST
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData); // Forward the exact JSON payload
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Content-Length: ' . strlen($jsonData)
]);

// Execute the request and get the response from the Solana RPC
$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Check for cURL errors
if (curl_errno($ch)) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'cURL Error: ' . curl_error($ch)]);
} else if ($httpcode >= 400) {
    // If the Solana RPC returned an error, forward it
    http_response_code($httpcode);
    echo $response;
} else {
    // If successful, echo the response back to the frontend
    echo $response;
}

// Close the cURL session
curl_close($ch);
?>