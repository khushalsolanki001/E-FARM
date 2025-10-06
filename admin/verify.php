<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>E-FARM | Verify Admin</title>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"> <!-- Google Font -->
	<style>
		body {
			background-color: #f9f9f9; /* Light background */
			font-family: 'Roboto', sans-serif; /* Updated font */
			margin: 0;
			padding: 0;
		}

		.container {
			width: 600px; /* Further increased width */
			margin: 100px auto;
			padding: 40px; /* Further increased padding */
			background: rgba(255, 255, 255, 0.95);
			border-radius: 20px; /* More rounded corners */
			box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25); /* Enhanced shadow */
		}

		h1 {
			text-align: center;
			color: #00875A; /* Green color */
			font-size: 56px; /* Further increased font size */
			margin-bottom: 25px;
			font-weight: bold;
			text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
		}

		h2 {
			text-align: center;
			color: #333;
			font-size: 28px; /* Increased font size */
			margin-bottom: 20px;
		}

		label {
			font-size: 20px; /* Increased font size */
			color: #333;
		}

		input[type=password] {
			width: 100%;
			padding: 20px; /* Further increased padding */
			margin: 15px 0; /* Further increased margin */
			border: 3px solid #00875A; /* Thicker colored border */
			border-radius: 10px;
			box-sizing: border-box;
			font-size: 24px; /* Further increased font size */
			transition: all 0.3s ease;
		}
		input[type=password]:focus {
			border-color: #006c47;
			box-shadow: 0 0 10px rgba(0, 135, 90, 0.3);
			transform: scale(1.02);
		}

		input[type=submit] {
			width: 100%;
			background-color: #00875A; /* Green */
			color: white; /* White text */
			padding: 20px; /* Further increased padding */
			margin: 20px 0; /* Further increased margin */
			border: none;
			border-radius: 12px;
			cursor: pointer;
			font-size: 26px; /* Further increased font size */
			font-weight: bold;
			text-transform: uppercase;
			letter-spacing: 2px;
			transition: all 0.3s ease;
			box-shadow: 0 4px 15px rgba(0, 135, 90, 0.3);
		}

		input[type=submit]:hover {
			background-color: #006c47; /* Darker green */
			transform: translateY(-2px); /* Lift effect */
		}

		.error {
			color: red;
			font-size: 20px; /* Increased font size */
			text-align: center;
		}

		.link {
			text-align: center;
			display: block;
			margin-top: 20px;
			color: #00875A; /* Green color */
			text-decoration: none;
			font-size: 20px; /* Increased font size */
		}

		.link:hover {
			text-decoration: underline;
		}

		/* Responsive Design */
		@media (max-width: 768px) {
			.container {
				width: 90%; /* Full width on smaller screens */
			}
		}
	</style>
</head>
<body>

<div class="container">
	<h1>E-FARM</h1>
	<h2>Admin Login</h2>
	<form action="admin_home.php" method="POST">
		<label for="CODE">CODE:</label>
		<input type="password" id="CODE" name="CODE" placeholder="Enter the CODE" required autofocus>
		<input type="submit" value="ENTER">
		<?php
		session_start();
		if(isset($_SESSION['tmp']))
		{
			echo '<p class="error">'.$_SESSION['tmp'].'</p>';
			unset($_SESSION['tmp']);
		}
		?>
		<a class="link" href="../index.php">HOME</a>
	</form>
</div>

</body>
</html>