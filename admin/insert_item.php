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
    <title><?php echo $_SESSION['usr']; ?> | Add Item</title>
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
        .form-group input, .form-group select, .form-group datalist {
            width: 100%;
            padding: 12px;
            border: 1px solid rgba(102, 126, 234, 0.2);
            border-radius: 8px;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        .form-group input:focus, .form-group select:focus {
            border-color: #667eea;
            outline: none;
            box-shadow: 0 8px 16px rgba(102, 126, 234, 0.2);
            transform: translateY(-2px);
        }

        .form-group input:hover, .form-group select:hover {
            border-color: #667eea;
            box-shadow: 0 4px 8px rgba(102, 126, 234, 0.1);
        }
        .submit-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            font-weight: 600;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 20px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
        }
        .submit-button:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
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
    <h1 style="color: #2d3748; font-size: 2.5em; font-weight: 700; margin-bottom: 30px; text-shadow: 2px 2px 4px rgba(0,0,0,0.1);">Add New Item</h1>
    <form method="post" action="insert_item_connection.php" style="background: rgba(255, 255, 255, 0.7); padding: 30px; border-radius: 15px; box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); border: 1px solid rgba(255, 255, 255, 0.18);">
        <div class="form-group">
            <label for="name">Item Name:</label>
            <input type="text" id="name" name="name" required pattern="[a-zA-Z0-9 ]+" autofocus>
        </div>
        <div class="form-group">
            <label for="brand">Product Brand:</label>
            <input type="text" id="brand" name="brand" required pattern="[A-Za-z ]+" title="No Numbers">
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <input type="text" id="description" name="description" pattern="[a-zA-Z0-9. ]+" title="No special characters" required>
        </div>
        <div class="form-group">
            <label for="types">Category (Agri Inputs):</label>
            <input list="types" id="types" name="types" placeholder="Select category (e.g., FERTILIZER)" required>
            <datalist id="types">
                <option value="FERTILIZER">
                <option value="HERBICIDE">
                <option value="INSECTICIDES">
                <option value="PESTICIDES">
                <option value="SPRAYER">
                <option value="OTHER">
            </datalist>
        </div>
        <div class="form-group">
            <label for="price">Price (₹):</label>
            <input type="number" id="price" name="price" min="1" step="1" placeholder="Enter price in INR" required>
        </div>
        <div class="form-group">
            <label for="stock">Stock (units):</label>
            <input type="number" id="stock" name="stock" min="1" step="1" placeholder="Available quantity" required>
        </div>
        <button type="submit" class="submit-button">ADD ITEM</button>
    </form>
</div>

</body>
</html>
