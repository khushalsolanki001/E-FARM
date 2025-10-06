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
            background: linear-gradient(135deg, #1B5E20 0%, #2E7D32 100%);
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .topnav a {
            float: left;
            color: #ffffff;
            text-align: center;
            padding: 16px 24px;
            text-decoration: none;
            font-size: 18px;
            transition: all 0.3s ease;
            position: relative;
            margin: 0 2px;
        }

        .topnav a:hover {
            background: rgba(255,255,255,0.1);
            color: #ffffff;
            transform: translateY(-2px);
        }

        .topnav a:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background: #ffffff;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            transition: width 0.3s ease;
        }

        .topnav a:hover:after {
            width: 70%;
        }

        table {
            width: 90%;
            margin: 30px auto;
            border-collapse: separate;
            border-spacing: 0;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
        }

        th {
            background: linear-gradient(135deg, #1B5E20 0%, #2E7D32 100%);
            color: white;
            font-size: 22px;
            font-weight: 500;
            padding: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        td {
            font-size: 18px;
            color: #333;
            padding: 15px;
            border-bottom: 1px solid #eee;
            transition: all 0.3s ease;
        }

        tr:hover td {
            background-color: #f5f6fa;
            transform: scale(1.01);
        }

        tr:last-child td {
            border-bottom: none;
        }

        td img {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        td img:hover {
            transform: scale(1.1);
        }
    }

        .topnav-right {
            float: right;
        }        
        .top {
            color: indigo;
            font-size: 25px;
        }
               
		.a7 {
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
        input[type=submit] 
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
    </style>

    <center><h1><a class="a2" href="../index.php">E-FARM ADMIN</a></h1></center>

<div class="top">
<!--Search Code-->
<form method="post" action="search.php">
<b>Search Items:</b>
<input type="text" name="search" placeholder="Enter the product name here..."autofocus>
<input type="submit" name="submit">
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
	
</body>
</html>

<?php
$con = new PDO("mysql:host=localhost;dbname=alb",'root','');
if (isset($_POST["submit"])) {
	$str = $_POST["search"];
	$sth = $con->prepare("SELECT * FROM `items` WHERE name like '%$str%'");
	$sth->setFetchMode(PDO:: FETCH_OBJ);
	$sth -> execute();
	if($row = $sth->fetch())
	{
		?>
		<br>
			<table align="center" border="1" bgcolor="LightGoldenRodYellow">

			<tr><th>Items ID</th><td><?php echo $row->items_id; $ww=$row->items_id;?></td></tr>
			<tr><th>Name</th><td><?php echo $row->name; ?></td></tr>
			<tr><th>Brand</th><td><?php echo $row->brand; ?></td></tr>
			<tr><th>Description</th><td><?php echo $row->description;?></td></tr>
			<tr><th>Types</th><td><?php echo $row->types;?></td></tr>
			<tr><th>Price</th><td><?php echo $row->price;?></td></tr>
			<tr><th>Stock</th><td><?php echo $row->stock;?></td></tr>
			<tr><th>Image</th><td><?php $pathx = "../admin/image/";
                $file = $row->img;
                echo '<img src="'.$pathx.$file.'" height=100 width=100>';?></td>
			</tr>
		</table>
<?php 
	}
		else{
			echo "Name Does not exist";
		}
}



?>