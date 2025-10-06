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
	<title>Welcome | <?php echo htmlspecialchars($_SESSION['user']); ?></title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<style>
		:root {
			--primary-color: #2ecc71;
			--secondary-color: #27ae60;
			--accent-color: #3498db;
			--dark-color: #2c3e50;
			--light-color: #ecf0f1;
			--transition: all 0.3s ease;
			--shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
			--gradient: linear-gradient(135deg, #2ecc71, #27ae60);
		}

		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
			font-family: 'Poppins', sans-serif;
		}

		body {
			background-image: url('../css/image/img5.jpeg');
			background-repeat: no-repeat;
			background-attachment: fixed;
			background-size: cover;
			min-height: 100vh;
			position: relative;
		}

		body::before {
			content: '';
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: rgba(0, 0, 0, 0.3);
			z-index: 0;
		}

		.container {
			max-width: 1400px;
			margin: 0 auto;
			padding: 0 20px;
			position: relative;
			z-index: 1;
		}

		/* Enhanced Header */
		.header {
			background: rgba(255, 255, 255, 0.95);
			padding: 15px 0;
			box-shadow: var(--shadow);
			position: relative;
			margin-bottom: 40px;
		}

		.logo {
			text-align: center;
			margin-bottom: 15px;
		}

		.logo a {
			text-decoration: none;
			color: var(--dark-color);
			font-size: 3.8rem;
			font-weight: 800;
			letter-spacing: 2px;
			text-transform: uppercase;
			position: relative;
			display: inline-block;
		}

		.logo a::after {
			content: 'Your Farming Partner';
			position: absolute;
			bottom: -10px;
			left: 50%;
			transform: translateX(-50%);
			font-size: 1rem;
			font-weight: 400;
			color: var(--secondary-color);
			width: 100%;
			text-align: center;
		}

		/* Stylish Search Bar */
		.search-container {
			max-width: 700px;
			margin: 0 auto;
			padding: 20px;
		}

		.search-container form {
			display: flex;
			gap: 15px;
			background: white;
			padding: 5px;
			border-radius: 50px;
			box-shadow: var(--shadow);
		}

		.search-container input[type="text"] {
			flex: 1;
			padding: 15px 25px;
			border: none;
			border-radius: 50px;
			font-size: 1.1rem;
			outline: none;
		}

		.search-container input[type="submit"] {
			padding: 15px 35px;
			background: var(--gradient);
			color: white;
			border: none;
			border-radius: 50px;
			cursor: pointer;
			font-weight: 600;
			text-transform: uppercase;
			letter-spacing: 1px;
			transition: var(--transition);
		}

		.search-container input[type="submit"]:hover {
			transform: translateY(-2px);
			box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
		}

		/* Modern Navigation */
		.nav {
			background: white;
			border-radius: 15px;
			margin: 20px 0;
			box-shadow: var(--shadow);
			overflow: hidden;
		}

		.nav-container {
			display: flex;
			justify-content: space-between;
			padding: 0 20px;
		}

		.nav a {
			color: var(--dark-color);
			text-decoration: none;
			padding: 20px 25px;
			display: inline-block;
			transition: var(--transition);
			font-weight: 500;
			position: relative;
		}

		.nav a::after {
			content: '';
			position: absolute;
			bottom: 0;
			left: 50%;
			transform: translateX(-50%);
			width: 0;
			height: 3px;
			background: var(--gradient);
			transition: var(--transition);
		}

		.nav a:hover::after {
			width: 80%;
		}

		.nav a:hover {
			color: var(--primary-color);
		}

		/* Attractive Categories Grid */
		.categories-grid {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
			gap: 25px;
			padding: 20px;
		}

		.category-card {
			background: rgba(255, 255, 255, 0.95);
			border-radius: 20px;
			overflow: hidden;
			transition: var(--transition);
			position: relative;
			box-shadow: var(--shadow);
		}

		.category-card::before {
			content: '';
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: var(--gradient);
			opacity: 0;
			transition: var(--transition);
		}

		.category-card a {
			text-decoration: none;
			color: var(--dark-color);
			font-size: 1.5rem;
			font-weight: 600;
			padding: 30px 20px;
			display: flex;
			align-items: center;
			justify-content: center;
			height: 100%;
			position: relative;
			z-index: 1;
			transition: var(--transition);
		}

		.category-card:hover {
			transform: translateY(-5px);
		}

		.category-card:hover::before {
			opacity: 1;
		}

		.category-card:hover a {
			color: white;
		}

		/* Responsive Design */
		@media (max-width: 768px) {
			.nav-container {
				flex-direction: column;
			}

			.logo a {
				font-size: 2.5rem;
			}

			.logo a::after {
				font-size: 0.8rem;
			}

			.search-container form {
				flex-direction: column;
				border-radius: 15px;
			}

			.search-container input[type="text"],
			.search-container input[type="submit"] {
				width: 100%;
				border-radius: 10px;
			}

			.categories-grid {
				grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
				gap: 15px;
			}
		}
	</style>
</head>
<body>
	<div class="header">
		<div class="container">
			<div class="logo">
				<a href="../index.php">E-FARM</a>
			</div>
			<div class="search-container">
				<form method="post" action="search.php">
					<input type="text" name="search" placeholder="What are you looking for today?">
					<input type="submit" name="submit" value="Search">
				</form>
			</div>
		</div>
	</div>


	<div class="container">
		<div class="nav">
			<div class="nav-container">
				<div class="nav-left">
					<a href="user_home.php"><i class="fas fa-home"></i> Home</a>
					<a href="view_wishlist.php"><i class="fas fa-heart"></i>  cart</a>
					<a href="item.php"><i class="fas fa-store"></i> All Items</a>
					
					<a href="user_order.php"><i class="fas fa-box"></i> My Orders</a>
				</div>
				<div class="nav-right">
					<a href="user.php"><i class="fas fa-user"></i> My Account</a>
					<a href="u_logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a>
			
				</div>
			</div>
		</div>

		<div class="categories-grid">
			<div class="category-card">
				<a href="view.php?choice=FERTILIZER"><i class="fas fa-seedling"></i> FERTILIZER</a>
			</div>
			<div class="category-card">
				<a href="view.php?choice=HERBICIDE"><i class="fas fa-spray-can"></i> HERBICIDE</a>
			</div>
			<div class="category-card">
				<a href="view.php?choice=INSECTICIDES"><i class="fas fa-bug"></i> INSECTICIDES</a>
			</div>
			<div class="category-card">
				<a href="view.php?choice=PESTICIDES"><i class="fas fa-skull-crossbones"></i> PESTICIDES</a>
			</div>
			<div class="category-card">
				<a href="view.php?choice=SPRAYER"><i class="fas fa-shower"></i> SPRAYER</a>
			</div>
			<div class="category-card">
				<a href="view.php?choice=OTHER"><i class="fas fa-ellipsis-h"></i> OTHER</a>
			</div>
		</div>
	</div>
</body>
</html>