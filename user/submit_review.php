<?php
session_start();
if(!isset($_SESSION['users_id'])) {
    header('Location: ../login/login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "alb";

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    if (mysqli_connect_error()) {
        die('Connect Error('. mysqli_connect_error().')'. mysqli_connect_error());
    }

    $sales_id = $_POST['sales_id'];
    $items_id = $_POST['items_id'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    // Debug information
    echo "Sales ID: " . $sales_id . "<br>";
    echo "Items ID: " . $items_id . "<br>";
    echo "Rating: " . $rating . "<br>";
    echo "Review: " . $review . "<br>";

    // Simple query instead of prepared statement
    $sql = "UPDATE sales SET review = '$review', rating = $rating 
            WHERE sales_id = $sales_id AND items_id = $items_id";
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['success_msg'] = "Review submitted successfully!";
        header('Location: user_order.php');
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

    $conn->close();
}
?> 