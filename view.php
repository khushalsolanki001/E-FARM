<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $_GET['choice'].' | Items' ?></title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Poppins', sans-serif;
            color: #333;
            margin: 0;
            min-height: 100vh;
        }

        .header {
            text-align: center;
            padding: 30px;
            background: linear-gradient(45deg, #1a472a, #2e7d32);
            color: white;
            margin-bottom: 30px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .header h1 {
            margin: 0;
            font-size: 48px;
            letter-spacing: 2px;
            text-transform: uppercase;
            background: linear-gradient(45deg, #ffffff, #e0e0e0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .topnav {
            background: linear-gradient(to right, #1a472a, #2e7d32);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(10px);
        }

        .topnav a {
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s ease;
            margin: 0 5px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
        }

        .topnav a:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .search-container {
            background: rgba(255, 255, 255, 0.25);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
            margin: 20px auto;
            max-width: 600px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        input[type=text] {
            width: 70%;
            padding: 15px 25px;
            border: 2px solid #e0e0e0;
            border-radius: 30px;
            font-size: 16px;
            transition: all 0.3s ease;
            margin-right: 10px;
        }

        input[type=text]:focus {
            border-color: #4CAF50;
            outline: none;
            box-shadow: 0 0 0 3px rgba(76,175,80,0.1);
        }

        input[type=submit] {
            background: #4CAF50;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
            font-weight: 500;
            background: linear-gradient(45deg, #4CAF50, #2E7D32);
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
            position: relative;
            overflow: hidden;
        }

        input[type=submit]:hover {
            background: linear-gradient(45deg, #2E7D32, #4CAF50);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(76, 175, 80, 0.4);
        }

        input[type=submit]::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: 0.5s;
        }

        input[type=submit]:hover::before {
            left: 100%;
        }

        .container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            padding: 30px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .card {
            background: rgba(255, 255, 255, 0.7);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.2);
        }

        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .card h3 {
            color: #1a472a;
            margin: 10px 0;
            font-size: 1.4em;
        }

        .card p {
            color: #666;
            margin: 8px 0;
            line-height: 1.4;
        }

        
        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 30px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .category-button {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            color: #1a472a;
            padding: 20px;
            border-radius: 15px;
            text-decoration: none;
            text-align: center;
            font-weight: 500;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.18);
            position: relative;
            overflow: hidden;
        }

        .category-button:hover {
            background: linear-gradient(135deg, #1a472a 0%, #2e7d32 100%);
            color: white;
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 15px 30px rgba(26, 71, 42, 0.3);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .category-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: 0.5s;
        }

        .category-button:hover::before {
            left: 100%;
        }
    </style>
    <script>
        function checkLogin(itemId) {
            <?php
            session_start();
            if(!isset($_SESSION['user'])) {
                echo 'alert("કૃપા કરી વિગતો જોવા માટે પ્રથમ લોગિન કરો!");';
                echo 'window.location.href = "login/login.php";';
            } else {
                echo 'window.location.href = "item_individual.php?id=" + itemId;';
            }
            ?>
        }
    </script>
</head>
<body>
    <div class="header">
        <h1><a href="../index.php" class="logo">E-<span>FARM</span></a></h1>
    </div>

    <div class="topnav">
        <div class="nav-left">
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <a href="item.php"><i class="fas fa-store"></i> All Items</a>
        </div>
        <div class="nav-right">
            <a href="signup/signup.php"><i class="fas fa-user-plus"></i> Sign Up</a>
            <a href="login/login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
        </div>
    </div>

<div class="search-container">
    <form method="post" action="search.php">
        <input type="text" name="search" placeholder="Search for products...">
        <input type="submit" name="submit" value="Search">
    </form>
</div>

<div class="container">
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        include 'connection.php';

        $allowedCategories = array('FERTILIZER','HERBICIDE','INSECTICIDES','PESTICIDES','SPRAYER','OTHER');
        $txt = isset($_GET['choice']) ? $_GET['choice'] : '';
        if ($txt !== '' && in_array($txt, $allowedCategories)) {
            $safeTxt = mysqli_real_escape_string($con, $txt);
            $sql = "SELECT * from items where types='$safeTxt'";
            $result = mysqli_query($con, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='card'>";
                    echo "<img src='admin/image/" . $row["img"] . "' alt='Item Image'>";
                    echo "<h3>" . $row['name'] . "</h3>";
                    echo "<p><strong>Brand:</strong> " . $row['brand'] . "</p>";
                    echo "<p><strong>Type:</strong> " . $row['types'] . "</p>";
                    echo "<p><strong>Price:</strong> ₹" . $row['price'] . "</p>";
                    echo "<p>" . $row['description'] . "</p>";
                    echo "</div>";
                }
            }
        }
    }
    ?>
</div>

<div class="category-grid">
    <a href="view.php?choice=FERTILIZER" class="category-button">FERTILIZER</a>
    <a href="view.php?choice=HERBICIDE" class="category-button">HERBICIDE</a>
    <a href="view.php?choice=INSECTICIDES" class="category-button">INSECTICIDES</a>
    <a href="view.php?choice=PESTICIDES" class="category-button">PESTICIDES</a>
    <a href="view.php?choice=SPRAYER" class="category-button">SPRAYER</a>
    <a href="view.php?choice=OTHER" class="category-button">OTHER</a>
</div>

</body>
</html>
