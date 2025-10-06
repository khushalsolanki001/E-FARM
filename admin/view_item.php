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
 <style>
    body {
        background-image: url('../css/image/img5.jpeg');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    a.a2 {
        text-decoration: none;
        background: linear-gradient(45deg, #2ecc71, #3498db);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        font-size: 75px;
        transition: all 0.3s ease;
        letter-spacing: 2px;
        font-weight: bold;
    }
    a.a2:hover {
        transform: scale(1.08);
        text-shadow: 4px 4px 8px rgba(0, 0, 0, 0.5);
        background: linear-gradient(45deg, #3498db, #2ecc71);
        -webkit-background-clip: text;
        background-clip: text;
    }
    .topnav {
        background: linear-gradient(135deg, rgba(0, 100, 0, 0.95), rgba(0, 150, 0, 0.95));
        overflow: hidden;
        border-radius: 12px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
        margin: 20px 0;
    }
    .topnav a {
        float: left;
        color: #ffffff;
        text-align: center;
        padding: 16px 24px;
        text-decoration: none;
        font-size: 17px;
        font-weight: 500;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }
    .topnav-right {
        float: right;
    }
    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
        padding: 25px;
        margin: 0 auto;
        max-width: 1400px;
    }
    .grid-item {
        border: none;
        border-radius: 15px;
        padding: 20px;
        text-align: center;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
        transition: all 0.3s ease;
    }
    .grid-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 40px rgba(31, 38, 135, 0.15);
        background: rgba(255, 255, 255, 0.95);
    }
    .grid-item img {
        max-width: 100%;
        height: 200px;
        width: 200px;
        object-fit: cover;
        border-radius: 4px;
        margin: 10px 0;
    }
    .grid-item button {
        margin: 8px;
        padding: 12px 20px;
        background: linear-gradient(45deg, #00b09b, #96c93d);
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 176, 155, 0.2);
    }
    .grid-item button:hover {
        background: linear-gradient(45deg, #96c93d, #00b09b);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 176, 155, 0.3);
    }
 </style>
</head>
<body>
    <center><h1><a class="a2" href="../index.php">E-FARM ADMIN</a></h1></center>

<div class="top">
<!--Search Code-->
<form method="post" action="search.php">
<center><h1><b>Search Items:</b>
<input type="text" name="search" placeholder="Enter the product name here..." autofocus>
<input type="submit" value="Search" name="search"></h1>
</center>
</form>
<!--Search End-->

    <div class="topnav">
    <a class="a3" href="admin_home.php">Home</a>
    <a class="a3" href="insert_item.php">Add Item</a>
    <a class="a3" href="insert_user.php">Add User</a>
    <div class="topnav-right">
    <a class="a3" href="view_item.php">Manage Products</a>
    <a class="a3" href="view_user.php">Manage Users</a>
    <a class="a3" href="a_logout.php">Log Out</a>
    </div>
    </div>
  
    <div class="grid-container">
 <?php

$host="localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "alb";

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

if (mysqli_connect_error()) {
    die('Connect error('. mysqli_connect_error().')'. mysqli_connect_error());
}

$sql = "SELECT * from items;";
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);
if($resultCheck > 0){
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='grid-item'>";
        echo "<h3>".$row['name'] ."</h3>";
        echo "<p>Brand: ".$row['brand'] ."</p>";
        echo "<p>Description: ".$row['description'] ."</p>";
        echo "<p>Type: ".$row['types'] ."</p>";
        echo "<p>Price: ₹".$row['price'] ."</p>";
        echo "<p>Stock: ".$row['stock'] ."</p>";
        $pathx = "image/";
        $file = $row["img"];
        echo '<img src="'.$pathx.$file.'" alt="'.$row['name'].'">';
        echo "<div>
              <a href=item_image.php?items_id=".$row['items_id']. "><button>UPLOAD IMAGE</button></a><br>
              <a href=edit_item.php?items_id=".$row['items_id']. "><button>UPDATE</button></a><br>
              <a href=delete_item.php?items_id=".$row['items_id']. "><button>DELETE</button></a><br>
              <a href=manage_stock.php?items_id=".$row['items_id']. "><button>MANAGE STOCK</button></a></div>";
        echo "</div>";
    }
}
?>
    </div>
</body>
</html>
