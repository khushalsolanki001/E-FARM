/**
 * Solana Devnet Payment Integration for E-FARM
 * 
 * This script provides complete Solana wallet integration for your e-farm website.
 * Features:
 * - Phantom wallet detection and connection
 * - SOL/USD price fetching
 * - Transaction creation and confirmation
 * - Error handling for all scenarios
 * 
 * Usage: Include this script in your payment page and call initializeSolanaPayment()
 */

class SolanaPayment {
    constructor() {
        this.wallet = null;
        this.connection = null;
        this.isConnected = false;
        this.solPrice = 0;
        this.merchantWallet = 'AWgfH77xHcoegXMHo8W8hj54iea84qXYFAZUUvVQCYCp'; // Replace with your devnet wallet
        this.backendUrl = 'http://localhost/E-FARM/solana-backend-php'; // Your PHP backend URL
        
        // Initialize Solana connection (devnet)
        this.initializeConnection();
    }

    /**
     * Initialize Solana connection to devnet
     */
    initializeConnection() {
        try {
            // Check if Solana web3 is available
            if (typeof window.solana !== 'undefined') {
                this.wallet = window.solana;
                console.log('Phantom wallet detected');
            } else {
                console.warn('Phantom wallet not detected');
            }

            // Initialize connection to Solana devnet
            if (typeof window.solanaWeb3 !== 'undefined') {
                this.connection = new window.solanaWeb3.Connection(
                    'https://api.devnet.solana.com',
                    'confirmed'
                );
                console.log('Connected to Solana devnet');
            } else {
                console.error('Solana Web3 library not loaded');
            }
        } catch (error) {
            console.error('Error initializing Solana connection:', error);
        }
    }

    /**
     * Check if Phantom wallet is installed
     */
    isPhantomInstalled() {
        return typeof window.solana !== 'undefined' && window.solana.isPhantom;
    }

    /**
     * Connect to Phantom wallet
     */
    async connectWallet() {
        try {
            if (!this.isPhantomInstalled()) {
                throw new Error('Phantom wallet not installed. Please install Phantom wallet to continue.');
            }

            // Request connection
            const response = await this.wallet.connect();
            this.isConnected = true;
            
            console.log('Connected to wallet:', response.publicKey.toString());
            return {
                success: true,
                publicKey: response.publicKey.toString(),
                message: 'Wallet connected successfully'
            };
        } catch (error) {
            console.error('Error connecting wallet:', error);
            return {
                success: false,
                error: error.message
            };
        }
    }

    /**
     * Disconnect wallet
     */
    async disconnectWallet() {
        try {
            if (this.wallet && this.isConnected) {
                await this.wallet.disconnect();
                this.isConnected = false;
                console.log('Wallet disconnected');
            }
        } catch (error) {
            console.error('Error disconnecting wallet:', error);
        }
    }

    /**
     * Fetch current SOL/USD price from CoinGecko
     */
    async fetchSolPrice() {
        try {
            const response = await fetch('https://api.coingecko.com/api/v3/simple/price?ids=solana&vs_currencies=usd');
            const data = await response.json();
            this.solPrice = data.solana.usd;
            console.log('SOL price fetched:', this.solPrice);
            return this.solPrice;
        } catch (error) {
            console.error('Error fetching SOL price:', error);
            // Fallback to backend endpoint
            try {
                const response = await fetch(`${this.backendUrl}/sol-price.php`);
                const data = await response.json();
                this.solPrice = data.price;
                return this.solPrice;
            } catch (backendError) {
                console.error('Backend price fetch failed:', backendError);
                throw new Error('Unable to fetch SOL price');
            }
        }
    }

    /**
     * Convert USD amount to SOL
     */
    convertUsdToSol(usdAmount) {
        if (this.solPrice === 0) {
            throw new Error('SOL price not available');
        }
        return usdAmount / this.solPrice;
    }

    /**
     * Convert Indian Rupees to USD (90₹ = 1$)
     */
    convertRupeesToUsd(rupeesAmount) {
        return rupeesAmount / 90; // 90₹ = 1$
    }

    /**
     * Convert Indian Rupees to SOL
     */
    convertRupeesToSol(rupeesAmount) {
        const usdAmount = this.convertRupeesToUsd(rupeesAmount);
        return this.convertUsdToSol(usdAmount);
    }

