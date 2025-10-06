<!DOCTYPE html>
<html>
<head>
    <title>Sign up | Efarm</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #ffffff 0%, #e5ffe5 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .signup-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 50px 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            width: 450px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            margin: 0 0 30px 0;
            color: #00875A;
            font-size: 32px;
            font-weight: 600;
            text-align: center;
            letter-spacing: -0.5px;
        }

        .error {
            background: #e5ffe5;
            color: #00875A;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        input[type=email], 
        input[type=password], 
        input[type=text] {
            width: 100%;
            padding: 15px 20px;
            margin: 8px 0;
            border: 2px solid #e1e1e1;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: white;
        }

        input:focus {
            border-color: #00875A;
            outline: none;
            box-shadow: 0 0 0 4px rgba(0, 135, 90, 0.1);
        }

        input[type=submit] {
            width: 100%;
            padding: 15px;
            background: #00875A;
            color: white;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            margin-top: 20px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        input[type=submit]:hover {
            background: #006c47;
            transform: translateY(-2px);
            box-shadow: 0 7px 20px rgba(0, 135, 90, 0.3);
        }

        input[type=submit]:active {
            transform: translateY(0);
        }

        .links {
            margin-top: 30px;
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .links a {
            color: #00875A;
            text-decoration: none;
            margin: 0 15px;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .links a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background: #00875A;
            transition: width 0.3s ease;
        }

        .links a:hover::after {
            width: 100%;
        }

        @media (max-width: 480px) {
            .signup-container {
                padding: 30px 20px;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h2>Sign up</h2>
        <?php
            session_start();
            if(isset($_SESSION['tmp10'])) {
                echo '<p class="error">'.$_SESSION['tmp10'].'</p>';
                unset($_SESSION['tmp10']);
            }
        ?>
        
        <form method="post" action="signup_connection.php">
            <div class="input-group">
                <input type="text" name="firstname" placeholder="First name" required pattern="[A-Za-z_]+" title="No Numbers and Spaces(Use _)" autofocus>
            </div>
            <div class="input-group">
                <input type="text" name="lastname" placeholder="Last name" required pattern="[A-Za-z_]+" title="No Numbers and Spaces,(Use _)">
            </div>
            <div class="input-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="input-group">
                <input type="text" name="mobile" placeholder="Mobile" required minlength="10" maxlength="10" pattern="[0-9]+">
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required minlength="6" pattern="[^' ']+" title="No Spaces">
            </div>
            <input type="submit" value="Create Account">
        </form>
        
        <div class="links">
            <a href="../login/login.php">Already have an account? Login</a>
            <a href="../index.php">Back to Home</a>
        </div>
    </div>
</body>
</html>