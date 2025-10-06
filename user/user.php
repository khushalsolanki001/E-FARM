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
<html>
<head>
    <title><?php echo $_SESSION['user'] ?> | Account </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f0f4f8; /* Light background */
            font-family: 'Arial', sans-serif;
            color: #333; /* Darker text color */
        }
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9); /* More opaque background */
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }
        h1 {
            text-align: center;
            color: #4caf50; /* Green color */
            margin-bottom: 20px;
            font-size: 2.5em; /* Larger font size */
        }
        .topnav {
            background-color: #4caf50; /* Green color */
            overflow: hidden;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .topnav a {
            float: left;
            color: #ffffff; /* White text */
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 18px; /* Slightly larger font size */
            transition: background-color 0.3s;
        }
        .topnav a:hover {
            background-color: #388e3c; /* Darker green color */
            color: white;
        }
        .topnav-right {
            float: right;
        }
        .user-identity {
            font-size: 1.5em; /* Increased font size */
            font-weight: bold;
            color: #d32f2f; /* Dark red color */
            text-align: center;
            margin: 20px 0;
        }
        .a4, .a6 {
            width: 30%; /* Increased width */
            padding: 12px 20px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 18px;
        }
        .a5, .a7 {
            background-color: #4caf50; /* Green */
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 20px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .a5:hover, .a7:hover {
            background-color: #388e3c; /* Darker green */
        }
        table {
            width: 100%;
            text-align: center;
            border-spacing: 1em .9em;
            margin-top: 20px;
        }
        th {
            color: #4caf50; /* Green color */
            font-size: 28px;
        }
        td {
            font-size: 25px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>
<body>

<div class="container">
    <center><h1><a class="a2" href="../index.php">E-FARM</a></h1></center>

    <div class="topnav">
        <a class="a3" href="user_home.php">Home</a>
        <a class="a3" href="view_wishlist.php">WishList</a>  
        <a class="a3" href="item.php">All items</a>
       
        <a class="a3" href="user_order.php">My Orders</a>
        <div class="topnav-right">
            <a class="a3" href="user.php">My Account</a>
            <a class="a3" href="u_logout.php">Log Out</a>
          
        </div>
    </div>

    <div class="user-identity">
        <form method="post" action="">
            <label>User ID:</label>
            <input type="number" class="a6" name="users_id" autofocus required readonly value="<?php echo $_SESSION['users_id']; ?>">
        </form>
    </div>

    <table>
        <?php
        $host="localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "alb";

        $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

        if (mysqli_connect_error()) {
            die('Connect error('. mysqli_connect_error().')'. mysqli_connect_error());
        }
        $txt1 = $_SESSION['users_id'];
        $sql = "SELECT * from users where users_id='$txt1'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<th>First Name</th><td>".$row['firstname']."</td></tr>";
                echo "<tr><th>Last Name</th><td>".$row['lastname']."</td></tr>";
                echo "<tr><th>Email</th><td>".$row['email']."</td></tr>";
                echo "<tr><th>Mobile</th><td>".$row['mobile']."</td></tr>";
                echo "<tr><th>Address</th><td>".$row['adr']."</td></tr>";
            }
        }
        ?>
    </table>     

    <div style="text-align: center; margin-top: 20px;">
        <a href="account_address.php"><button class="a7">ADD ADDRESS</button></a>
        <a href="account_edit.php"><button class="a7">UPDATE</button></a>
        <a href="account_delete.php"><button class="a7">DELETE</button></a>
    </div>

    <div class="footer">
        <p>&copy; 2025 E-FARM. All rights reserved.</p>
    </div>
</div>

</body>
</html>
