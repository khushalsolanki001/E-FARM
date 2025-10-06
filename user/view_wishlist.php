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
    <title><?php echo "Wishlist | "; echo $_SESSION['user']; $u=$_SESSION['users_id'];?></title>
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
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header */
        .header {
            background: white;
            padding: 20px 0;
            box-shadow: var(--shadow);
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo a {
            text-decoration: none;
            color: var(--dark-color);
            font-size: 2.5rem;
            font-weight: 700;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Search Bar */
        .search-bar {
            max-width: 600px;
            margin: 20px auto;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #eee;
            border-radius: 30px;
            font-size: 1rem;
            transition: var(--transition);
        }

        .search-input:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 10px rgba(46, 204, 113, 0.1);
        }

        .search-button {
            position: absolute;
            right: 5px;
            top: 5px;
            background: var(--gradient);
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            color: white;
            cursor: pointer;
            transition: var(--transition);
        }

        .search-button:hover {
            transform: translateY(-2px);
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

        /* Wishlist Grid */
        .wishlist-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            padding: 30px 0;
        }

        .wishlist-item {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .wishlist-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .item-image {
            position: relative;
            padding-top: 75%;
            overflow: hidden;
        }

        .item-image img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .wishlist-item:hover .item-image img {
            transform: scale(1.05);
        }

        .item-details {
            padding: 20px;
        }

        .item-name {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--dark-color);
        }

        .item-brand {
            color: var(--primary-color);
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .item-price {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--dark-color);
            margin: 15px 0;
        }

        .item-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-align: center;
            text-decoration: none;
        }

        .btn-view {
            background: #f8f9fa;
            color: var(--dark-color);
            border: 2px solid #dee2e6;
        }

        .btn-remove {
            background: #ff4757;
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .msg {
            text-align: center;
            color: #ff4757;
            font-size: 1.1rem;
            margin: 20px 0;
            padding: 10px;
            background: rgba(255, 71, 87, 0.1);
            border-radius: 10px;
        }

        @media (max-width: 768px) {
            .nav-container {
                flex-direction: column;
            }

            .wishlist-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
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

            <form method="post" action="search.php" class="search-bar">
                <input type="text" name="search" class="search-input" placeholder="Search items...">
                <button type="submit" name="submit" class="search-button">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="container">
        <div class="nav">
            <div class="nav-container">
                <div class="nav-left">
                    <a href="user_home.php"><i class="fas fa-home"></i> Home</a>
                    <a href="view_wishlist.php"><i class="fas fa-heart"></i> cart</a>
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
        if(isset($_SESSION['tmp'])) {
            echo '<div class="msg">' . $_SESSION['tmp'] . '</div>';
            unset($_SESSION['tmp']);
        }
        ?>

        <div class="wishlist-grid">
            <?php
            if(($_SERVER["REQUEST_METHOD"] == "GET")) {
                $host = "localhost";
                $dbusername = "root";
                $dbpassword = "";
                $dbname = "alb";

                $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

                if (mysqli_connect_error()) {
                    die('Connect error('. mysqli_connect_error().')'. mysqli_connect_error());
                }

                $sql = "SELECT w.*, i.* FROM wishlist w 
                        JOIN items i ON w.items_id = i.items_id 
                        WHERE w.users_id = $u";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);

                if($resultCheck > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $pathx = "../admin/image/";
                        $file = $row["img"];
                        ?>
                        <div class="wishlist-item">
                            <div class="item-image">
                                <img src="<?php echo $pathx.$file; ?>" alt="<?php echo $row['name']; ?>">
                            </div>
                            <div class="item-details">
                                <h3 class="item-name"><?php echo $row['name']; ?></h3>
                                <div class="item-brand"><?php echo $row['brand']; ?></div>
                                <div class="item-price">₹<?php echo $row['price']; ?></div>
                                <div class="item-actions">
                                    <a href="item_individual.php?items_id=<?php echo $row['items_id']; ?>" class="btn btn-view">
                                        View Details
                                    </a>
                                    <a href="wishlist_delete.php?items_id=<?php echo $row['items_id']; ?>" class="btn btn-remove">
                                        Remove
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo '<div class="msg">Your wishlist is empty</div>';
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
