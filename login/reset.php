<?php session_start(); ?><!DOCTYPE html>
<html>
<head>
    <title>Forgot Password | E-FARM</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            background: #ffffff;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Particles */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        .particle {
            position: absolute;
            width: 8px;
            height: 8px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            animation: float 20s infinite linear;
        }

        @keyframes float {
            0% { transform: translateY(0) rotate(0deg); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-1000px) rotate(720deg); opacity: 0; }
        }

        .main-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        .glass-container {
            background: rgba(255, 255, 255, 1);
            backdrop-filter: blur(20px);
            border-radius: 30px;
            padding: 60px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            position: relative;
            overflow: hidden;
        }

        .logo {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo h1 {
            color: #006838;
            font-size: 52px;
            font-weight: 700;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .logo p {
            color: #666;
            font-size: 24px;
            font-weight: 500;
            letter-spacing: 1px;
        }

        .form-group {
            margin-bottom: 30px;
        }

        .form-group label {
            display: block;
            color: #006838;
            margin-bottom: 12px;
            font-size: 18px;
            font-weight: 600;
        }

        .form-group input {
            width: 100%;
            padding: 18px 25px;
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 15px;
            font-size: 17px;
            color: #495057;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            border-color: #006838;
            background: #fff;
            box-shadow: 0 5px 20px rgba(0, 104, 56, 0.1);
        }

        .submit-btn {
            width: 100%;
            padding: 20px;
            background: linear-gradient(45deg, #006838, #00a650);
            color: #fff;
            border: none;
            border-radius: 15px;
            font-size: 20px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 104, 56, 0.4);
        }

        .error-message {
            background: #fff3f3;
            color: #dc3545;
            padding: 20px 25px;
            border-radius: 15px;
            margin: 25px 0;
            text-align: center;
            border-left: 5px solid #dc3545;
            font-size: 16px;
        }

        .nav-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .nav-btn {
            padding: 14px 28px;
            background: #fff;
            color: #006838;
            border: 2px solid #006838;
            border-radius: 12px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 12px rgba(0, 104, 56, 0.1);
            position: relative;
            overflow: hidden;
        }

        .nav-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                to right,
                rgba(0, 104, 56, 0),
                rgba(0, 104, 56, 0.1),
                rgba(0, 104, 56, 0)
            );
            transform: skewX(-25deg);
            transition: all 0.75s ease;
        }

        .nav-btn:hover {
            background: #003838;
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 6px 18px rgba(0, 104, 56, 0.2);
        }

        .nav-btn:hover::before {
            left: 100%;
        }

        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            padding: 12px 25px;
            background: rgba(255, 255, 255, 0.9);
            color: #006838;
            border: 2px solid #003838;
            border-radius: 12px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 100;
            box-shadow: 0 5px 15px rgba(0, 104, 56, 0.1);
        }

        .back-button:hover {
            background: #003838;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 104, 56, 0.2);
        }

        @media (max-width: 768px) {
            .glass-container {
                padding: 30px;
                margin: 20px;
            }

            .logo h1 {
                font-size: 36px;
            }

            .nav-links {
                flex-direction: column;
            }

            .nav-btn {
                width: 100%;
                justify-content: center;
            }

            .back-button {
                top: 10px;
                left: 10px;
                padding: 8px 15px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <!-- Add animated particles -->
    <div class="particles">
        <?php for($i = 0; $i < 50; $i++) { 
            $randomLeft = rand(0, 100);
            $randomDelay = rand(0, 20);
            echo "<div class='particle' style='left: {$randomLeft}%; animation-delay: {$randomDelay}s'></div>";
        } ?>
    </div>

    <a href="login.php" class="back-button">
        <i class="fas fa-arrow-left"></i> Back to Login
    </a>

    <div class="main-container">
        <div class="glass-container">
            <div class="glass-effect"></div>
            <div class="logo">
                <h1>E-FARM</h1>
                <p>Your Recovery password</p>
            </div>

            <!-- Update the form section -->
            <form action="reset_connection.php" method="POST">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" required autofocus autocomplete="off" 
                           placeholder="Enter your registered email">
                </div>

                <div class="form-group">
                    <label>Mobile Number</label>
                    <input type="tel" name="mobile" required minlength="10" maxlength="10" 
                           pattern="[0-9]+" autocomplete="off" 
                           placeholder="Enter your registered mobile number">
                </div>

                <?php
                if(isset($_SESSION['tmp1'])) {
                    echo '<div class="error-message">' . $_SESSION['tmp1'] . '</div>';
                    unset($_SESSION['tmp1']);
                }
                ?>

                <button type="submit" class="submit-btn">
                    Recovery Password
                </button>
            </form>

            <div class="nav-links">
                <a href="../signup/signup.php" class="nav-btn">
                    <i class="fas fa-user-plus"></i> Create Account
                </a>
                <a href="../index.php" class="nav-btn">
                    <i class="fas fa-home"></i> Return Home
                </a>
            </div>
        </div>
    </div>
</body>
</html>