    /**
     * Get wallet balance in SOL
     */
    async getWalletBalance() {
        try {
            if (!this.isConnected || !this.wallet.publicKey) {
                throw new Error('Wallet not connected');
            }

            const balance = await this.connection.getBalance(this.wallet.publicKey);
            return balance / window.solanaWeb3.LAMPORTS_PER_SOL;
        } catch (error) {
            console.error('Error getting wallet balance:', error);
            throw error;
        }
    }

    /**
     * Create and send SOL transaction
     */
    async sendSolPayment(rupeesAmount, orderId) {
        try {
            if (!this.isConnected) {
                throw new Error('Wallet not connected');
            }

            // Get current SOL price
            await this.fetchSolPrice();
            
            // Convert Rupees to SOL
            const solAmount = this.convertRupeesToSol(rupeesAmount);
            const usdAmount = this.convertRupeesToUsd(rupeesAmount);
            
            // Check wallet balance
            const balance = await this.getWalletBalance();
            if (balance < solAmount) {
                throw new Error(`Insufficient balance. Required: ${solAmount.toFixed(6)} SOL, Available: ${balance.toFixed(6)} SOL`);
            }

            // Create transaction
            const transaction = new window.solanaWeb3.Transaction();
            
            // Add transfer instruction
            const transferInstruction = window.solanaWeb3.SystemProgram.transfer({
                fromPubkey: this.wallet.publicKey,
                toPubkey: new window.solanaWeb3.PublicKey(this.merchantWallet),
                lamports: Math.floor(solAmount * window.solanaWeb3.LAMPORTS_PER_SOL)
            });

            transaction.add(transferInstruction);

            // Get recent blockhash
            const { blockhash } = await this.connection.getRecentBlockhash();
            transaction.recentBlockhash = blockhash;
            transaction.feePayer = this.wallet.publicKey;

            // Sign and send transaction
            const signedTransaction = await this.wallet.signTransaction(transaction);
            const signature = await this.connection.sendRawTransaction(signedTransaction.serialize());

            console.log('Transaction sent:', signature);

            // Wait for confirmation
            const confirmation = await this.connection.confirmTransaction(signature, 'confirmed');
            
            if (confirmation.value.err) {
                throw new Error('Transaction failed');
            }

            // Notify backend
            await this.notifyBackend(signature, orderId, usdAmount, solAmount, rupeesAmount);

            return {
                success: true,
                signature: signature,
                solAmount: solAmount,
                usdAmount: usdAmount,
                rupeesAmount: rupeesAmount
            };

        } catch (error) {
            console.error('Error sending SOL payment:', error);
            return {
                success: false,
                error: error.message
            };
        }
    }

