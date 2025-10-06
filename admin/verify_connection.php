<?php
$host="localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "alb";

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

if (mysqli_connect_error()) {
    die('Connect error('. mysqli_connect_error().')'. mysqli_connect_error());
}

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM admin WHERE email='$email' AND password='$password'";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {
    session_start();
    $row = mysqli_fetch_assoc($result);
    $_SESSION['admin_id'] = $row['admin_id'];
    header('Location: admin_home.php');
} else {
    header('Location: verify.php');
}
?>