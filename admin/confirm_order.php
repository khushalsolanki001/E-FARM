<!DOCTYPE html>
<html>
<head>
    <style>
        .notification {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 15px 25px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            z-index: 1000;
            display: none;
            animation: slideDown 0.5s ease-in-out;
        }

        @keyframes slideDown {
            from { top: -100px; opacity: 0; }
            to { top: 20px; opacity: 1; }
        }
    </style>
</head>
<body>
    <div id="notification" class="notification"></div>

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

    if(isset($_POST['sales_id'])) {
        $sales_id = $_POST['sales_id'];
        
        // Update order status
        $update_sql = "UPDATE sales SET status = 1, order_status = 'Confirmed' WHERE sales_id = ? AND payment_type = 'cod'";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("i", $sales_id);
        
        if($stmt->execute()) {
            echo "<script>
                document.getElementById('notification').textContent = 'Order confirmed successfully!';
                document.getElementById('notification').style.display = 'block';
                setTimeout(function() {
                    document.getElementById('notification').style.display = 'none';
                }, 3000);
            </script>";
        } else {
            echo "<script>
                document.getElementById('notification').textContent = 'Error updating order status';
                document.getElementById('notification').style.backgroundColor = '#f44336';
                document.getElementById('notification').style.display = 'block';
                setTimeout(function() {
                    document.getElementById('notification').style.display = 'none';
                }, 3000);
            </script>";
        }
        
        $stmt->close();
    } else {
        echo "<script>
            document.getElementById('notification').textContent = 'No order ID provided';
            document.getElementById('notification').style.backgroundColor = '#f44336';
            document.getElementById('notification').style.display = 'block';
            setTimeout(function() {
                document.getElementById('notification').style.display = 'none';
            }, 3000);
        </script>";
    }

    $conn->close();
    ?>
</body>
</html>