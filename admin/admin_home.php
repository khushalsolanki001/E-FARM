<?php
    session_start();
    if(!isset($_SESSION['usr']))
    {

        if($_POST['CODE']=='Admin123')
        {
          $_SESSION['usr']='ADMIN';
        }
        else
        {
          $_SESSION['tmp']="Invalid Code!";
          header('Location: verify.php');
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $_SESSION['usr']; ?> | Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #ffffff 0%, #e5ffe5 100%);
            min-height: 100vh;
        }

        .dashboard-header {
            background: linear-gradient(135deg, #00875A 0%, #006c47 100%);
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .dashboard-title {
            color: white;
            font-size: 2.5em;
            font-weight: 600;
            text-decoration: none;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }

        .dashboard-title:hover {
            transform: scale(1.02);
        }

        .search-container {
            background: white;
            padding: 20px;
            border-radius: 15px;
            margin: 20px auto;
            max-width: 800px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .search-input {
            width: 70%;
            padding: 15px;
            border: 2px solid #e1e1e1;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            border-color: #00875A;
            outline: none;
            box-shadow: 0 0 0 4px rgba(0, 135, 90, 0.1);
        }

        .search-button {
            padding: 15px 30px;
            background: #00875A;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .search-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 135, 90, 0.4);
        }

        .navigation {
            background: white;
            padding: 15px;
            margin: 20px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .nav-link {
            display: inline-block;
            padding: 12px 25px;
            color: #4a5568;
            text-decoration: none;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background: linear-gradient(135deg, #00875A 0%, #006c47 100%);
            color: white;
            transform: translateY(-2px);
        }

        .orders-container {
            background: white;
            margin: 20px;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .orders-title {
            color: #2d3748;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e2e8f0;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .orders-table th {
            background: linear-gradient(135deg, #00875A 0%, #006c47 100%);
            color: white;
            padding: 15px;
            font-weight: 500;
        }

        .orders-table td {
            padding: 15px;
            border-bottom: 1px solid #e2e8f0;
            color: #4a5568;
        }

        .orders-table tr:hover {
            background-color: #f7fafc;
        }

        .orders-table a {
            color: #00875A;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .orders-table a:hover {
            color: #006c47;
            text-decoration: underline;
        }

        .review-text {
            max-width: 300px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 6px;
            font-size: 0.9em;
            line-height: 1.4;
            color: #4a5568;
            margin: 5px 0;
        }

        .no-review {
            color: #a0aec0;
            font-style: italic;
        }

        @media (max-width: 768px) {
            .search-input {
                width: 100%;
                margin-bottom: 10px;
            }
            
            .search-button {
                width: 100%;
            }

            .navigation {
                overflow-x: auto;
                white-space: nowrap;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-header">
        <a href="../index.php" class="dashboard-title">E-FARM ADMIN</a>
    </div>

    <div class="search-container">
        <form method="post" action="search.php">
            <input type="text" name="search" class="search-input" placeholder="Enter the product name here..." autofocus>
            <button type="submit" name="submit" class="search-button">Search</button>
        </form>
    </div>

    <?php
        if(isset($_SESSION['temp']))
        {
          echo '<div class="error">'.$_SESSION['temp'].'</div>';
          unset($_SESSION['temp']);
        }
    ?>
    

    <div class="navigation">
    <a class="nav-link" href="admin_home.php">Home</a>
    <a class="nav-link" href="insert_item.php">Add Item</a></li>
    <a class="nav-link" href="insert_user.php">Add User</a>
    
    <div style="float: right;">
    <a class="nav-link" href="view_item.php">Manage Products</a>
    <a class="nav-link" href="view_user.php">Manage Users</a>
    <a class="nav-link" href="a_logout.php">Log Out</a>

    </div>
    </div>

    <div class="orders-container">
        <?php
            // Database connection
            $host = "localhost";
            $dbusername = "root";
            $dbpassword = "";
            $dbname = "alb";

            // Create connection
            $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Get total number of users who have bought products
            $total_query = "SELECT COUNT(DISTINCT users_id) as total_buyers, 
                            SUM(qty) as total_products_sold 
                            FROM sales";
            $total_result = mysqli_query($conn, $total_query);
            
            if (!$total_result) {
                echo "Error: " . mysqli_error($conn);
            } else {
                $total_row = mysqli_fetch_assoc($total_result);
                echo "<div style='background-color: #f5f5f5; padding: 20px; border-radius: 8px; margin-bottom: 20px;'>";
                echo "<h3 style='color: #1a472a; margin: 0;'>Total Users Who Bought Products: " . $total_row['total_buyers'] . "</h3>";
                echo "<h3 style='color: #1a472a; margin: 10px 0 0 0;'>Total Products Sold: " . $total_row['total_products_sold'] . "</h3>";
                echo "</div>";
            }
        ?>

        <h2 class="orders-title">CASH ON DELIVERY ORDERS</h2>
        <table class="orders-table">

		<tr>
			<th>User name</th>
			<th>Item name</th>
			<th>Quantity</th>
			<th>Total</th>
			<th>Date</th>
			<th>Review</th>
		</tr>
        <?php
        $cod_sql = "SELECT s.*, 
                CONCAT(u.firstname, ' ', u.lastname) as user_name,
                i.name as item_name,
                COALESCE(r.review, 'No review yet') as review_text
                FROM sales s
                INNER JOIN users u ON s.users_id = u.users_id
                INNER JOIN items i ON s.items_id = i.items_id
                LEFT JOIN reviews r ON s.sales_id = r.sales_id
                WHERE s.payment_type = 'cod'
                ORDER BY s.date DESC";
        $cod_result = mysqli_query($conn, $cod_sql);
        if (!$cod_result) {
            echo "Error in query: " . mysqli_error($conn);
        } else {
            $cod_resultCheck = mysqli_num_rows($cod_result);
            if($cod_resultCheck > 0){
                while ($row = mysqli_fetch_assoc($cod_result)) {
                    echo "<tr>";
                    echo "<td><a href=user_individual.php?users_id=".$row['users_id']. ">". $row['user_name'] ."</a></td>";
                    echo "<td><a href=item_individual.php?items_id=".$row['items_id']. ">". $row['item_name'] ."</a></td>";
                    echo "<td>".$row['qty'] ."</td>";
                    echo "<td>₹".$row['total'] ."</td>";
                    echo "<td>".$row['date'] ."</td>";
                    echo "<td>" . 
                         ($row['review_text'] == 'No review yet' ? 
                         "<span class='no-review'>".$row['review_text']."</span>" : 
                         "<div class='review-text'>".$row['review_text']."</div>") . 
                         "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7' style='text-align:center'>No cash on delivery orders found</td></tr>";
            }
        }
        ?>
        </table>

        <h2 class="orders-title" style="margin-top:30px;">CARD PAYMENT ORDERS</h2>
        <table class="orders-table">

		<tr>
			<th>User name</th>
			<th>Item name</th>
			<th>Quantity</th>
			<th>Total</th>
			<th>Date</th>
			<th>Review</th>
		</tr>
        <?php
        $card_sql = "SELECT s.*, 
                CONCAT(u.firstname, ' ', u.lastname) as user_name,
                i.name as item_name,
                COALESCE(r.review, 'No review yet') as review_text
                FROM sales s
                INNER JOIN users u ON s.users_id = u.users_id
                INNER JOIN items i ON s.items_id = i.items_id
                LEFT JOIN reviews r ON s.sales_id = r.sales_id
                WHERE s.payment_type = 'card'
                ORDER BY s.date DESC";
        $card_result = mysqli_query($conn, $card_sql);
        if (!$card_result) {
            echo "Error in query: " . mysqli_error($conn);
        } else {
            $card_resultCheck = mysqli_num_rows($card_result);
            if($card_resultCheck > 0){
                while ($row = mysqli_fetch_assoc($card_result)) {
                    echo "<tr>";
                    echo "<td><a href=user_individual.php?users_id=".$row['users_id']. ">". $row['user_name'] ."</a></td>";
                    echo "<td><a href=item_individual.php?items_id=".$row['items_id']. ">". $row['item_name'] ."</a></td>";
                    echo "<td>".$row['qty'] ."</td>";
                    echo "<td>₹".$row['total'] ."</td>";
                    echo "<td>".$row['date'] ."</td>";
                    echo "<td>" . 
                         ($row['review_text'] == 'No review yet' ? 
                         "<span class='no-review'>".$row['review_text']."</span>" : 
                         "<div class='review-text'>".$row['review_text']."</div>") . 
                         "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7' style='text-align:center'>No card payment orders found</td></tr>";
            }
        }
        ?>
        </table>

       
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.confirm-btn').click(function() {
            var salesId = $(this).data('id');
            $.ajax({
                url: 'confirm_order.php',
                type: 'POST',
                data: {sales_id: salesId},
                success: function(response) {
                    $('#status-' + salesId).html('Order Confirmed!');
                    $(this).prop('disabled', true);
                }
            });
        });
    });
    </script>
</body>
</html>
