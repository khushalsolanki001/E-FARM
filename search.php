<!DOCTYPE html>
<html>
<head>
	<title>Search | Item</title>
</head>
<body>
    
<style>
        body {
            background-image: url('../css/image/img5.jpeg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        a.a2 {
            text-decoration: none;
            color: #2E7D32;
            font-size: 75px;
            font-weight: 800;
            background: linear-gradient(135deg, #2E7D32, #1B5E20);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            display: inline-block;
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
            transform: scale(1.05);
            text-shadow: 4px 4px 8px rgba(0,0,0,0.3);
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
        .search-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            margin: 20px auto;
            width: 80%;
            max-width: 800px;
        }
        .search-container form {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .a4 {
            width: 70%;
            padding: 15px 20px;
            margin: 10px 0;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            color: #333;
            font-size: 18px;
            transition: all 0.3s ease;
        }
        .a4:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 15px rgba(76, 175, 80, 0.3);
        }
        .a5 {
            width: 150px;
            background: linear-gradient(135deg, #2E7D32 0%, #1B5E20 100%);
            color: white;
            padding: 15px 25px;
            margin: 10px 0;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 18px;
            font-weight: 600;
            transition: all 0.4s ease;
            text-transform: uppercase;
            letter-spacing: 2px;
            box-shadow: 0 4px 15px rgba(46, 125, 50, 0.2);
            position: relative;
            overflow: hidden;
        }
        .a5:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(46, 125, 50, 0.4);
            background: linear-gradient(135deg, #1B5E20 0%, #2E7D32 100%);
        }
        .a5:active {
            transform: translateY(1px);
            box-shadow: 0 2px 10px rgba(46, 125, 50, 0.3);
        }
        
    h3{
      color:red;
      font-size:50px;
      text-align:center;
    }

      table {
            width: 80%;
            margin: 30px auto;
            border-collapse: separate;
            border-spacing: 0;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
      th {
        background-color: #2c3e50;
        color: white;
        font-size: 22px;
        font-weight: 500;
        padding: 15px;
        text-transform: uppercase;
        letter-spacing: 1px;
        border: none;
      }
      td {
        font-size: 18px;
        color:rgb(5, 66, 42);
        padding: 15px;
        border-bottom: 1px solid #ddd;
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

<center><h1><a class="a2" href="../index.php">E-FARM</a></h1></center>

<div class="search-container">
    <form method="post" action="search.php">
        <input type="text" class="a4" name="search" placeholder="Search the Item here...">
        <input type="submit" class="a5" name="submit" value="Search">
    </form>
</div>

<div class="topnav">
<a class="a3" href="index.php">Home</a>  
<a class="a3" href="item.php">All items</a>

<div class="topnav-right">
    <a class="a3" href="signup/signup.php">Sign Up</a>
    <a class="a3" href="login/login.php">Login</a>
  
</div>
</div>

</body>
</html>

<?php
$con = new PDO("mysql:host=localhost;dbname=alb",'root','');
if (isset($_POST["submit"])) {
	$str = $_POST["search"];
	$allowed = array('FERTILIZER','HERBICIDE','INSECTICIDES','PESTICIDES','SPRAYER','OTHER');
	$placeholders = implode(",", array_fill(0, count($allowed), "?"));
	$sql = "SELECT * FROM `items` WHERE name like ? AND types IN (".$placeholders.")";
	$sth = $con->prepare($sql);
	$params = array_merge(array('%'.$str.'%'), $allowed);
	$sth->setFetchMode(PDO:: FETCH_OBJ);
	$sth -> execute($params);
	if($row = $sth->fetch())
	{
		?>
		<br><br>
		<table align="center" border="1" bgcolor="LightGoldenRodYellow">
		
			<tr><th>ITEM ID</th><td><?php echo $row->items_id; $items_id=$row->items_id;?></td></tr>
			<tr><th>NAME</th><td><?php echo $row->name; ?></td></tr>
			<tr><th>BRAND</th><td><?php echo $row->brand; ?></td></tr>
			<tr><th>DESCRIPTION</th><td><?php echo $row->description;?></td></tr>
			<tr><th>TYPES</th><td><?php echo $row->types;?></td></tr>
			<tr><th>PRICE</th>	<td><?php echo $row->price;?></td></tr>
			
			<tr><th>IMAGE</th>  <td><?php $pathx = "admin/image/";
                $file = $row->img;
                echo '<img src="'.$pathx.$file.'" height=100 width=100>';?></td>
			</tr>
<?php 
	}
		else{
			die("<h3>Product: Not Found!</h3>");
		}
}

?>

<?php

include 'connection.php';

//review
//echo "<tr><td><b><u>Reviews:</u></b></td></tr>";
//echo $items_id;
$sql1 = "SELECT * from sales where items_id='$items_id'";
$result1=mysqli_query($con, $sql1);
$resultCheck1 = $result1 ? mysqli_num_rows($result1) : 0;
if($resultCheck1 > 0){
   while ($row = mysqli_fetch_assoc($result1)) {
    echo "<tr><th>REVIEW </th><td>".$row['review'] ." ";
   }
echo "</td></tr>";
}
?>


</table>