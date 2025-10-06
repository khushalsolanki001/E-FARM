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
        a.a2 {
            text-decoration: none;
            background: linear-gradient(45deg, #FF6B6B, #4ECDC4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 75px;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            position: relative;
        }
        a.a2:hover {
            transform: scale(1.05);
            text-shadow: 3px 3px 6px rgba(0,0,0,0.3);
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
            
        input[type=text] {
            width: 40%;
            padding: 15px 25px;
            margin: 15px 0;
            border: none;
            border-radius: 15px;
            font-size: 18px;
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.18);
            transition: all 0.3s ease;
        }
        input[type=text]:focus {
            outline: none;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.3);
            transform: translateY(-2px);
        }
        input[type=submit] {
            width: 150px;
            background: linear-gradient(45deg, #4ECDC4, #2ecc71);
            color: white;
            padding: 15px 25px;
            margin: 15px 0;
            border: none;
            border-radius: 15px;
            cursor: pointer;
            font-size: 20px;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(46, 204, 113, 0.2);
        }
        input[type=submit]:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(46, 204, 113, 0.3);
            background: linear-gradient(45deg, #2ecc71, #4ECDC4);
        }
        table {
            width: 95%;
            margin: 20px auto;
            border-collapse: separate;
            border-spacing: 0;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        th {
            background: linear-gradient(45deg, #2ecc71, #27ae60);
            color: white;
            font-size: 24px;
            font-weight: 600;
            padding: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 3px solid #27ae60;
        }
        td {
            font-size: 18px;
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            transition: all 0.3s ease;
            color: #2c3e50;
        }
        tr:hover td {
            background-color: rgba(46, 204, 113, 0.1);
            transform: scale(1.01);
            color: #27ae60;
        }
        tr:last-child td {
            border-bottom: none;
        }
        button {
            background-color: #ff4757;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        button:hover {
            background-color: #ff6b81;
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
    </style>

    <center><h1><a class="a2" href="../index.php">E-FARM ADMIN</a></h1></center>

<div class="top">
<!--Search Code-->
<form method="post" action="search1.php">
<b>Search User:</b>
<input type="text" name="search" placeholder="Enter the  username here..."autofocus>
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

    
    <table align="center" border="1" bgcolor="LightGoldenRodYellow">

		<tr>
			<th>USER_ID</th>
			<th>FIRST NAME</th>
			<th>LAST NAME</th>
			<th>EMAIL</th>
			<th>MOBILE</th>
            <th>ADDRESS</th>
            <th>ACTION</th>   
		</tr>
 <?php

$host="localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "alb";

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

if (mysqli_connect_error()) {
		die('Connect error('. mysqli_connect_error().')'. mysqli_connect_error());
	}

        $sql = "SELECT * from users;";
        $result=mysqli_query($conn, $sql);
       $resultCheck = mysqli_num_rows($result);
       if($resultCheck > 0){
           while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>".$row['users_id'] ."</td>";
            echo "<td>".$row['firstname'] ."</td>";
            echo "<td>".$row['lastname'] ."</td>";
            echo "<td>".$row['email'] ."</td>";
            echo "<td>".$row['mobile'] ."</td>";
           // echo "<td> ".$row['password'] ."</td>";
            echo "<td> ".$row['adr'] ."</td>";
            echo "<td><a href=delete_user.php?users_id=".$row['users_id']. "><button>DELETE</button></a></td>";
            echo "</tr>";
          
           }
       }
?>
</table>
</body>
</html>