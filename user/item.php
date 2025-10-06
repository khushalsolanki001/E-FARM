<?php
    session_start();
    if(!isset($_SESSION['users_id']))
    {
    	header('Location: ../login/login.php');
    }
    else
    {
    	include 'user_config.php';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>All Items | E-FARM</title>
	<style>
		body {
			font-family: 'Poppins', sans-serif;
			background-color: #f9f9f9; /* Light background */
			margin: 0;
			padding: 0;
		}

		.header {
			text-align: center;
			padding: 20px;
			background-color: #00875A; /* Green background */
			color: white;
		}

		.header h1 {
			margin: 0;
			font-size: 48px; /* Increased font size */
		}

		.header a {
			text-decoration: none;
			color: white; /* White color */
		}

		.header a:hover {
			text-decoration: underline;
		}

		.topnav {
			background-color: #006c47; /* Dark green */
			overflow: hidden;
		}

		.topnav a {
			float: left;
			color: #f2f2f2;
			text-align: center;
			padding: 14px 16px;
			text-decoration: none;
			font-size: 17px;
		}

		.topnav a:hover {
			background-color: #ddd;
			color: black;
		}

		.topnav-right {
			float: right;
		} 

		.search-container {
			text-align: center;
			margin: 20px;
		}

		input[type=text] {
			width: 30%;
			padding: 12px 20px;
			margin: 8px 0;
			border: 2px solid #ccc;
			border-radius: 5px;
			box-sizing: border-box;
			font-size: 18px;
		}
		
		input[type=submit] {
			width: 150px;
			background-color: #00875A; /* Green */
			color: white; /* White text */
			padding: 14px 20px;
			margin: 8px 0;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			font-size: 20px;
		}

		.product-container {
			display: flex;
			flex-wrap: wrap;
			justify-content: center;
			margin: 20px;
		}

		.product-card {
			background-color: white;
			border: none;
			border-radius: 15px;
			box-shadow: 0 4px 8px rgba(0,0,0,0.1);
			margin: 15px;
			padding: 20px;
			width: 280px;
			text-align: center;
			transition: all 0.3s ease;
			display: flex;
			flex-direction: column;
			height: 550px;
			position: relative;
			overflow: hidden;
		}

		.product-card:hover {
			transform: translateY(-5px);
			box-shadow: 0 8px 16px rgba(0,0,0,0.2);
		}

		.product-card img {
			width: 240px;
			height: 240px;
			object-fit: cover;
			border-radius: 10px;
			margin: 0 auto 15px;
		}

		.product-details {
			flex-grow: 1;
			display: flex;
			flex-direction: column;
			gap: 8px;
			padding: 0 10px;
		}

		.product-card h3 {
			color: #00875A;
			font-size: 22px;
			margin: 10px 0;
			font-weight: 600;
		}

		.product-card p {
			color: #555;
			font-size: 15px;
			margin: 5px 0;
			line-height: 1.4;
		}

		.product-card p:last-of-type {
			color: #00875A;
			font-size: 20px;
			font-weight: 600;
			margin-top: auto;
		}

		.action-buttons {
			margin-top: 15px;
			padding: 10px 0;
			width: 100%;
		}

		.product-card button {
			background-color: #00875A;
			color: white;
			border: none;
			border-radius: 25px;
			padding: 12px 35px;
			cursor: pointer;
			font-size: 16px;
			font-weight: 500;
			transition: all 0.3s ease;
			width: auto;
			min-width: 140px;
		}

		.product-card button:hover {
			background-color: #006c47;
			transform: translateY(-2px);
			box-shadow: 0 4px 12px rgba(0,0,0,0.15);
		}

		.product-container {
			display: flex;
			flex-wrap: wrap;
			justify-content: center;
			gap: 25px;
			margin: 30px 50px;
		}
	</style>
</head>
<body>

<div class="header">
	<h1><a href="../index.php">E-FARM</a></h1>
</div>

<div class="search-container">
	<form method="post" action="search.php">
		<b>Search: </b><input type="text" name="search" placeholder="Search the Item here.">
		<input type="submit" name="submit">
	</form>
</div>

<div class="topnav">
	<a href="user_home.php">Home</a>  
	<a href="view_wishlist.php">cart</a>
	<a href="item.php">All items</a>
	
	<a href="user_order.php">My Orders</a>

	<div class="topnav-right">
		<a href="user.php">My Account</a>
		<a href="u_logout.php">Log Out</a>
	
	</div>
</div>

<div class="product-container">
	<?php
	$host="localhost";
	$dbusername = "root";
	$dbpassword = "";
	$dbname = "alb";

	$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

	if (mysqli_connect_error()) {
		die('Connect error('. mysqli_connect_error().')'. mysqli_connect_error());
	}

	$allowed = array('FERTILIZER','HERBICIDE','INSECTICIDES','PESTICIDES','SPRAYER','OTHER');
	$allowedList = "'".implode("','", $allowed)."'";
	$sql = "SELECT * from items WHERE types IN ($allowedList);";
	$result=mysqli_query($conn, $sql);
	$resultCheck = mysqli_num_rows($result);
	if($resultCheck > 0){
		// In the PHP section, update the product card output:
		while ($row = mysqli_fetch_assoc($result)) {
			echo "<div class='product-card'>";
			echo "<img src='../admin/image/".$row['img']."' alt='".$row['name']."'>";
			echo "<div class='product-details'>";
			echo "<h3>".$row['name']."</h3>";
			echo "<p><strong>Brand:</strong> ".$row['brand']."</p>";
			echo "<p><strong>Type:</strong> ".$row['types']."</p>";
			echo "<p>".$row['description']."</p>";
			echo "<p>₹".$row['price']."</p>";
			echo "</div>";
			echo "<div class='action-buttons'>";
			echo "<button><a href='item_individual.php?items_id=".$row['items_id']."' style='color: white; text-decoration: none;'>View Details</a></button>";
			echo "</div>";
			echo "</div>";
		}
	}
	?>
</div>
</body>
</html>