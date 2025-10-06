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
    <title><?php echo $_SESSION['user'] ?> | Delete Account</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f0f4f8; /* Light background */
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
            color: crimson;
            font-weight: bold;
        }
        .submit-button {
            background-color: #d32f2f; /* Red for delete */
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
            background-color: #b71c1c; /* Darker red */
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
            text-align: center;
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
        <form method="post" action="delete_connection.php">
            <label>User ID:</label>
            <input type="number" class="input-field" name="users_id" autofocus required readonly value="<?php echo $_SESSION['users_id']; ?>">
            <br>
            <p>Once you delete, you can't see your previous orders or your wishlist. Are you sure you want to delete your account?</p>
            <input type="submit" class="submit-button" value="DELETE ME">
        </form>
    </div>

    <a href="user.php"><button class="back-button">BACK</button></a>
</div>

</body>
</html>
