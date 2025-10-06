<?php
    session_start();
    if(!isset($_SESSION['usr']))
    {
        header('Location:verify.php');
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $_SESSION['usr']; ?> | Manage Stock</title>
    <style>
        body {
            background-image: url('../css/image/img5.jpeg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
        a.a2 {
            text-decoration: underline;
            color: burlywood;
            text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;
            font-size: 75px;
        }
        .container {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            font-size: 18px;
        }
        input[type=number] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }
        .btn-update {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn-update:hover {
            background-color: #45a049;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #4CAF50;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <center><h1><a class="a2" href="../index.php">E-FARM ADMIN</a></h1></center>

    <div class="container">
        <?php
            $host = "localhost";
            $dbusername = "root";
            $dbpassword = "";
            $dbname = "alb";

            $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

            if (mysqli_connect_error()) {
                die('Connect error('. mysqli_connect_error().')'. mysqli_connect_error());
            }

            if(isset($_GET['items_id'])) {
                $items_id = $_GET['items_id'];
                
                // Get current item details
                $sql = "SELECT name, stock FROM items WHERE items_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $items_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $item = $result->fetch_assoc();

                if($item) {
                    echo "<h2>Manage Stock for: " . htmlspecialchars($item['name']) . "</h2>";
                    echo "<p>Current Stock: " . htmlspecialchars($item['stock']) . "</p>";

                    // Handle form submission
                    if(isset($_POST['update_stock'])) {
                        $new_stock = $_POST['new_stock'];
                        
                        // Add new stock to existing stock
                        $update_sql = "UPDATE items SET stock = stock + ? WHERE items_id = ?";
                        $update_stmt = $conn->prepare($update_sql);
                        $update_stmt->bind_param("ii", $new_stock, $items_id);
                        
                        if($update_stmt->execute()) {
                            // Get updated stock value
                            $get_updated_sql = "SELECT stock FROM items WHERE items_id = ?";
                            $get_updated_stmt = $conn->prepare($get_updated_sql);
                            $get_updated_stmt->bind_param("i", $items_id);
                            $get_updated_stmt->execute();
                            $updated_result = $get_updated_stmt->get_result();
                            $updated_item = $updated_result->fetch_assoc();
                            
                            echo "<p style='color: green;'>Stock updated successfully! Added " . htmlspecialchars($new_stock) . " items.</p>";
                            echo "<p style='color: green;'>New total stock: " . htmlspecialchars($updated_item['stock']) . "</p>";
                            // Update displayed current stock
                            $item['stock'] = $updated_item['stock'];
                        } else {
                            echo "<p style='color: red;'>Error updating stock!</p>";
                        }
                    }

                    // Display update form
                    echo "<form method='post'>";
                    echo "<div class='form-group'>";
                    echo "<label for='new_stock'>Add Stock Quantity:</label>";
                    echo "<input type='number' id='new_stock' name='new_stock' min='1' value='1' required>";
                    echo "<p><small>This quantity will be added to the current stock.</small></p>";

                    echo "</div>";
                    echo "<button type='submit' name='update_stock' class='btn-update'>Update Stock</button>";
                    echo "</form>";
                } else {
                    echo "<p>Item not found!</p>";
                }
            } else {
                echo "<p>No item specified!</p>";
            }
        ?>
        <a href="view_item.php" class="back-link">← Back to Items</a>
    </div>
</body>
</html>