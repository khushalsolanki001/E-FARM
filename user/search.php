<!DOCTYPE html>
<html>
<head>
    <title>Search | E-FARM</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
        }

        .header {
            background-color: #fff;
            padding: 20px 50px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: center;
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

        .topnav {
            background-color: #1a472a;
            padding: 15px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topnav a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .topnav a:hover {
            background-color: #4CAF50;
        }

        .search-container {
            padding: 40px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin: 30px auto;
            max-width: 800px;
        }

        .search-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
        }

        .search-bar input[type="text"] {
            flex: 1;
            padding: 15px 25px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            color: #333;
        }

        .search-bar input[type="text"]:focus {
            border-color: #4CAF50;
            outline: none;
            box-shadow: 0 0 15px rgba(76, 175, 80, 0.3);
        }

        .search-bar input[type="submit"] {
            background: linear-gradient(135deg, #2E7D32 0%, #1B5E20 100%);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.4s ease;
            text-transform: uppercase;
            letter-spacing: 2px;
            box-shadow: 0 4px 15px rgba(46, 125, 50, 0.2);
            position: relative;
            overflow: hidden;
        }

        .search-bar input[type="submit"]:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(46, 125, 50, 0.4);
            background: linear-gradient(135deg, #1B5E20 0%, #2E7D32 100%);
        }

        .search-bar input[type="submit"]:active {
            transform: translateY(1px);
            box-shadow: 0 2px 10px rgba(46, 125, 50, 0.3);
        }

        .result-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
        }

        .result-table th {
            background-color: #1a472a;
            color: white;
            padding: 15px;
            text-align: left;
            font-size: 16px;
        }

        .result-table td {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 15px;
        }

        .result-table img {
            border-radius: 8px;
            object-fit: cover;
        }

        .not-found {
            text-align: center;
            color: #ff5252;
            font-size: 24px;
            padding: 40px;
            background-color: white;
            border-radius: 10px;
            margin: 30px auto;
            max-width: 600px;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="../index.php" class="logo">E-<span>FARM</span></a>
    </div>

    <div class="topnav">
        <div class="nav-left">
            <a href="user_home.php"><i class="fas fa-home"></i> Home</a>
            <a href="view_wishlist.php"><i class="fas fa-heart"></i>Cart</a>
            <a href="item.php"><i class="fas fa-shopping-basket"></i> All Items</a>
            <a href="user_order.php"><i class="fas fa-shopping-cart"></i> My Orders</a>
        </div>
        <div class="nav-right">
            <a href="user.php"><i class="fas fa-user"></i> My Account</a>
            <a href="u_logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a>
        </div>
    </div>

    <div class="search-container">
        <form method="post" action="search.php" class="search-bar">
            <input type="text" name="search" placeholder="Search for products...">
            <input type="submit" name="submit" value="Search">
        </form>

        <?php
        $con = new PDO("mysql:host=localhost;dbname=alb",'root','');
        if (isset($_POST["submit"])) {
            $str = $_POST["search"];
            $allowed = array('FERTILIZER','HERBICIDE','INSECTICIDES','PESTICIDES','SPRAYER','OTHER');
            $placeholders = implode(",", array_fill(0, count($allowed), "?"));
            $sql = "SELECT * FROM `items` WHERE name like ? AND types IN (".$placeholders.")";
            $sth = $con->prepare($sql);
            $params = array_merge(array('%'.$str.'%'), $allowed);
            $sth->setFetchMode(PDO:: FETCH_OBJ);
            $sth->execute($params);
            if($row = $sth->fetch()) {
                ?>
                <table class="result-table">
                    <tr><th>ITEM ID</th><td><?php echo $row->items_id; $items_id=$row->items_id;?></td></tr>
                    <tr><th>NAME</th><td><?php echo $row->name; ?></td></tr>
                    <tr><th>BRAND</th><td><?php echo $row->brand; ?></td></tr>
                    <tr><th>DESCRIPTION</th><td><?php echo $row->description;?></td></tr>
                    <tr><th>TYPES</th><td><?php echo $row->types;?></td></tr>
                    <tr><th>PRICE</th><td>₹<?php echo $row->price;?></td></tr>
                    <tr><th>STOCK</th><td><?php echo $row->stock;?></td></tr>
                    <tr><th>IMAGE</th><td><?php 
                        $pathx = "../admin/image/";
                        $file = $row->img;
                        echo '<img src="'.$pathx.$file.'" height="150" width="150">';
                    ?></td></tr>
                    <?php
                    $host="localhost";
                    $dbusername = "root";
                    $dbpassword = "";
                    $dbname = "alb";

                    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
                    $sql1 = "SELECT * from sales where items_id='$items_id'";
                    $result1=mysqli_query($conn, $sql1);
                    $resultCheck1 = mysqli_num_rows($result1);
                    if($resultCheck1 > 0){
                        while ($row = mysqli_fetch_assoc($result1)) {
                            echo "<tr><th>REVIEW</th><td>".$row['review']."</td></tr>";
                        }
                    }
                    ?>
                </table>
                <?php
            } else {
                echo '<div class="not-found"><i class="fas fa-exclamation-circle"></i> Product Not Found!</div>';
            }
        }
        ?>
    </div>
</body>
</html>
