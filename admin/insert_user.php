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
    <title><?php echo $_SESSION['usr']; ?> | Add User</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .logo {
            text-align: center;
            padding: 20px 0;
            background: linear-gradient(135deg, rgba(0, 128, 0, 0.9) 0%, rgba(0, 64, 0, 0.9) 100%);
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .logo-text {
            margin: 0;
            font-size: 2.5em;
            color: white;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .logo:hover .logo-text {
            transform: scale(1.05);
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.4);
        }

        body {
            background-image: url('../css/image/img5.jpeg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            font-family: 'Poppins', sans-serif;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .form-group input:focus {
            border-color: #667eea;
            outline: none;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.5);
        }
        .submit-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
            width: 100%;
        }
        .submit-button:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }
        .topnav {
            background-color: darkgreen;
            overflow: hidden;
            padding: 10px;
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
        .topnav-right {
            float: right;
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
        .top {
            color: indigo;
            font-size: 25px;
        }
            
        .t1
        {
          width: 25%;
          padding: 12px 20px;
          margin: 8px 0;
          border: 1px solid #ccc;
          border-radius: 5px;
          box-sizing: border-box;
          font-size: 18px;
        }
        .w1
        {
          width: 100%;
          padding: 12px 20px;
          margin: 8px 0;
          border: 1px solid #ccc;
          border-radius: 5px;
          box-sizing: border-box;
          font-size: 18px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
            backdrop-filter: blur(8px);
            margin: 20px 0;
        }
        th {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            font-size: 18px;
            font-weight: 600;
            padding: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        td {
            font-size: 16px;
            padding: 12px 15px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        tr:hover td {
            background: rgba(102, 126, 234, 0.1);
            transform: scale(1.01);
        }
        .s1 
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
        .w2{
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
		p.error{
			color:darkred;
			font-size:35px;
      align:center;
		}
    </style>
</head>
<body>

<div class="logo">
    <h1 class="logo-text">E-FARM ADMIN</h1>
</div>

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

<div class="container">
    <h1>Add New User</h1>
    <form method="post" action="insert_user_connection.php"> 
        <div class="form-group">
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" required pattern="[A-Za-z_]+" title="No Numbers and Spaces (Use _)" autofocus>
        </div>
        <div class="form-group">
            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" required pattern="[A-Za-z_]+" title="No Numbers and Spaces (Use _)">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="mobile">Mobile:</label>
            <input type="text" id="mobile" name="mobile" required minlength="10" maxlength="10" pattern="[0-9]+">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required minlength="6" pattern="[^' ']+" title="No Spaces">
        </div>
        <button type="submit" class="submit-button">ADD USER</button>
    </form>

    <center>
        <?php
            if(isset($_SESSION['tmp100']))
            {
                echo '<br><p class="error">'.$_SESSION['tmp100'].'</p>';
                unset($_SESSION['tmp100']);
            }
        ?>
    </center>
</div>

</body>
</html>