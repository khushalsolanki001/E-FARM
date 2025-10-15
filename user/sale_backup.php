<?php
    session_start();
    if(!isset($_SESSION['users_id'])) {
        header('Location: ../login/login.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment | E-FARM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2ecc71;
            --secondary-color: #27ae60;
            --dark-color: #2c3e50;
            --light-color: #ecf0f1;
            --danger-color: #e74c3c;
            --shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background: #f5f5f7;
            min-height: 100vh;
            color: var(--dark-color);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header */
        .header {
            background: white;
            padding: 20px 0;
            box-shadow: var(--shadow);
            margin-bottom: 40px;
        }

        .logo {
            text-align: center;
        }

        .logo a {
            text-decoration: none;
            color: var(--dark-color);
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Payment Container */
        .payment-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .payment-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 30px;
            text-align: center;
        }

        .payment-header h2 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .order-summary {
            background: rgba(46, 204, 113, 0.1);
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .summary-row:last-child {
            border-bottom: none;
            font-weight: 700;
            color: var(--primary-color);
            font-size: 1.2rem;
        }

        .payment-form {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark-color);
        }

        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #eee;
            border-radius: 10px;
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-input:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(46, 204, 113, 0.1);
        }

        .card-row {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 20px;
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
        }

        .card-icon {
            font-size: 2rem;
            color: var(--primary-color);
            margin-right: 10px;
        }

        @media (max-width: 768px) {
            .card-row {
                grid-template-columns: 1fr;
            }

            .payment-container {
                margin: 20px;
            }
        }

        /* Add these new styles */
        .payment-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .payment-success {
            background: white;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            animation: slideIn 0.5s ease;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .success-icon i {
            color: white;
            font-size: 40px;
        }

        .success-title {
            font-size: 24px;
            color: var(--dark-color);
            margin-bottom: 10px;
        }

        .success-message {
            color: #666;
            margin-bottom: 20px;
        }

        .processing-animation {
            width: 80px;
            height: 80px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes slideIn {
            from {
                transform: translateY(-100px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="logo">
                <a href="../index.php">E-FARM</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="payment-container">
            <div class="payment-header">
                <h2>Secure Payment</h2>
                <p> Complete your purchase securely</p>
            </div>

            <?php
            $host="localhost";
            $dbusername = "root";
            $dbpassword = "";
            $dbname = "alb";

            $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

            if (mysqli_connect_error()) {
                die('Connect error('. mysqli_connect_error().')'. mysqli_connect_error());
            }

            $qty = filter_input(INPUT_POST, 'qty');
            $users_id = filter_input(INPUT_POST, 'users_id');
            $txt7 = filter_input(INPUT_POST, 'items_id');

            $sql = "SELECT * from items where items_id='$txt7'";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);

            if($resultCheck == 0) {
                die("<div class='error'>Invalid ID</div>");
            }

            if($resultCheck > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $items_id = $row['items_id'];
                    $name = $row['name'];
                    $price = $row['price'];
                    $stock = $row['stock'];
                }
            }

            if($qty > $stock) {
                die("<div class='error'>Insufficient Stock!</div>");
            }

            $total = $price * $qty;
            ?>

            <div class="order-summary">
                <div class="summary-row">
                    <span>product</span>
                    <span><?php echo $name; ?></span>
                </div>
                <div class="summary-row">
                    <span>price per item</span>
                    <span>₹<?php echo number_format($price, 2); ?></span>
                </div>
                <div class="summary-row">
                    <span>Quantity</span>
                    <span><?php echo $qty; ?></span>
                </div>
                <div class="summary-row">
                    <span>Total amount</span>
                    <span>₹<?php echo number_format($total, 2); ?></span>
                </div>
            </div>

            <form action="sale_connection.php" method="post" class="payment-form">
                <input type="hidden" name="users_id" value="<?php echo $users_id; ?>">
                <input type="hidden" name="items_id" value="<?php echo $items_id; ?>">
                <input type="hidden" name="price" value="<?php echo $price; ?>">
                <input type="hidden" name="qty" value="<?php echo $qty; ?>">
                <input type="hidden" name="total" value="<?php echo $total; ?>">

                <div class="form-group">
                    <label class="form-label">payment type</label>
                    <select name="payment_method" class="form-input" required onchange="togglePaymentFields(this.value)">
                        <option value="" selected disabled>Select Card Type</option>
                        <option value="card">Card Payment</option>
                        <option value="cod">Cash on Delivery</option>
                    </select>
                </div>

                <div id="card-payment-fields">
                    <div class="form-group">
                        <label class="form-label">Card Type</label>
                        <select name="card_type" class="form-input">
                            <option value="" selected disabled>Name of Card</option>
                            <option value="Debit Card">debit Card</option>
                            <option value="Credit Card">Credit Card</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Bank Name</label>
                        <input type="text" name="card_name" class="form-input" 
                               pattern="[A-Za-z\s]+" placeholder="Card Holder Name">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Card Number</label>
                        <input type="text" name="card" class="form-input" 
                               pattern="[0-9]+" minlength="16" maxlength="16" 
                               placeholder="1234 5678 9012 3456">
                    </div>

                    <div class="card-row">
                        <div class="form-group">
                            <label class="form-label">Expiry Date/label>
                            <input type="month" name="valid" class="form-input" 
                                   min="2024-02" max="2030-12">
                        </div>

                        <div class="form-group">
                            <label class="form-label">CVV</label>
                            <input type="password" name="cvv" class="form-input" 
                                   pattern="[0-9]+" minlength="3" maxlength="3" 
                                   placeholder="123">
                        </div>
                    </div>
                </div>

                <div id="cod-fields" style="display: none;">
                    <div class="form-group">
                        <label class="form-label">Delivery Address</label>
                        <textarea name="delivery_address" class="form-input" rows="3" 
                                placeholder="Enter your full delivery address"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Mobile Number</label>
                        <input type="tel" name="contact_number" class="form-input" 
                               pattern="[0-9]+" minlength="10" maxlength="10" 
                               placeholder="Enter your mobile number">
                    </div>
                </div>

                <button type="submit" class="submit-btn" id="payment-button">
                    <i class="fas fa-lock"></i> ₹<?php echo number_format($total, 2); ?> Pay
                </button>
            </form>
        </div>
    </div>

    <div class="payment-overlay">
        <div class="payment-success">
            <div class="processing-animation"></div>
            <div class="success-icon" style="display: none;">
                <i class="fas fa-check"></i>
            </div>
            <h3 class="success-title">Processing Payment...</h3>
            <p class="success-message">Please wait while we process your payment</p>
        </div>
    </div>

    <script>
    function togglePaymentFields(paymentMethod) {
        const cardFields = document.getElementById('card-payment-fields');
        const codFields = document.getElementById('cod-fields');
        const payButton = document.getElementById('payment-button');
        
        if (paymentMethod === 'card') {
            cardFields.style.display = 'block';
            codFields.style.display = 'none';
            payButton.innerHTML = '<i class="fas fa-lock"></i> ₹<?php echo number_format($total, 2); ?> ચૂકવો';
            // Make card fields required
            document.querySelectorAll('#card-payment-fields input, #card-payment-fields select').forEach(input => {
                input.required = true;
            });
            // Make COD fields not required
            document.querySelectorAll('#cod-fields input, #cod-fields textarea').forEach(input => {
                input.required = false;
            });
        } else if (paymentMethod === 'cod') {
            cardFields.style.display = 'none';
            codFields.style.display = 'block';
            payButton.innerHTML = '<i class="fas fa-truck"></i>Pay Order(Cash on delivery)';
            // Make card fields not required
            document.querySelectorAll('#card-payment-fields input, #card-payment-fields select').forEach(input => {
                input.required = false;
            });
            // Make COD fields required
            document.querySelectorAll('#cod-fields input, #cod-fields textarea').forEach(input => {
                input.required = true;
            });
        }
    }

    document.querySelector('.payment-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const overlay = document.querySelector('.payment-overlay');
        const processingAnimation = document.querySelector('.processing-animation');
        const successIcon = document.querySelector('.success-icon');
        const successTitle = document.querySelector('.success-title');
        const successMessage = document.querySelector('.success-message');
        const paymentMethod = form.payment_method.value;

        // Show overlay with processing animation
        overlay.style.display = 'flex';

        if (paymentMethod === 'cod') {
            // For COD, show different messages
            successTitle.textContent = 'Processing Payment...';
            successMessage.textContent = 'Please wait while we process your payment';
            
            setTimeout(() => {
                processingAnimation.style.display = 'none';
                successIcon.style.display = 'flex';
                
                setTimeout(() => {
                    form.submit();
                }, 2000);
            }, 2000);
        } else {
            // For card payment, show original messages
            setTimeout(() => {
                processingAnimation.style.display = 'none';
                successIcon.style.display = 'flex';
                
                successTitle.textContent = 'Payment Successful!';
                successMessage.textContent = 'Your order has been placed successfully.';

                setTimeout(() => {
                    form.submit();
                }, 2000);
            }, 3000);
        }
    });
    </script>
</body>
</html>

