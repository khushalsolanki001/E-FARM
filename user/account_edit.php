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
    <title><?php echo $_SESSION['user'] ?> | Edit Account</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #e8f5e9; /* Light green background */
            font-family: 'Arial', sans-serif;
            color: #333; /* Darker text color */
        }
        .container {
            max-width: 800px;
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
        .input-field {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 18px;
        }
        .submit-button {
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
            width: 100%;
        }
        .submit-button:hover {
            background-color: #388e3c; /* Darker green */
        }
        .back-button {
            background-color: darkgrey;
            color: darkred;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 20px;
            font-weight: bold;
            width: 100%;
        }
        .back-button:hover {
            background-color: #a9a9a9; /* Darker grey */
        }
        table {
            width: 100%;
            text-align: left;
            margin-top: 20px;
        }
        th {
            color: dodgerblue;
            font-size: 28px;
        }
        td {
            font-size: 25px;
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
            <input type="number" class="input-field" name="users_id" autofocus required readonly value="<?php echo $_SESSION['users_id']; ?>">
        </form>
    </div>

    <table>
        <form method="post" action="edit_connection.php">
            <?php
            $host="localhost";
            $dbusername = "root";
            $dbpassword = "";
            $dbname = "alb";

            $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

            if (mysqli_connect_error()) {
                die('Connect error('. mysqli_connect_error().')'. mysqli_connect_error());
            }

            $u = $_SESSION['users_id'];
            $sql1 = "SELECT * from users where users_id='$u'";
            $result1 = mysqli_query($conn, $sql1);
            $resultCheck1 = mysqli_num_rows($result1);
            if ($resultCheck1 > 0) {
                while ($row = mysqli_fetch_assoc($result1)) {
                    $u1 = $row['firstname'];
                    $u2 = $row['lastname'];
                    $u3 = $row['mobile'];
                    $u4 = $row['password'];
                }
            }
            ?>
            <tr><th>User ID:</th><td>
                <input type="number" name="users_id" class="input-field" required readonly value="<?php echo $_SESSION['users_id']; ?>"></td></tr>
            <tr><th>First Name:</th><td>
                <input type="text" name="firstname" class="input-field" value="<?php echo $u1; ?>" required pattern="[A-Za-z_]+" title="No Numbers and Spaces (Use _)"></td></tr>
            <tr><th>Last Name:</th><td>
                <input type="text" name="lastname" class="input-field" value="<?php echo $u2; ?>" required pattern="[A-Za-z_]+" title="No Numbers and Spaces (Use _)"></td></tr>
            <tr><th>Mobile:</th><td>
                <input type="text" name="mobile" class="input-field" value="<?php echo $u3; ?>" required minlength="10" maxlength="10" pattern="[0-9]+"></td></tr>
            <tr><th>Password:</th><td>
                <input type="password" name="password" class="input-field" value="<?php echo $u4; ?>" required minlength="6" pattern="[^' ']+" title="No Spaces"></td></tr>
        </table>
        <br>
        <input type="submit" class="submit-button" value="UPDATE">
    </form>

    <a href="user.php"><button class="back-button">BACK</button></a>
</div>

</body>
</html>
