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
    <title>My Orders | <?php echo $_SESSION['user'] ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2ecc71;
            --secondary-color: #27ae60;
            --dark-color: #2c3e50;
            --light-color: #ecf0f1;
            --danger-color: #e74c3c;
            --shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
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
            padding: 20px;
        }

        /* Header */
        .header {
            background: white;
            padding: 20px 0;
            box-shadow: var(--shadow);
            margin-bottom: 40px;
        }

        .logo {
            text-align: center;
        }

        .logo a {
            text-decoration: none;
            color: var(--dark-color);
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
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

        /* Orders Section */
        .orders-container {
            background: white;
            border-radius: 20px;
            box-shadow: var(--shadow);
            overflow: hidden;
            margin-top: 30px;
        }

        .orders-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 20px;
            text-align: center;
        }

        .orders-header h2 {
            font-size: 1.8rem;
            margin: 0;
        }

        .order-card {
            padding: 20px;
            border-bottom: 1px solid #eee;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr auto;
            align-items: center;
            gap: 20px;
            transition: var(--transition);
        }

        .order-card:hover {
            background: rgba(46, 204, 113, 0.05);
        }

        .order-id {
            color: var(--primary-color);
            font-weight: 600;
        }

        .order-date {
            color: #666;
        }

        .order-total {
            font-weight: 600;
            color: var(--dark-color);
        }

        .review-form {
            display: flex;
            gap: 10px;
        }

        .review-input {
            flex: 1;
            padding: 10px;
            border: 2px solid #eee;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .review-input:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        .review-btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
        }

        .review-btn:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
        }

        .empty-orders {
            text-align: center;
            padding: 40px;
            color: #666;
        }

        .empty-orders i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .order-card {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .nav-container {
                flex-direction: column;
            }
        }

        .order-section {
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
        }
        .section-title {
            padding: 15px 20px;
            color: var(--dark-color);
            background: rgba(46, 204, 113, 0.1);
            margin: 0;
            font-size: 1.2rem;
        }
        .cod-order {
            background: rgba(255, 247, 230, 0.5);
        }
        .cod-order:hover {
            background: rgba(255, 247, 230, 0.8);
        }
        .cod-order .order-id i {
            color: #f39c12;
        }
        .payment-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 500;
            margin-left: 8px;
        }
        .payment-badge.cod {
            background: #fff3e0;
            color: #f39c12;
        }
        .payment-badge.card {
            background: #e8f5e9;
            color: #27ae60;
        }
        .cod-order {
            background: rgba(255, 247, 230, 0.5);
            border-left: 4px solid #f39c12;
        }
        .order-card {
            border-left: 4px solid #27ae60;
        }
        .cod-order:hover {
            background: rgba(255, 247, 230, 0.8);
        }
        .cod-order .order-id i {
            color: #f39c12;
        }
        .order-id {
            line-height: 1.8;
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
                    <a href="view_wishlist.php"><i class="fas fa-heart"></i> WishList</a>
                    <a href="item.php"><i class="fas fa-store"></i> All Items</a>
                    
                    <a href="user_order.php"><i class="fas fa-box"></i> My Orders</a>
                </div>
                <div class="nav-right">
                    <a href="user.php"><i class="fas fa-user"></i> My Account</a>
                    <a href="u_logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a>
                   
                </div>
            </div>
        </div>

        <div class="orders-container">
            <div class="orders-header">
                <h2>My Orders</h2>
            </div>

            <?php
            $host = "localhost";
            $dbusername = "root";
            $dbpassword = "";
            $dbname = "alb";

            $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

            if (mysqli_connect_error()) {
                die('Connect error('. mysqli_connect_error().')'. mysqli_connect_error());
            }

            // First display Card Payment Orders
            ?>
            <h3 class="section-title"><i class="fas fa-credit-card"></i>Card Payment Orders</h3>
            <?php
            // Check if payment_type column exists
            $checkColumn = mysqli_query($conn, "SHOW COLUMNS FROM sales LIKE 'payment_type'");
            $columnExists = mysqli_num_rows($checkColumn) > 0;

            if ($columnExists) {
                $sql = "SELECT s.*, i.name, i.img FROM sales s 
                        JOIN items i ON s.items_id = i.items_id 
                        WHERE s.users_id = $_SESSION[users_id] 
                        AND s.payment_type = 'card'
                        ORDER BY s.date DESC";
            } else {
                // If payment_type column doesn't exist, show all orders
                $sql = "SELECT s.*, i.name, i.img FROM sales s 
                        JOIN items i ON s.items_id = i.items_id 
                        WHERE s.users_id = $_SESSION[users_id] 
                        ORDER BY s.date DESC";
            }
            $result = mysqli_query($conn, $sql);
            $cardOrdersCount = mysqli_num_rows($result);

            if($cardOrdersCount > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="order-card">
                        <div class="order-id">
                            <i class="fas fa-credit-card"></i>
                            <?php if ($columnExists): ?>
                            <span class="payment-badge card">Card Payment</span>
                            <?php endif; ?>
                            <br>Order #<?php echo $row['sales_id']; ?>
                        </div>
                        <div class="order-name">
                            <a href="item_individual.php?items_id=<?php echo $row['items_id']; ?>">
                                <?php echo $row['name']; ?>
                            </a>
                        </div>
                        <div class="order-date">
                            <i class="far fa-calendar"></i>
                            <?php echo date('d M Y', strtotime($row['date'])); ?>
                        </div>
                        <div class="order-total">
                            <i class="fas fa-rupee-sign"></i>
                            <?php echo number_format($row['total'], 2); ?>
                        </div>
                        <form method="get" action="review.php" class="review-form">
                            <input type="hidden" name="sales_id" value="<?php echo $row['sales_id']; ?>">
                            <input type="text" name="review" class="review-input" placeholder="Write your review...">
                            <button type="submit" class="review-btn">
                                <i class="fas fa-star"></i> Review
                            </button>
                        </form>
                    </div>
                    <?php
                }
            } else {
                echo "<p class='text-center' style='padding: 20px;'>No card payment orders yet</p>";
            }

            // Then display COD Orders
            ?>
            <h3 class="section-title" style="margin-top: 30px;"><i class="fas fa-truck"></i>Cash on Delivery Orders</h3>
            <?php
            if ($columnExists) {
                $sql = "SELECT s.*, i.name, i.img FROM sales s 
                        JOIN items i ON s.items_id = i.items_id 
                        WHERE s.users_id = $_SESSION[users_id] 
                        AND s.payment_type = 'cod'
                        ORDER BY s.date DESC";
            } else {
                // If payment_type column doesn't exist, show no orders
                $sql = "SELECT s.*, i.name, i.img FROM sales s 
                        JOIN items i ON s.items_id = i.items_id 
                        WHERE s.users_id = $_SESSION[users_id] 
                        AND 1=0"; // This will return no results
            }
            $result = mysqli_query($conn, $sql);
            $codOrdersCount = mysqli_num_rows($result);

            if($codOrdersCount > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="order-card cod-order">
                        <div class="order-id">
                            <i class="fas fa-truck"></i>
                            <span class="payment-badge cod">Cash on Delivery</span>
                            <br>Order #<?php echo $row['sales_id']; ?>
                        </div>
                        <div class="order-name">
                            <a href="item_individual.php?items_id=<?php echo $row['items_id']; ?>">
                                <?php echo $row['name']; ?>
                            </a>
                        </div>
                        <div class="order-date">
                            <i class="far fa-calendar"></i>
                            <?php echo date('d M Y', strtotime($row['date'])); ?>
                        </div>
                        <div class="order-total">
                            <i class="fas fa-rupee-sign"></i>
                            <?php echo number_format($row['total'], 2); ?>
                        </div>
                        <form method="get" action="review.php" class="review-form">
                            <input type="hidden" name="sales_id" value="<?php echo $row['sales_id']; ?>">
                            <input type="text" name="review" class="review-input" placeholder="Write your review...">
                            <button type="submit" class="review-btn">
                                <i class="fas fa-star"></i> Review
                            </button>
                        </form>
                    </div>
                    <?php
                }
            } else {
                echo "<p class='text-center' style='padding: 20px;'>No cash on delivery orders yet</p>";
            }

            if($cardOrdersCount == 0 && $codOrdersCount == 0) {
                ?>
                <div class="empty-orders">
                    <i class="fas fa-shopping-basket"></i>
                    <h3>No orders yet</h3>
                    <p>Your ordered items will appear here</p>
                </div>
                <?php
            }
            ?>
        </div>

        <?php
        if(isset($_SESSION['tmp'])) {
            echo '<div class="alert">' . $_SESSION['tmp'] . '</div>';
            unset($_SESSION['tmp']);
        }
        ?>
    </div>
</body>
</html>