<?php
session_start();
if(!isset($_SESSION['users_id'])) {
    header('Location: ../login/login.php');
    exit;
}

if(isset($_GET['sales_id']) && isset($_GET['review'])) {
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "alb";

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    if (mysqli_connect_error()) {
        die('Connect error('. mysqli_connect_error().')'. mysqli_connect_error());
    }

    $sales_id = $_GET['sales_id'];
    $review = $_GET['review'];
    $users_id = $_SESSION['users_id'];

    // Check if review table exists
    $checkTable = mysqli_query($conn, "SHOW TABLES LIKE 'reviews'");
    if(mysqli_num_rows($checkTable) == 0) {
        // Create reviews table if it doesn't exist
        $createTable = "CREATE TABLE reviews (
            review_id INT AUTO_INCREMENT PRIMARY KEY,
            sales_id INT,
            users_id INT,
            review TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        mysqli_query($conn, $createTable);
    }

    // Insert the review
    $sql = "INSERT INTO reviews (sales_id, users_id, review) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $sales_id, $users_id, $review);
    
    if($stmt->execute()) {
        $_SESSION['tmp'] = "Review submitted successfully!";
    } else {
        $_SESSION['tmp'] = "Error submitting review. Please try again.";
    }

    $stmt->close();
    $conn->close();

    header('Location: user_order.php');
    exit;
} else {
    header('Location: user_order.php');
    exit;
}
?>