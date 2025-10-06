<?php
session_start();

$host="localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "alb";

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

if (mysqli_connect_error()) {
    die('Connect error('. mysqli_connect_error().')'. mysqli_connect_error());
}

if(!isset($_SESSION['users_id'])){
    header('Location: ../login/login.php');
    exit();
}

$loggedInUserId = $_SESSION['users_id'];

$query = "SELECT users_id, firstname FROM users WHERE users_id='".mysqli_real_escape_string($conn, $loggedInUserId)."' LIMIT 1";
$result = mysqli_query($conn, $query);

if($result && mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);
    $_SESSION['user'] = $row['firstname'];
    $_SESSION['users_id'] = $row['users_id'];
} else {
    // If user id in session is invalid, force logout
    session_unset();
    session_destroy();
    header('Location: ../login/login.php');
    exit();
}
?>