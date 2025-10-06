<!DOCTYPE html>
<html>
<head>
    <title>Contact Us - E-FARM</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
        }

        .header {
            background-color: #fff;
            padding: 20px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .logo {
            font-size: 28px;
            font-weight: 700;
            color: #1a472a;
            text-decoration: none;
        }

        .logo span {
            color: #4CAF50;
        }

        .nav-links {
            display: flex;
            gap: 30px;
        }

        .nav-links a {
            color: #333;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
        }

        .contact-container {
            max-width: 1400px;
            margin: 80px auto;
            padding: 0 40px;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 50px;
            justify-items: center;
        }

        .contact-info {
            background: white;
            padding: 60px;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 800px;
        }

        .contact-info h2 {
            color: #1a472a;
            margin-bottom: 40px;
            font-size: 36px;
            text-align: center;
        }

        .info-item {
            margin-bottom: 35px;
            text-align: center;
        }

        .info-item h3 {
            color: #4CAF50;
            margin-bottom: 15px;
            font-size: 24px;
        }

        .info-item p {
            color: #666;
            line-height: 1.8;
            font-size: 18px;
        }
        .contact-form {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }

        .contact-form h2 {
            color: #1a472a;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: 'Poppins', sans-serif;
        }

        .form-group textarea {
            height: 150px;
            resize: vertical;
        }

        .submit-btn {
            background-color: #4CAF50;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .submit-btn:hover {
            background-color: #388e3c;
        }

        .success-message {
            background-color: #dff0d8;
            color: #3c763d;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: none;
        }

        .error-message {
            background-color: #f2dede;
            color: #a94442;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: none;
        }

        /* Home Button Styles */
        .home-button {
            position: fixed;
            top: 20px;
            left: 20px;
            background-color: #4CAF50;
            color: white;
            padding: 12px 24px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            z-index: 1000;
        }

        .home-button:hover {
            background-color: #388e3c;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .home-button i {
            font-size: 16px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <a href="index.php" class="home-button">
        <i class="fas fa-home"></i>
        Home
    </a>

    <div class="contact-container">
        <div class="contact-grid">
            <div class="contact-info">
                <h2>Get in Touch</h2>
                <div class="info-item">
                    <h3>Address</h3>
                    <p>NOBLE STAR HOSTEL-MAKHIYALAt<br>MAKHIYALA, JUNAGADH - 362011</p>
                </div>
                <div class="info-item">
                    <h3>Phone</h3>
                    <p>9327243853<br>8160032803</p>
                </div>
                <div class="info-item">
                    <h3>Email</h3>
                    <p>princesangani58@GMail.com<br>harshsorthiya32@gmail.com<br>manansavaliya55@gmail.com</p>
                </div>
                <div class="info-item">
                    <h3>Working Hours</h3>
                    <p>all day<br>24/7</p>
                </div>
            </div>

            
        </div>
    </div>
</body>
</html>