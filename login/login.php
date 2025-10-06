<!DOCTYPE html>
<html>
<head>
	<title>Login | E-FARM</title>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
	<style>
		body {
			margin: 0;
			padding: 0;
			display: flex;
			justify-content: center;
			align-items: center;
			min-height: 100vh;
			font-family: 'Poppins', sans-serif;
			background-color: #ffffff;
		}

		.login-card {
			background: white;
			padding: 40px;
			border-radius: 15px;
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
			width: 100%;
			max-width: 450px;
			position: relative;
		}

		.login-title {
			color: #00875A;
			font-size: 42px;
			font-weight: 600;
			margin-bottom: 35px;
			text-align: left;
		}

		.login-tabs {
			display: flex;
			margin-bottom: 30px;
			border-bottom: 1px solid #e0e0e0;
		}

		.tab {
			padding: 12px 0;
			margin-right: 25px;
			color: #666;
			text-decoration: none;
			font-size: 18px;
		}

		.form-group {
			margin-bottom: 25px;
		}

		.form-group label {
			display: block;
			color: #00875A;
			margin-bottom: 10px;
			font-weight: 500;
			font-size: 18px;
		}

		.form-group input {
			width: 100%;
			padding: 15px;
			border: 2px solid #e0e0e0;
			border-radius: 8px;
			font-size: 16px;
			box-sizing: border-box;
			background-color: #f8f8f8;
		}

		.password-options {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 25px;
			font-size: 16px;
		}

		.show-password {
			display: flex;
			align-items: center;
			gap: 8px;
			color: #666;
		}

		.forgot-password {
			color: #00875A;
			text-decoration: none;
			font-size: 16px;
		}

		.login-btn {
			background-color: #00875A;
			color: white;
			width: 100%;
			padding: 16px;
			border: none;
			border-radius: 30px;
			font-size: 20px;
			font-weight: 500;
			cursor: pointer;
			transition: all 0.3s ease;
		}

		.login-btn:hover {
			background-color: #006c47;
			transform: translateY(-2px);
			box-shadow: 0 4px 12px rgba(0,0,0,0.15);
		}

		.home-btn {
			position: absolute;
			top: 20px;
			left: 20px;
			background-color: #00875A;
			color: white;
			padding: 10px 20px;
			border-radius: 25px;
			text-decoration: none;
			font-weight: 500;
			display: flex;
			align-items: center;
			gap: 8px;
			transition: background-color 0.3s;
			z-index: 100;
		}

		.home-btn:hover {
			background-color: #006c47;
		}

		.home-icon {
			width: 16px;
			height: 16px;
			fill: currentColor;
		}
	</style>
</head>
<body>
	<a href="../index.php" class="home-btn">
		<svg class="home-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
			<path d="M12 2L2 12h3v8h6v-6h2v6h6v-8h3L12 2z" fill="currentColor"/>
		</svg>
		Home
	</a>

	<div class="login-card">
		<h1 class="login-title">LOGIN</h1>
		
		<div class="login-tabs">
			<a href="#" class="tab active">User Login</a>
			
		</div>

		<form action="login_connection.php" method="POST">
			<div class="form-group">
				<label for="userid">EMAIL ID</label>
				<input type="text" id="userid" name="email" required>
			</div>

			<div class="form-group">
				<label for="password">PASSWORD</label>
				<input type="password" id="password" name="password" required>
			</div>

			<div class="password-options">
				<label class="show-password">
					<input type="checkbox" onclick="togglePassword()"> Show Password
				</label>
				<a href="reset.php" class="forgot-password">Recovery Password</a>
			</div>

			<button type="submit" class="login-btn">Login</button>
		</form>
	</div>

	<script>
		function togglePassword() {
			var x = document.getElementById("password");
			if (x.type === "password") {
				x.type = "text";
			} else {
				x.type = "password";
			}
		}
	</script>
</body>
</html>