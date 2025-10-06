<?php

$host="localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "alb";

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);


if (mysqli_connect_error()) {
		die('Connect error('. mysqli_connect_error().')'. mysqli_connect_error());
	}
	
$txt1=filter_input(INPUT_POST, 'users_id');
$txt2=filter_input(INPUT_POST, 'items_id');
$txt3=filter_input(INPUT_POST, 'price');
$txt4=filter_input(INPUT_POST, 'qty');
$txt5=filter_input(INPUT_POST, 'total');
$payment_type = filter_input(INPUT_POST, 'payment_method');

// Set payment type based on the payment method
if ($payment_type == 'cod') {
    $payment_type = 'cod';
} else {
    $payment_type = 'card';
}

date_default_timezone_set("Asia/Kolkata");
$txt6=date('y-m-d H:i:s');

// Set default values for required fields
$supplier = 0;
$status = 0;
$req_date = '0000-00-00 00:00:00';
$supplier_date = '0000-00-00 00:00:00';
$proc_date = '0000-00-00 00:00:00';
$delivery_date = '0000-00-00 00:00:00';

// First check if payment_type column exists
$checkColumn = mysqli_query($conn, "SHOW COLUMNS FROM sales LIKE 'payment_type'");
$columnExists = mysqli_num_rows($checkColumn) > 0;

if ($columnExists) {
    $sql = "INSERT INTO `sales`(`users_id`,items_id,qty,`total`,`date`,`supplier`,`status`,`req_date`,`supplier_date`,`proc_date`,`delivery_date`,`payment_type`)
    values('$txt1','$txt2','$txt4','$txt5','$txt6','$supplier','$status','$req_date','$supplier_date','$proc_date','$delivery_date','$payment_type')";
} else {
    // If column doesn't exist, add it first
    $addColumn = "ALTER TABLE sales ADD COLUMN payment_type VARCHAR(10) DEFAULT 'card' AFTER delivery_date";
    if ($conn->query($addColumn)) {
        $sql = "INSERT INTO `sales`(`users_id`,items_id,qty,`total`,`date`,`supplier`,`status`,`req_date`,`supplier_date`,`proc_date`,`delivery_date`,`payment_type`)
        values('$txt1','$txt2','$txt4','$txt5','$txt6','$supplier','$status','$req_date','$supplier_date','$proc_date','$delivery_date','$payment_type')";
    } else {
        // If we can't add the column, insert without payment_type
        $sql = "INSERT INTO `sales`(`users_id`,items_id,qty,`total`,`date`,`supplier`,`status`,`req_date`,`supplier_date`,`proc_date`,`delivery_date`)
        values('$txt1','$txt2','$txt4','$txt5','$txt6','$supplier','$status','$req_date','$supplier_date','$proc_date','$delivery_date')";
    }
}

	
	//update stock of items   
	//$stock = "SELECT stock from items where items_id='$txt2'";
    $sql1="UPDATE items SET stock=stock-'$txt4' where items_id='$txt2'";
	
	if ($conn->query($sql1)) {
	if ($conn->query($sql)) {		
		header('Location: user_order.php');	
	}}

?>