    /**
     * Notify backend about successful transaction
     */
    async notifyBackend(signature, orderId, usdAmount, solAmount, rupeesAmount) {
        try {
            const response = await fetch(`${this.backendUrl}/verify-transaction.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    signature: signature,
                    orderId: orderId,
                    usdAmount: usdAmount,
                    solAmount: solAmount,
                    rupeesAmount: rupeesAmount,
                    timestamp: new Date().toISOString()
                })
            });

            const result = await response.json();
            
            if (!response.ok) {
                throw new Error(result.error || 'Backend verification failed');
            }

            return result;
        } catch (error) {
            console.error('Error notifying backend:', error);
            throw error;
        }
    }

    /**
     * Get transaction status
     */
    async getTransactionStatus(signature) {
        try {
            const transaction = await this.connection.getTransaction(signature);
            return transaction;
        } catch (error) {
            console.error('Error getting transaction status:', error);
            throw error;
        }
    }
}

/**
 * UI Helper Functions
 */
class SolanaPaymentUI {
    constructor(solanaPayment) {
        this.solanaPayment = solanaPayment;
        this.isInitialized = false;
    }

    /**
     * Initialize the payment UI
     */
    initialize() {
        if (this.isInitialized) return;
        
        this.createPaymentButton();
        this.createWalletStatus();
        this.createPriceDisplay();
        this.isInitialized = true;
    }

    /**
     * Create "Pay with SOL" button
     */
    createPaymentButton() {
        const paymentContainer = document.querySelector('.payment-form');
        if (!paymentContainer) return;

        // Create SOL payment option
        const solPaymentDiv = document.createElement('div');
        solPaymentDiv.className = 'form-group';
        solPaymentDiv.innerHTML = `
            <label class="form-label">Payment Method</label>
            <div class="payment-options">
                <label class="payment-option">
                    <input type="radio" name="payment_method" value="sol" onchange="toggleSolanaPayment(this.checked)">
                    <span class="payment-option-text">
                        <i class="fas fa-coins"></i> Pay with SOL (Solana)
                    </span>
                </label>
            </div>
        `;

        // Insert before existing payment method select
        const existingSelect = paymentContainer.querySelector('select[name="payment_method"]');
        if (existingSelect) {
            existingSelect.parentNode.insertBefore(solPaymentDiv, existingSelect);
            existingSelect.style.display = 'none';
        }

        // Create SOL payment interface
        const solInterface = document.createElement('div');
        solInterface.id = 'solana-payment-interface';
        solInterface.style.display = 'none';
        solInterface.innerHTML = `
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
        `;

        paymentContainer.appendChild(solInterface);

        // Add styles
        this.addStyles();
    }

    /**
     * Add CSS styles for Solana payment interface
     */
    addStyles() {
        const style = document.createElement('style');
        style.textContent = `
            .payment-options {
                display: flex;
                flex-direction: column;
                gap: 10px;
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
        `;
        document.head.appendChild(style);
    }

    /**
     * Update wallet status display
     */
    updateWalletStatus(isConnected, publicKey = null, balance = null) {
        const connectBtn = document.getElementById('connect-wallet-btn');
        const walletInfo = document.getElementById('wallet-info');
        const walletAddress = document.querySelector('.wallet-address');
        const walletBalance = document.querySelector('.wallet-balance');

        if (isConnected && publicKey) {
            connectBtn.textContent = 'Wallet Connected';
            connectBtn.disabled = true;
            connectBtn.style.background = '#27ae60';
            
            walletInfo.style.display = 'block';
            walletAddress.textContent = `Address: ${publicKey.substring(0, 8)}...${publicKey.substring(publicKey.length - 8)}`;
            
            if (balance !== null) {
                walletBalance.textContent = `Balance: ${balance.toFixed(6)} SOL`;
            }
        } else {
            connectBtn.innerHTML = '<i class="fas fa-wallet"></i> Connect Phantom Wallet';
            connectBtn.disabled = false;
            connectBtn.style.background = 'linear-gradient(135deg, #2ecc71, #27ae60)';
            
            walletInfo.style.display = 'none';
        }
    }

    /**
     * Update price display
     */
    updatePriceDisplay(solPrice, solAmount, rupeesAmount = null) {
        const priceValue = document.getElementById('sol-price-value');
        const amountValue = document.getElementById('sol-amount-value');

        if (priceValue) {
            priceValue.textContent = `$${solPrice.toFixed(2)} (₹${(solPrice * 90).toFixed(2)})`;
        }

        if (amountValue && solAmount) {
            let displayText = `${solAmount.toFixed(6)} SOL`;
            if (rupeesAmount) {
                displayText += ` (₹${rupeesAmount.toFixed(2)})`;
            }
            amountValue.textContent = displayText;
        }
    }

    /**
     * Show error message
     */
    showError(message) {
        this.hideMessages();
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.textContent = message;
        errorDiv.style.display = 'block';
        
        const interface = document.getElementById('solana-payment-interface');
        interface.appendChild(errorDiv);
        
        setTimeout(() => {
            errorDiv.remove();
        }, 5000);
    }

    /**
     * Show success message
     */
    showSuccess(message) {
        this.hideMessages();
        const successDiv = document.createElement('div');
        successDiv.className = 'success-message';
        successDiv.textContent = message;
        successDiv.style.display = 'block';
        
        const interface = document.getElementById('solana-payment-interface');
        interface.appendChild(successDiv);
    }

    /**
     * Hide all messages
     */
    hideMessages() {
        const messages = document.querySelectorAll('.error-message, .success-message');
        messages.forEach(msg => msg.remove());
    }
}

// Global functions for HTML integration
let solanaPaymentInstance = null;
let solanaPaymentUI = null;

/**
 * Initialize Solana payment system
 */
function initializeSolanaPayment() {
    try {
        solanaPaymentInstance = new SolanaPayment();
        solanaPaymentUI = new SolanaPaymentUI(solanaPaymentInstance);
        solanaPaymentUI.initialize();
        
        // Set up event listeners
        setupEventListeners();
        
        console.log('Solana payment system initialized');
    } catch (error) {
        console.error('Error initializing Solana payment:', error);
    }
}

/**
 * Set up event listeners
 */
function setupEventListeners() {
    // Connect wallet button
    const connectBtn = document.getElementById('connect-wallet-btn');
    if (connectBtn) {
        connectBtn.addEventListener('click', handleConnectWallet);
    }

    // Pay with SOL button
    const payBtn = document.getElementById('pay-with-sol-btn');
    if (payBtn) {
        payBtn.addEventListener('click', handleSolPayment);
    }
}

/**
 * Handle wallet connection
 */
async function handleConnectWallet() {
    try {
        const result = await solanaPaymentInstance.connectWallet();
        
        if (result.success) {
            solanaPaymentUI.updateWalletStatus(true, result.publicKey);
            
            // Get wallet balance
            const balance = await solanaPaymentInstance.getWalletBalance();
            solanaPaymentUI.updateWalletStatus(true, result.publicKey, balance);
            
            // Fetch SOL price and update display
            const solPrice = await solanaPaymentInstance.fetchSolPrice();
            const totalAmount = getTotalAmount(); // Get from your existing form (in Rupees)
            const solAmount = solanaPaymentInstance.convertRupeesToSol(totalAmount);
            
            solanaPaymentUI.updatePriceDisplay(solPrice, solAmount, totalAmount);
            
            // Enable pay button
            document.getElementById('pay-with-sol-btn').disabled = false;
            
            solanaPaymentUI.showSuccess('Wallet connected successfully!');
        } else {
            solanaPaymentUI.showError(result.error);
        }
    } catch (error) {
        solanaPaymentUI.showError('Error connecting wallet: ' + error.message);
    }
}

/**
 * Handle SOL payment
 */
async function handleSolPayment() {
    try {
        const totalAmount = getTotalAmount(); // This is in Rupees
        const orderId = generateOrderId(); // Generate or get existing order ID
        
        // Disable button during payment
        const payBtn = document.getElementById('pay-with-sol-btn');
        payBtn.disabled = true;
        payBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        
        const result = await solanaPaymentInstance.sendSolPayment(totalAmount, orderId);
        
        if (result.success) {
            solanaPaymentUI.showSuccess(`Payment successful! Transaction: ${result.signature.substring(0, 8)}...`);
            
            // Redirect to success page or update order status
            setTimeout(() => {
                window.location.href = 'user_order.php'; // Your success page
            }, 2000);
        } else {
            solanaPaymentUI.showError('Payment failed: ' + result.error);
            payBtn.disabled = false;
            payBtn.innerHTML = '<i class="fas fa-coins"></i> Pay with SOL';
        }
    } catch (error) {
        solanaPaymentUI.showError('Payment error: ' + error.message);
        
        const payBtn = document.getElementById('pay-with-sol-btn');
        payBtn.disabled = false;
        payBtn.innerHTML = '<i class="fas fa-coins"></i> Pay with SOL';
    }
}

/**
 * Toggle Solana payment interface
 */
function toggleSolanaPayment(isSelected) {
    const interface = document.getElementById('solana-payment-interface');
    const existingSelect = document.querySelector('select[name="payment_method"]');
    
    if (isSelected) {
        interface.style.display = 'block';
        if (existingSelect) {
            existingSelect.style.display = 'none';
        }
    } else {
        interface.style.display = 'none';
        if (existingSelect) {
            existingSelect.style.display = 'block';
        }
    }
}

/**
 * Get total amount from your existing form
 * Modify this function to match your form structure
 */
function getTotalAmount() {
    // Try to get total from hidden input (from your sale.php)
    const totalInput = document.querySelector('input[name="total"]');
    if (totalInput) {
        return parseFloat(totalInput.value);
    }
    
    // Fallback: calculate from price and quantity
    const priceInput = document.querySelector('input[name="price"]');
    const qtyInput = document.querySelector('input[name="qty"]');
    
    if (priceInput && qtyInput) {
        return parseFloat(priceInput.value) * parseFloat(qtyInput.value);
    }
    
    // If no inputs found, return 0
    console.warn('Could not determine total amount');
    return 0;
}

/**
 * Generate order ID
 * Modify this to match your order ID generation logic
 */
function generateOrderId() {
    return 'ORDER_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
}

// Auto-initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on a payment page
    if (document.querySelector('.payment-form')) {
        initializeSolanaPayment();
    }
});

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { SolanaPayment, SolanaPaymentUI };
}
