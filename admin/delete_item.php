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
 <title><?php echo $_SESSION['usr']; ?> | Home</title>
</head>
<body>
    <style>
		body{
			background-image: url('../css/image/img5.jpeg');
			background-repeat: no-repeat;
			background-attachment: fixed;
			background-size: cover;
		}
		a.a2{
    		text-decoration: underline;
 			  color: burlywood;
    		text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;
    		font-size: 75px;
		}
    a.a1{
        text-decoration: none;
        background-color:lavender;
        color:blue;
        font-size:20px;
        padding: 20px 35px;
        border-radius:12px;
        border:2px solid turquoise;
        margin:150px;
        line-height:85px;
        }   
		a.a1:hover {
  			background-color: darkgray;
			  padding: 25px 45px;
		}    
		a.a2:hover {
  			background-color: linen;
			  padding: 25px 45px;
		}    
        .topnav {
            background-color: darkgreen;
            overflow: hidden;
        }

        .topnav a {
            float: left;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }

        .topnav a:hover {
            background-color: #ddd;
            color: black;
        }

        .topnav a.active {
            background-color: #04AA6D;
            color: white;
        }

        .topnav-right {
            float: right;
        }        
        .top {
            color: indigo;
            font-size: 25px;
        }
            
        input[type=text]
        {
          width: 25%;
          padding: 12px 20px;
          margin: 8px 0;
          border: 1px solid #ccc;
          border-radius: 5px;
          box-sizing: border-box;
          font-size: 18px;
        }
        .s2
        {
          width: 25%;
          padding: 12px 20px;
          margin: 8px 0;
          border: 1px solid #ccc;
          border-radius: 5px;
          box-sizing: border-box;
          font-size: 18px;
        }
        .s1
        {
            width: 200px;
            background-color: darkgrey;
            color: darkred;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 20px;
            font-weight:bold;
            margin-right:16px;
        }
        .r1 
        {
          width: 150px;
          background-color: cornsilk;
          color: darkblue;
          padding: 14px 20px;
          margin: 8px 0;
          border: none;
          border-radius: 4px;
          cursor: pointer;
          font-size: 20px;
        }
        table {
        width: 100%;
        text-align: center;
        }
        th{
          color:dodgerblue;
          font-size:28px;
        }
        td{
          font-size:25px;
        }
        .d1{
          font-size:35px;
          color:red;
        }
    </style>

    <center><h1><a class="a2" href="../index.php">E-FARM ADMIN</a></h1></center>

<div class="top">
<!--Search Code-->
<form method="post" action="search.php">
<b>Search Items:</b>
<input type="text" name="search" class="s2" placeholder="Enter the product name here..."autofocus>
<input type="submit" class="r1" name="submit">
</form>
<!--Search End-->

    <div class="topnav">
    <a class="a3" href="admin_home.php">Home</a>
    <a class="a3" href="insert_item.php">Add Item</a></li>
    <a class="a3" href="insert_user.php">Add User</a>

    <div class="topnav-right">
    <a class="a3" href="view_item.php">Manage Products</a>
    <a class="a3" href="view_user.php">Manage Users</a>
    <a class="a3" href="a_logout.php">Log Out</a>

    </div>
    </div>
    <?php
    $items_id=$_GET['items_id'];

    // Connect to database to get item name
    $host="localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "alb";

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
    if (mysqli_connect_error()) {
        die('Connect Error ('. mysqli_connect_errno() .') '. mysqli_connect_error());
    }

    // Get item name
    $sql = "SELECT name FROM items WHERE items_id='$items_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $item_name = $row['name'];
    $conn->close();
    ?>
  <form method="post" action="delete_item_connection.php">
      <center><br><br><br>
                <input type="hidden" name="items_id" value="<?php echo $items_id; ?>">
                <div style="margin-bottom: 20px;">
                    <span style="font-size: 28px; color: #333;">Item Name: <b><?php echo $item_name; ?></b></span>
                </div>
                <b class="d1"> Are you sure to delete this item?  </b><br><br>
                <input type="submit" class="s1" value="DELETE ITEM">
    </center>
            </form>