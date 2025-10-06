<!DOCTYPE html>
<html>
<head>
	<title>All Items</title>
	<style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        } 
		a.a2{
    		text-decoration: underline;
 			  color: burlywood;
    		text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;
    		font-size: 75px;
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
        
      input[type=text]{
        width: 25%;
        padding: 12px 20px;
        margin: 8px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        font-size: 18px;
        }
        
      input[type=submit] {
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
        border-collapse: collapse;
        margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
        }
        tr:hover {
            background-color: #f5f5f5;
        }

        /* New styles for the card layout */
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin: 20px;
        }
        .card {
            border: none;
            border-radius: 16px;
            margin: 20px;
            padding: 25px;
            width: 400px;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px 0 rgba(31, 38, 135, 0.25);
        }
        .card img {
            width: 250px;
            height: 250px;
            object-fit: cover;
            border-radius: 12px;
            margin: 20px auto;
            display: block;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .card img:hover {
            transform: scale(1.05);
        }
        .button {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            padding: 14px 32px;
            margin: 15px auto;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            display: block;
            text-decoration: none;
            font-size: 16px;
            font-weight: 600;
            width: 85%;
            text-align: center;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .button:hover {
            background-color: #45a049; /* Darker green */
        }
        /* Add alert styling */
        .alert {
            padding: 20px;
            background-color: #f44336;
            color: white;
            margin-bottom: 15px;
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            border-radius: 5px;
        }
	</style>
    <script>
        function showLoginMessage() {
            alert("Please login first to view details!");
            window.location.href = "login/login.php";
        }
    </script>
</head>
<body>

<center><h1><a class="a2" href="../index.php">E-FARM</a></h1></center>

<div class="top">
<!--Search Code-->
<div class="search-form">
    <form method="post" action="search.php">
        <b>Search: </b>
        <input type="text" name="search" placeholder="Search the Item here.">
        <input type="submit" name="submit" value="Search">
    </form>
</div>
<!--Search End-->
</div>

<div class="topnav">
<a class="a3" href="index.php">Home</a>  
<a class="a3" href="item.php">All items</a>

<div class="topnav-right">
    <a class="a3" href="signup/signup.php">Sign Up</a>
    <a class="a3" href="login/login.php">Login</a>
    
</div>
</div>
<br><br>

<div class="container">
    <?php
    include 'connection.php';

    $allowed = array('FERTILIZER','HERBICIDE','INSECTICIDES','PESTICIDES','SPRAYER','OTHER');
    $allowedList = "'".implode("','", $allowed)."'";
    $sql = "SELECT * from items WHERE types IN ($allowedList);";
    $result=mysqli_query($con, $sql);
    $resultCheck = $result ? mysqli_num_rows($result) : 0;
    if($resultCheck > 0){
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='card'>";
            echo "<h3 style='color: #2c3e50; font-size: 24px; margin-bottom: 15px; font-weight: 600;'>".$row['name']."</h3>";
            echo "<p style='color: #34495e; font-size: 16px; margin: 8px 0;'><strong>Brand:</strong> ".$row['brand']."</p>";
            echo "<p style='color: #34495e; font-size: 16px; margin: 8px 0;'><strong>Description:</strong> ".$row['description']."</p>";
            echo "<p style='color: #34495e; font-size: 16px; margin: 8px 0;'><strong>Type:</strong> ".$row['types']."</p>";
            echo "<p style='color: #2c3e50; font-size: 20px; font-weight: 600; margin: 15px 0;'>₹".$row['price']."</p>";
           // echo "<p>Stock: ".$row['stock']."</p>";
            $pathx = "admin/image/";
            $file = $row["img"];
            echo "<div class='card-content'>";
            echo "<img src='".$pathx.$file."' alt='Item Image'>";
            echo "<a href='javascript:void(0)' onclick='showLoginMessage()' class='button'>View</a>";
            echo "</div>";
            echo "</div>";
        }
    }
    ?>
</div>

</body>
</html>