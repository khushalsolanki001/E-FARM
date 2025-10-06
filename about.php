<!DOCTYPE html>
<html>
<head>
    <title>About Us - E-FARM</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
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

        /* Responsive styles for home button */
        @media (max-width: 768px) {
            .home-button {
                padding: 10px 20px;
                font-size: 14px;
            }
        }

        /* About Hero Section */
        .about-hero {
            height: 400px;
            background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('images/farm-about.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            margin-top: 60px;
        }

        .about-hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        /* About Content Section */
        .about-content {
            max-width: 1200px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .about-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .about-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .about-card:hover {
            transform: translateY(-5px);
        }

        .about-card h3 {
            color: #1a472a;
            margin-bottom: 15px;
        }

        .about-card p {
            color: #666;
            line-height: 1.6;
        }

        /* New Farm Information Section */
        .farm-info {
            margin-top: 50px;
            background: #e5ffe5; /* Light green background */
            padding: 20px;
            border-radius: 10px;
        }

        .farm-info h2 {
            color: #00875A; /* Dark green color */
            margin-bottom: 15px;
        }

        .farm-info p {
            color: #333;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <!-- Home Button -->
    <a href="index.php" class="home-button">
        <i class="fas fa-home"></i>
        Home
    </a>

    <!-- Hero Section -->
    <div class="about-hero">
        <h1>About E-FARM</h1>
    </div>

    <!-- About Content -->
    <div class="about-content">
        <div class="about-grid">
            <div class="about-card">
                <h3>Our Mission</h3>
                <p>To provide high-quality agricultural products while supporting sustainable farming practices and empowering local farmers.</p>
            </div>
            <div class="about-card">
                <h3>Our Vision</h3>
                <p>To become the leading digital agricultural marketplace, connecting farmers directly with consumers.</p>
            </div>
            <div class="about-card">
                <h3>Our Values</h3>
                <p>Quality, Sustainability, Community Support, and Innovation in Agriculture.</p>
            </div>
        </div>

        <!-- New Farm Information Section -->
        <div class="farm-info">
            <h2>About Our Farm</h2>
            <p>At E-FARM, we are dedicated to promoting sustainable agriculture and providing fresh, organic produce to our community. Our farm spans over 50 acres, where we grow a variety of fruits and vegetables using eco-friendly practices.</p>
            <p>We believe in supporting local farmers and ensuring that our products are not only healthy but also environmentally friendly. Our commitment to quality and sustainability drives everything we do, from planting to harvesting.</p>
            <p>Join us in our mission to create a healthier planet and a more sustainable future for generations to come!</p>
        </div>
    </div>
</body>
</html> 