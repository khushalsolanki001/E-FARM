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
    <title><?php echo $_SESSION['user'] ?> | Product Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2ecc71;
            --secondary-color: #27ae60;
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
            font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background: #f5f5f7;
            min-height: 100vh;
            color: var(--dark-color);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header Styles */
        .header {
            background: rgba(255, 255, 255, 0.98);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow);
        }

        .logo a {
            text-decoration: none;
            color: var(--dark-color);
            font-size: 2.5rem;
            font-weight: 700;
            letter-spacing: -1px;
        }

        /* Navigation */
        .nav {
            background: white;
            border-radius: 15px;
            margin: 20px 0;
            box-shadow: var(--shadow);
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
        }

        .nav a:hover {
            color: var(--primary-color);
        }

        /* Product Section */
        .product-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 50px;
            padding: 50px 0;
            align-items: start;
        }

        .product-image {
            background: white;
            padding: 40px;
            border-radius: 30px;
            box-shadow: var(--shadow);
            text-align: center;
            transition: var(--transition);
        }

        .product-image:hover {
            transform: translateY(-10px);
        }

        .product-image img {
            max-width: 100%;
            height: auto;
            border-radius: 20px;
        }

        .product-details {
            background: white;
            padding: 40px;
            border-radius: 30px;
            box-shadow: var(--shadow);
        }

        .product-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            letter-spacing: -1px;
        }

        .product-brand {
            color: var(--primary-color);
            font-size: 1.2rem;
            margin-bottom: 15px;
        }

        .product-price {
            font-size: 2rem;
            font-weight: 600;
            margin: 20px 0;
            color: var(--dark-color);
        }

        .product-description {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.8;
        }

        .product-type {
            display: inline-block;
            background: var(--gradient);
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        .action-buttons {
            display: flex;
            gap: 20px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            padding: 15px 30px;
            border: none;
            border-radius: 25px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        .btn-wishlist {
            background: #f8f9fa;
            color: var(--dark-color);
            border: 2px solid #dee2e6;
        }

        .btn-buy {
            background: var(--gradient);
            color: white;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* Reviews Section */
        .reviews-section {
            background: white;
            padding: 40px;
            border-radius: 30px;
            margin-top: 30px;
            box-shadow: var(--shadow);
        }

        .reviews-title {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .review-item {
            padding: 20px 0;
            border-bottom: 1px solid #eee;
        }

        .review-item:last-child {
            border-bottom: none;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .product-container {
                grid-template-columns: 1fr;
            }

            .nav-container {
                flex-direction: column;
            }

            .action-buttons {
                flex-direction: column;
            }

            .product-title {
                font-size: 2rem;
            }
        }



        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .review-date {
            color: #666;
            font-size: 0.9rem;
        }

        .review-text {
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="logo">
                <a href="../index.php">E-FARM</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="nav">
            <div class="nav-container">
                <div class="nav-left">
                    <a href="user_home.php"><i class="fas fa-home"></i> Home</a>
                    <a href="view_wishlist.php"><i class="fas fa-heart"></i>Cart</a>
                    <a href="item.php"><i class="fas fa-store"></i> All Items</a>
                   
                    <a href="user_order.php"><i class="fas fa-box"></i> My Orders</a>
                </div>
                <div class="nav-right">
                    <a href="user.php"><i class="fas fa-user"></i> My Account</a>
                    <a href="u_logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a>
                
                </div>
            </div>
        </div>

        <?php
        $host="localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "alb";

        $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

        if (mysqli_connect_error()) {
            die('Connect error('. mysqli_connect_error().')'. mysqli_connect_error());
        }

        $items_id = $_GET['items_id'];
        $sql = "SELECT * from items where items_id=$items_id;";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        
        if($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $pathx = "../admin/image/";
                $file = $row["img"];
                ?>
                
                <div class="product-container">
                    <div class="product-image">
                        <img src="<?php echo $pathx.$file; ?>" alt="<?php echo $row['name']; ?>">
                    </div>
                    
                    <div class="product-details">
                        <span class="product-type"><?php echo $row['types']; ?></span>
                        <h1 class="product-title"><?php echo $row['name']; ?></h1>
                        <div class="product-brand"><?php echo $row['brand']; ?></div>
                        <p class="product-description"><?php echo $row['description']; ?></p>
                        <div class="product-price">₹<?php echo $row['price']; ?></div>
                        
                        <div class="action-buttons">
                            <a href="wishlist.php?items_id=<?php echo $row['items_id']; ?>" class="btn btn-wishlist">
                                <i class="fas fa-heart"></i> Add to cart
                            </a>
                            <a href="buy.php?items_id=<?php echo $row['items_id']; ?>" class="btn btn-buy">
                                <i class="fas fa-shopping-cart"></i> Buy Now
                            </a>
                        </div>
                    </div>
                </div>

                <?php
            }
        }

        // Reviews Section
        $sql = "SELECT s.review, s.date, CONCAT(u.firstname, ' ', u.lastname) as user_name 
                FROM sales s 
                INNER JOIN users u ON s.users_id = u.users_id 
                WHERE s.items_id='$items_id' AND s.review IS NOT NULL";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        
        if($resultCheck > 0) {
            echo '<div class="reviews-section">';
            echo '<h2 class="reviews-title">Customer Reviews</h2>';
            
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="review-item">';
                echo '<div class="review-header">';
                echo '<strong>' . $row['user_name'] . '</strong>';
                echo '<div class="review-date">' . date('d M Y', strtotime($row['date'])) . '</div>';
                echo '</div>';
                

                
                echo '<div class="review-text">' . $row['review'] . '</div>';
                echo '</div>';
            }
            
            echo '</div>';
        }

        $_SESSION['items_id'] = $items_id;
        ?>
    </div>
</body>
</html>