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
    
    <!-- Solana Web3.js -->
    <script src="https://unpkg.com/@solana/web3.js@latest/lib/index.iife.min.js"></script>
    <script>
        // Wait for Solana Web3 to load
        window.addEventListener('load', function() {
            if (typeof window.solanaWeb3 === 'undefined') {
                console.error('Solana Web3.js failed to load');
                // Try alternative CDN
                const script = document.createElement('script');
                script.src = 'https://unpkg.com/@solana/web3.js@1.87.6/lib/index.iife.min.js';
                script.onload = function() {
                    console.log('Solana Web3.js loaded from alternative CDN');
                };
                script.onerror = function() {
                    console.error('Failed to load Solana Web3.js from alternative CDN');
                };
                document.head.appendChild(script);
            } else {
                console.log('Solana Web3.js loaded successfully');
            }
        });
    </script>
    
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

        /* Solana Payment Styles */
        .payment-options {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 20px;
        }

        .payment-option {
            display: flex;
            align-items: center;
            padding: 15px;
            border: 2px solid #eee;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .payment-option:hover {
            border-color: #2ecc71;
            background-color: #f8f9fa;
        }

        .payment-option input[type="radio"] {
            margin-right: 10px;
        }

        .payment-option-text {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
        }

        .payment-option-text i {
            color: #2ecc71;
            font-size: 1.2em;
        }

        #solana-payment-interface {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }

        .solana-wallet-section {
            margin-bottom: 20px;
        }

        .connect-wallet-btn {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .connect-wallet-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(46, 204, 113, 0.3);
        }

        .connect-wallet-btn:disabled {
            background: #95a5a6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .wallet-info {
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
        }

        .wallet-address {
            font-family: monospace;
            font-size: 14px;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .wallet-balance {
            color: #27ae60;
            font-weight: 600;
        }

        .solana-price-section {
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .price-display, .amount-display {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .price-label, .amount-label {
            font-weight: 500;
            color: #2c3e50;
        }

        #sol-price-value, #sol-amount-value {
            font-weight: 600;
            color: #27ae60;
        }

        .pay-sol-btn {
            width: 100%;
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .pay-sol-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
        }

        .pay-sol-btn:disabled {
            background: #95a5a6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .error-message {
            background: #e74c3c;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            display: none;
        }

        .success-message {
            background: #27ae60;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            display: none;
        }

        /* Payment Overlay */
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

        @media (max-width: 768px) {
            .card-row {
                grid-template-columns: 1fr;
            }

            .payment-container {
                margin: 20px;
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
                <p>Complete your purchase securely</p>
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
                    <span>Product</span>
                    <span><?php echo $name; ?></span>
                </div>
                <div class="summary-row">
                    <span>Price per item</span>
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

            <form action="sale_connection.php" method="post" class="payment-form" id="payment-form">
                <input type="hidden" name="users_id" value="<?php echo $users_id; ?>">
                <input type="hidden" name="items_id" value="<?php echo $items_id; ?>">
                <input type="hidden" name="price" value="<?php echo $price; ?>">
                <input type="hidden" name="qty" value="<?php echo $qty; ?>">
                <input type="hidden" name="total" value="<?php echo $total; ?>">

                <!-- Payment Method Selection -->
                <div class="form-group">
                    <label class="form-label">Payment Method</label>
                    <div class="payment-options">
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="sol" onchange="toggleSolanaPayment(this.checked)">
                            <span class="payment-option-text">
                                <i class="fas fa-coins"></i> Pay with SOL (Solana)
                            </span>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="card" onchange="toggleSolanaPayment(false)">
                            <span class="payment-option-text">
                                <i class="fas fa-credit-card"></i> Card Payment
                            </span>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="cod" onchange="toggleSolanaPayment(false)">
                            <span class="payment-option-text">
                                <i class="fas fa-truck"></i> Cash on Delivery
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Solana Payment Interface -->
                <div id="solana-payment-interface" style="display: none;">
                    <div class="solana-wallet-section">
                        <div id="wallet-status" class="wallet-status">
                            <button id="connect-wallet-btn" class="connect-wallet-btn">
                                <i class="fas fa-wallet"></i> Connect Phantom Wallet
                            </button>
                        </div>
                        <div id="wallet-info" class="wallet-info" style="display: none;">
                            <div class="wallet-address"></div>
                            <div class="wallet-balance"></div>
                        </div>
                    </div>
                    <div class="solana-price-section">
                        <div id="sol-price-display" class="price-display">
                            <span class="price-label">SOL Price:</span>
                            <span id="sol-price-value">Loading...</span>
                        </div>
                        <div id="sol-amount-display" class="amount-display">
                            <span class="amount-label">Amount to pay:</span>
                            <span id="sol-amount-value">-</span>
                        </div>
                    </div>
                    <div class="solana-actions">
                        <button id="pay-with-sol-btn" class="pay-sol-btn" disabled>
                            <i class="fas fa-coins"></i> Pay with SOL
                        </button>
                    </div>
                </div>

                <!-- Traditional Payment Fields -->
                <div id="traditional-payment-fields">
                    <div class="form-group">
                        <label class="form-label">Card Type</label>
                        <select name="card_type" class="form-input">
                            <option value="" selected disabled>Name of Card</option>
                            <option value="Debit Card">Debit Card</option>
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
                            <label class="form-label">Expiry Date</label>
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

    <!-- Include Solana Payment Script -->
    <script src="../solana-payment.js"></script>
    
    <script>
    // Initialize Solana payment system
    document.addEventListener('DOMContentLoaded', function() {
        // Wait for Solana Web3 to be available
        function waitForSolanaWeb3() {
            if (typeof window.solanaWeb3 !== 'undefined') {
                console.log('Solana Web3.js is ready');
                initializeSolanaPayment();
            } else {
                console.log('Waiting for Solana Web3.js to load...');
                setTimeout(waitForSolanaWeb3, 100);
            }
        }
        
        waitForSolanaWeb3();
    });

    function toggleSolanaPayment(isSolanaSelected) {
        const solanaInterface = document.getElementById('solana-payment-interface');
        const traditionalFields = document.getElementById('traditional-payment-fields');
        const codFields = document.getElementById('cod-fields');
        const payButton = document.getElementById('payment-button');
        
        if (isSolanaSelected) {
            solanaInterface.style.display = 'block';
            traditionalFields.style.display = 'none';
            codFields.style.display = 'none';
            payButton.style.display = 'none'; // Hide traditional pay button
        } else {
            solanaInterface.style.display = 'none';
            traditionalFields.style.display = 'block';
            payButton.style.display = 'block'; // Show traditional pay button
            
            // Show COD fields if COD is selected
            const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
            if (selectedMethod && selectedMethod.value === 'cod') {
                codFields.style.display = 'block';
                traditionalFields.style.display = 'none';
            }
        }
    }

    // Handle traditional form submission
    document.getElementById('payment-form').addEventListener('submit', function(e) {
        const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
        
        // If Solana is selected, prevent default submission
        if (selectedMethod && selectedMethod.value === 'sol') {
            e.preventDefault();
            return false;
        }
        
        // For traditional payments, show processing overlay
        const overlay = document.querySelector('.payment-overlay');
        const processingAnimation = document.querySelector('.processing-animation');
        const successIcon = document.querySelector('.success-icon');
        const successTitle = document.querySelector('.success-title');
        const successMessage = document.querySelector('.success-message');
        const paymentMethod = selectedMethod ? selectedMethod.value : 'card';

        overlay.style.display = 'flex';

        if (paymentMethod === 'cod') {
            successTitle.textContent = 'Processing Order...';
            successMessage.textContent = 'Please wait while we process your order';
            
            setTimeout(() => {
                processingAnimation.style.display = 'none';
                successIcon.style.display = 'flex';
                
                setTimeout(() => {
                    this.submit();
                }, 2000);
            }, 2000);
        } else {
            setTimeout(() => {
                processingAnimation.style.display = 'none';
                successIcon.style.display = 'flex';
                
                successTitle.textContent = 'Payment Successful!';
                successMessage.textContent = 'Your order has been placed successfully.';

                setTimeout(() => {
                    this.submit();
                }, 2000);
            }, 3000);
        }
    });
    </script>
</body>
</html>
