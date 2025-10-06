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
	<title>Welcome | <?php echo $_SESSION['user'] ?></title>
</head>
<body>
    <style>
        body {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('../css/image/img5.jpeg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            color: #333;
        }
        
        a.a2 {
            text-decoration: none;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            font-size: 80px;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        a.a2:hover {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 25px 45px;
            border-radius: 10px;
            transform: scale(1.05);
        }
        
        .topnav {
            background: linear-gradient(to right, #1a5928, #2e8b57);
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .topnav a {
            float: left;
            color: #fff;
            text-align: center;
            padding: 16px 24px;
            text-decoration: none;
            font-size: 17px;
            transition: all 0.3s ease;
        }

        .topnav a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .topnav a.active {
            background-color: #2e8b57;
            color: white;
        }

        input[type=text] {
            width: 30%;
            padding: 15px 20px;
            margin: 8px 0;
            border: 2px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        input[type=text]:focus {
            border-color: #2e8b57;
            box-shadow: 0 0 8px rgba(46, 139, 87, 0.4);
            outline: none;
        }

        .r4 {
            width: 150px;
            background: linear-gradient(to right, #2e8b57, #3cb371);
            color: white;
            padding: 15px 25px;
            margin: 8px 0;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .r4:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .a7 {
            width: 200px;
            background: linear-gradient(to right, #8b0000, #dc143c);
            color: white;
            padding: 15px 25px;
            margin: 15px 0;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 20px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .a7:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        table {
            width: 80%;
            text-align: center;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        th {
            color: #2e8b57;
            font-size: 24px;
            padding: 15px;
            background-color: #f8f9fa;
        }

        td {
            font-size: 20px;
            color: #444;
            padding: 12px;
        }

        tr:hover {
            background-color: rgba(46, 139, 87, 0.1);
        }

        h2 {
            color: #fff;
            text-align: center;
            font-size: 36px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            margin: 30px 0;
        }

        .update {
            color: #fff;
            font-size: 28px;
            text-decoration: none;
            background: linear-gradient(to right, #1e90ff, #00bfff);
            padding: 15px 30px;
            border-radius: 8px;
            display: inline-block;
            margin: 20px 0;
            transition: all 0.3s ease;
        }

        .update:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>

    <center><h1><a class="a2" href="../index.php">E-FARM</a></h1></center>

        <div class="top">
        <!--Search Code-->
        <form method="post" action="search.php">
        <b> Search: </b><input type="text" name="search" placeholder="Search the Item here.">
        <input type="submit" class="r4" name="submit">
        </form>
        <!--Search End-->
        </div>

    <div class="topnav">
    <a class="a3" href="user_home.php">Home</a>
    <a class="a3" href="view_wishlist.php">Cart</a>  
    <a class="a3" href="item.php">All items</a>
   
    <a class="a3" href="user_order.php">My Orders</a>

    <div class="topnav-right">
    <a class="a3" href="user.php">My Account</a>
    <a class="a3" href="u_logout.php">Log Out</a>
 
    </div>
    </div>
<br>
<table align="center" border="1" bgcolor="LightGoldenRodYellow">
<form action="sale.php" method="POST" enctype="multipart/form-data"> 
        
<?php

$host="localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "alb";

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

if (mysqli_connect_error()) {
		die('Connect error('. mysqli_connect_error().')'. mysqli_connect_error());
	}

  $txt7=filter_input(INPUT_POST, 'items_id');

$sql = "SELECT * from items where items_id='$txt7';";
$result=mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);

if($resultCheck == 1){
  die("<h3>Invalid ID!</h3>");
}


if($resultCheck > 0){
   while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<th>Item ID</th><td>".$row['items_id'] ."</td></tr>";
    $z=$row['items_id'];
    echo "<tr><th>Name</th><td>".$row['name'] ."</td></tr>";
    echo "<tr><th>Brand</th><td>".$row['brand'] ."</td></tr>";
    echo "<tr><th>Description</th><td>".$row['description'] ."</td></tr>";
    echo "<tr><th>Type</th><td>".$row['types'] ."</td></tr>";
    echo "<tr><th>Price</th><td>₹".$row['price'] ."</td></tr>";

    $pathx = "../admin/image/";
    $file = $row["img"];
    echo "<tr><th>Image</th><td>";
    echo '<img src="'.$pathx.$file.'" height=100 width=100>';
    echo "</td>";
    echo "</tr>";
   }
}
?>

<?php
//review
$txt7=filter_input(INPUT_POST, 'items_id');
$sql = "SELECT * from sales where items_id='$txt7'";
$result=mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);
if($resultCheck > 0){
   while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr><th>Review</th><td>".$row['review'] ."</td></tr>";   
   }
}
?>

</table>






     <h2>CUSTOMER ORDER</h2>

<table align="center" border="10" bgcolor="BlanchedAlmond">
                <!--<tr><th>User ID</th>-->
                <td><input type="hidden" name="users_id" required readonly value=<?php echo $_SESSION['users_id']  ?> ></td></tr>


<?php

$txt1 = $_SESSION['users_id'];
$sql = "SELECT * from users where users_id='$txt1'";
$result=mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);
if($resultCheck > 0){
   while ($row = mysqli_fetch_assoc($result)) {

    if ($row['adr']==NULL){ die("<a class=update href=account_address.php>Update your address !!!</a>");}

    echo "<tr>";
   //echo "<td>".$row['users_id'] ."</td>";
    echo "<th>First Name</th><td>".$row['firstname'] ."</td></tr>";
    echo "<tr><th>Last Name</th><td>".$row['lastname'] ."</td></tr>";
    echo "<tr><th>Email</th><td>".$row['email'] ."</td></tr>";
    echo "<tr><th>Mobile</th><td>".$row['mobile'] ."</td></tr>";
    //echo "<td> ".$row['password'] ."</td>";
    echo "<tr><th>Address</th><td>".$row['adr'] ."</td></tr>";
    echo "</tr>";
   }
}
?>           

</tr>
     <tr>
         <th>Quantity</th>
       <td><input type="number"name="qty" required value="1" min="1" ></td>
       </tr>
      <tr>
        <!-- <th>Items ID</th>-->
       <td><input type="hidden" name="items_id" autofocus required readonly value=<?php $items_id = $_SESSION['items_id']; echo $items_id; ?>> </td>
</tr>  
        </table>   

 <center>       
  <input type="submit" class="a7" value="Continue">         
</form>

</body>
</html>