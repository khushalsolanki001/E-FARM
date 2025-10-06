<!DOCTYPE html>
<html>
<head>
	<title>E-FARM - Organic Food & Agriculture</title>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	<style>
		body {
			margin: 0;
			font-family: 'Poppins', sans-serif;
			background-color: #fff;
		}

		.header {
			background-color: #fff;
			padding: 20px 50px;
			display: flex;
			justify-content: space-between;
			align-items: center;
			box-shadow: 0 2px 5px rgba(0,0,0,0.1);
		}

		.logo {
			font-size: 55px;
			font-weight: 700;
			color: #1a472a;
			text-decoration: none;
		}

		.logo span {
			color: #4CAF50;
		}

		.nav-links {
			display: flex;
			gap: 30px;
			align-items: center;
		}

		.nav-links a {
			color: #333;
			text-decoration: none;
			font-size: 22px;
			font-weight: 500;
			padding: 8px 16px;
			border-radius: 20px;
			transition: all 0.3s ease;
		}

		.nav-links a:hover {
			background-color: #e8f5e9;
			color: #4CAF50;
		}

		.auth-links {
			display: flex;
			gap: 15px;
		}

		.auth-links a {
			padding: 10px 20px;
			border-radius: 25px;
			transition: all 0.3s ease;
		}

		.auth-links a:first-child {
			border: 2px solid #4CAF50;
			color: #4CAF50;
		}

		.auth-links a:first-child:hover {
			background-color: #4CAF50;
			color: white;
		}

		.auth-links a:last-child {
			background-color: #4CAF50;
			color: white;
		}

		.auth-links a:last-child:hover {
			background-color: #388e3c;
			transform: translateY(-2px);
		}

		.contact-btn {
			background-color: #b4d334;
			color: #1a472a;
			padding: 12px 25px;
			border-radius: 25px;
			text-decoration: none;
			font-weight: 600;
			display: flex;
			align-items: center;
			gap: 8px;
			transition: all 0.3s ease;
		}

		.contact-btn:hover {
			background-color: #9fb82e;
			transform: translateY(-2px);
			box-shadow: 0 4px 8px rgba(0,0,0,0.1);
		}

		.hero {
			height: 70vh;
			background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('css/image/farm1.jpg');
			background-size: cover;
			background-position: center;
			display: flex;
			align-items: center;
			justify-content: center;
			text-align: center;
			color: white;
		}

		.hero-content h1 {
			font-size: 50px;
			margin-bottom: 20px;
		}

		.hero-content p {
			font-size: 20px;
			margin-bottom: 30px;
		}

		.categories {
			padding: 50px;
			max-width: 1200px;
			margin: 0 auto;
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
			gap: 30px;
			background-color: #f9f9f9;
		}

		.category-card {
			background: white;
			padding: 25px;
			border-radius: 15px;
			text-align: center;
			transition: all 0.3s ease;
			box-shadow: 0 4px 6px rgba(0,0,0,0.1);
			position: relative;
			overflow: hidden;
		}

		.category-card::before {
			content: '';
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: linear-gradient(45deg, #4CAF50, #b4d334);
			opacity: 0;
			transition: all 0.3s ease;
			z-index: 1;
		}

		.category-card:hover {
			transform: translateY(-5px);
			box-shadow: 0 8px 15px rgba(0,0,0,0.2);
		}

		.category-card:hover::before {
			opacity: 0.1;
		}

		.category-card a {
			color: #1a472a;
			text-decoration: none;
			font-weight: 600;
			font-size: 25px;
			position: relative;
			z-index: 2;
			display: flex;
			align-items: center;
			justify-content: center;
			gap: 10px;
		}

		.category-card a::after {
			content: '→';
			opacity: 0;
			transform: translateX(-10px);
			transition: all 0.3s ease;
		}

		.category-card:hover a::after {
			opacity: 1;
			transform: translateX(0);
		}

		.search-bar {
			padding: 20px;
			background-color: rgba(255, 255, 255, 0.1);
			border-radius: 30px;
			backdrop-filter: blur(5px);
		}

		.search-bar input[type="text"] {
			width: 60%;
			padding: 15px 25px;
			border: 2px solid rgba(255, 255, 255, 0.3);
			background: rgba(255, 255, 255, 0.2);
			border-radius: 25px;
			font-size: 20px;
			color: white;
			transition: all 0.3s ease;
		}

		.search-bar input[type="text"]::placeholder {
			color: rgba(255, 255, 255, 0.8);
		}

		.search-bar input[type="submit"] {
			background-color: #4CAF50;
			color: white;
			padding: 15px 30px;
			border: none;
			border-radius: 25px;
			cursor: pointer;
			font-size: 25px;
			margin-left: 10px;
			transition: all 0.3s ease;
		}

		.search-bar input[type="submit"]:hover {
			background-color: #388e3c;
			transform: translateY(-2px);
			box-shadow: 0 4px 8px rgba(0,0,0,0.2);
		}

		/* Footer */
		.footer {
			background-color: #0f2d1a;
			color: #c8e6c9;
			padding: 30px 20px;
			text-align: center;
		}

		/* Responsive */
		@media (max-width: 992px) {
			.logo { font-size: 42px; }
			.nav-links a { font-size: 18px; }
			.hero-content h1 { font-size: 38px; }
			.search-bar input[type="text"] { width: 80%; }
		}

		@media (max-width: 600px) {
			.header { padding: 15px 20px; flex-wrap: wrap; gap: 10px; }
			.nav-links { width: 100%; justify-content: space-between; gap: 10px; }
			.nav-links a { font-size: 16px; padding: 6px 10px; }
			.auth-links a { padding: 8px 14px; }
			.hero { height: 60vh; }
			.hero-content h1 { font-size: 30px; }
			.hero-content p { font-size: 16px; }
			.search-bar { padding: 15px; }
			.search-bar input[type="text"] { width: 100%; font-size: 16px; }
			.search-bar input[type="submit"] { font-size: 18px; padding: 12px 20px; }
		}
	</style>
</head>
<body>
	<div class="header">
		<a href="index.php" class="logo">E-<span>FARM</span></a>
		<div class="nav-links">
			<a href="index.php"><i class="fas fa-home"></i> Home</a>
			<a href="item.php"><i class="fas fa-shopping-basket"></i> Products</a>
			<a href="about.php"><i class="fas fa-info-circle"></i> About</a>
			<a href="admin/admin_home.php"><i class="fas fa-user-shield"></i> Admin</a>
			<div class="auth-links">
				<a href="login/login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
				<a href="signup/signup.php"><i class="fas fa-user-plus"></i> Sign Up</a>
			</div>
		</div>
		<a href="contact.php" class="contact-btn">
			<i class="fas fa-envelope"></i>
			Contact Us
		</a>
	</div>

	<div class="hero">
		<div class="hero-content">
			<h1>Organic food from<br>the ground to your table</h1>
			<p>Your one-stop destination for quality agricultural products</p>
			<div class="search-bar">
				<form method="post" action="search.php">
					<input type="text" name="search" placeholder="Search for products...">
					<input type="submit" name="submit" value="Search">
				</form>
			</div>
		</div>
	</div>

	<div class="categories">
		<div class="category-card">
			<a href="view.php?choice=FERTILIZER">FERTILIZER</a>
		</div>
		<div class="category-card">
			<a href="view.php?choice=HERBICIDE">HERBICIDE</a>
		</div>
		<div class="category-card">
			<a href="view.php?choice=INSECTICIDES">INSECTICIDES</a>
		</div>
		<div class="category-card">
			<a href="view.php?choice=PESTICIDES">PESTICIDES</a>
		</div>
		<div class="category-card">
			<a href="view.php?choice=SPRAYER">SPRAYER</a>
		</div>
		<div class="category-card">
			<a href="view.php?choice=OTHER">OTHER</a>
		</div>
	</div>

	<div class="footer">
		<p>© <?php echo date('Y'); ?> E-FARM. Fresh from farm to table.</p>
	</div>
