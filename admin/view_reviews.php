<?php
session_start();
if(!isset($_SESSION['admin_id'])) {
    header('Location: verify.php');
    exit;
}

$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "alb";

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

if (mysqli_connect_error()) {
    die('Connect error('. mysqli_connect_error().')'. mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reviews - Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f7;
        }

        .header {
            background-color: #1a472a;
            padding: 20px;
            color: white;
            text-align: center;
        }

        .header h1 {
            margin: 0;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
        }

        .reviews-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .review-card {
            padding: 20px;
            border-bottom: 1px solid #eee;
            display: grid;
            grid-template-columns: auto 1fr auto;
            gap: 20px;
            align-items: center;
        }

        .review-card:last-child {
            border-bottom: none;
        }

        .user-info {
            font-weight: 500;
            color: #1a472a;
        }

        .review-text {
            color: #333;
            line-height: 1.6;
        }

        .review-date {
            color: #666;
            font-size: 0.9em;
        }

        .nav-links {
            margin-bottom: 20px;
        }

        .nav-links a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #1a472a;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 10px;
            transition: background-color 0.3s;
        }

        .nav-links a:hover {
            background-color: #2c5d3f;
        }

        .empty-reviews {
            padding: 40px;
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Customer Reviews</h1>
    </div>

    <div class="container">
        <div class="nav-links">
            <a href="admin_home.php"><i class="fas fa-home"></i> Home</a>
            <a href="view_item.php"><i class="fas fa-box"></i> View Items</a>
            <a href="view_user.php"><i class="fas fa-users"></i> View Users</a>
        </div>

        <div class="reviews-container">
            <?php
            $sql = "SELECT r.*, u.name as user_name, i.name as item_name 
                    FROM reviews r 
                    JOIN sales s ON r.sales_id = s.sales_id 
                    JOIN users u ON r.users_id = u.users_id 
                    JOIN items i ON s.items_id = i.items_id 
                    ORDER BY r.created_at DESC";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='review-card'>";
                    echo "<div class='user-info'>";
                    echo "<i class='fas fa-user'></i> ".$row['user_name']."<br>";
                    echo "<small>Product: ".$row['item_name']."</small>";
                    echo "</div>";
                    echo "<div class='review-text'>".$row['review']."</div>";
                    echo "<div class='review-date'>";
                    echo "<i class='far fa-clock'></i> ";
                    echo date('d M Y', strtotime($row['created_at']));
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<div class='empty-reviews'>";
                echo "<i class='far fa-comment-dots' style='font-size: 3em; color: #ccc; margin-bottom: 20px;'></i>";
                echo "<h3>No reviews yet</h3>";
                echo "<p>Customer reviews will appear here</p>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
</body>
</html>