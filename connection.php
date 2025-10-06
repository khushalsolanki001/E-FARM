<?php
$host = "127.0.0.1";
$dbusername = "root";
$dbpassword = "";
$dbname = "alb";

$con = new mysqli($host, $dbusername, $dbpassword, $dbname, 3306);

if (mysqli_connect_error()) {
    die('Connect error('. mysqli_connect_error().')'. mysqli_connect_error());
}
?>