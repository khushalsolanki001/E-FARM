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
    <title><?php echo $_GET['choice'].' | '.$_SESSION['user'] ?></title>
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
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        /* Header Styles */
        .header {
            background: rgba(255, 255, 255, 0.95);
            padding: 20px 0;
            margin-bottom: 30px;
            box-shadow: var(--shadow);
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo a {
            text-decoration: none;
            color: var(--dark-color);
            font-size: 3.5rem;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            position: relative;
            display: inline-block;
        }

        /* Search Bar */
        .search-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 0 20px;
        }

        .search-container form {
            display: flex;
            gap: 10px;
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

        /* Products Table */
        .products-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 30px;
            margin: 30px 0;
            box-shadow: var(--shadow);
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .products-table th {
            background: var(--gradient);
            color: white;
            padding: 15px;
            text-align: left;
            font-size: 1.1rem;
        }

        .products-table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }

        .products-table tr:hover {
            background: rgba(46, 204, 113, 0.05);
        }

        .products-table img {
            border-radius: 10px;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .products-table img:hover {
            transform: scale(1.1);
        }

        .view-btn {
            background: var(--gradient);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-block;
        }

        .view-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
        }

        /* Category Links */
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .category-link {
            background: white;
            padding: 15px 25px;
            border-radius: 15px;
            text-decoration: none;
            color: var(--dark-color);
            font-weight: 500;
            text-align: center;
            transition: var(--transition);
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .category-link:hover {
            transform: translateY(-3px);
            background: var(--gradient);
            color: white;
        }

        .category-link i {
            font-size: 1.2rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .nav-container {
                flex-direction: column;
            }

            .products-table {
                display: block;
                overflow-x: auto;
            }

            .search-container form {
                flex-direction: column;
            }

            .search-container input[type="text"],
            .search-container input[type="submit"] {
                width: 100%;
                border-radius: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <a href="../index.php">E-FARM</a>
            </div>
            <div class="search-container">
                <form method="post" action="search.php">
                    <input type="text" name="search" placeholder="Search for products...">
                    <input type="submit" name="submit" value="Search">
                </form>
            </div>
        </div>

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

        <div class="products-container">
            <table class="products-table">
                <?php
                if(($_SERVER["REQUEST_METHOD"] == "GET"))
                {
                    include '../connection.php';
                    $allowedCategories = array('FERTILIZER','HERBICIDE','INSECTICIDES','PESTICIDES','SPRAYER','OTHER');
                    $txt = isset($_GET['choice']) ? $_GET['choice'] : '';
                    if ($txt !== '' && in_array($txt, $allowedCategories)) {
                        $safeTxt = mysqli_real_escape_string($con, $txt);
                        $sql = "SELECT * from items  where types='$safeTxt'";
                        $result=mysqli_query($con, $sql);
                        $resultCheck = $result ? mysqli_num_rows($result) : 0;
                    } else {
                        $resultCheck = 0;
                        $result = false;
                    }
                    
                    if($resultCheck > 0){
                        echo "<tr>";
                        echo "<th>ITEM_ID</th>";
                        echo "<th>NAME</th>";
                        echo "<th>BRAND</th>";
                        echo "<th>DESCRIPTION</th>";
                        echo "<th>TYPES</th>";
                        echo "<th>PRICE</th>";
                        echo "<th>STOCK</th>";
                        echo "<th>IMAGE</th>";
                        echo "<th>VIEW</th>";
                        echo "</tr>";
                        
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>".$row['items_id'] ."</td>";
                            echo "<td>".$row['name'] ."</td>";
                            echo "<td>".$row['brand'] ."</td>";
                            echo "<td>".$row['description'] ."</td>";
                            echo "<td>".$row['types'] ."</td>";
                            echo "<td>₹".$row['price'] ."</td>";
                            echo "<td>".$row['stock'] ."</td>";
                            $pathx = "../admin/image/";
                            $file = $row["img"];
                            echo "<td>";
                            echo '<img src="'.$pathx.$file.'" height=100 width=100>';
                            echo "</td>";
                            echo "<td><a href=item_individual.php?items_id=".$row['items_id']. " class='view-btn'>View</a></td></tr>";
                        }
                    }
                }
                ?>
            </table>
        </div>

        <div class="categories-grid">
            <a href="view.php?choice=FERTILIZER" class="category-link"><i class="fas fa-seedling"></i> FERTILIZER</a>
            <a href="view.php?choice=HERBICIDE" class="category-link"><i class="fas fa-spray-can"></i> HERBICIDE</a>
            <a href="view.php?choice=INSECTICIDES" class="category-link"><i class="fas fa-bug"></i> INSECTICIDES</a>
            <a href="view.php?choice=PESTICIDES" class="category-link"><i class="fas fa-skull-crossbones"></i> PESTICIDES</a>
            <a href="view.php?choice=SPRAYER" class="category-link"><i class="fas fa-shower"></i> SPRAYER</a>
            <a href="view.php?choice=OTHER" class="category-link"><i class="fas fa-ellipsis-h"></i> OTHER</a>
        </div>
    </div>
</body>
</html>
