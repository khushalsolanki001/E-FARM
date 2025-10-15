<?php
// List all crypto payments for admin panel
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "alb";

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT cp.*, CONCAT(u.firstname, ' ', u.lastname) as user_name, i.name as item_name FROM crypto_payments cp
        LEFT JOIN users u ON cp.users_id = u.users_id
        LEFT JOIN items i ON cp.items_id = i.items_id
        ORDER BY cp.created_at DESC";
$result = $conn->query($sql);

$crypto_orders = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $crypto_orders[] = $row;
    }
}

?>
