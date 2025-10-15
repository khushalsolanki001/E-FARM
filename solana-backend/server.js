/**
 * E-FARM Solana Payment Backend
 * 
 * This Node.js server provides backend services for Solana payments:
 * - SOL/USD price fetching from CoinGecko
 * - Transaction verification on Solana devnet
 * - Order status updates in MySQL database
 * - Comprehensive error handling and logging
 * 
 * Usage: npm start (production) or npm run dev (development)
 */

const express = require('express');
const cors = require('cors');
const helmet = require('helmet');
const compression = require('compression');
const morgan = require('morgan');
const rateLimit = require('express-rate-limit');
require('dotenv').config();

// Import custom modules
const solanaService = require('./services/solanaService');
const priceService = require('./services/priceService');
const databaseService = require('./services/databaseService');
const validationService = require('./services/validationService');
const logger = require('./utils/logger');

const app = express();
const PORT = process.env.PORT || 3000;

// Security middleware
app.use(helmet());
app.use(compression());

// CORS configuration
app.use(cors({
    origin: process.env.NODE_ENV === 'production' 
        ? ['https://yourdomain.com'] // Replace with your actual domain
        : ['http://localhost', 'http://127.0.0.1'],
    credentials: true
}));

// Rate limiting
const limiter = rateLimit({
    windowMs: parseInt(process.env.RATE_LIMIT_WINDOW_MS) || 15 * 60 * 1000, // 15 minutes
    max: parseInt(process.env.RATE_LIMIT_MAX_REQUESTS) || 100, // limit each IP to 100 requests per windowMs
    message: {
        error: 'Too many requests from this IP, please try again later.'
    }
});
app.use('/api/', limiter);

// Logging
app.use(morgan('combined', {
    stream: {
        write: (message) => logger.info(message.trim())
    }
}));

// Body parsing middleware
app.use(express.json({ limit: '10mb' }));
app.use(express.urlencoded({ extended: true, limit: '10mb' }));

// Health check endpoint
app.get('/health', (req, res) => {
    res.json({
        status: 'healthy',
        timestamp: new Date().toISOString(),
        version: '1.0.0',
        environment: process.env.NODE_ENV || 'development'
    });
});

// API Routes

/**
 * GET /api/sol-price
 * Fetch current SOL/USD price from CoinGecko
 */
app.get('/api/sol-price', async (req, res) => {
    try {
        logger.info('Fetching SOL price');
        
        const price = await priceService.getSolPrice();
        
        res.json({
            success: true,
            price: price,
            currency: 'USD',
            timestamp: new Date().toISOString(),
            source: 'coingecko'
        });
        
        logger.info(`SOL price fetched: $${price}`);
    } catch (error) {
        logger.error('Error fetching SOL price:', error);
        
        res.status(500).json({
            success: false,
            error: 'Failed to fetch SOL price',
            message: error.message
        });
    }
});

/**
 * POST /api/verify-transaction
 * Verify Solana transaction and update order status
 */
app.post('/api/verify-transaction', async (req, res) => {
    try {
        logger.info('Verifying transaction:', req.body);
        
        // Validate request body
        const validation = validationService.validateTransactionRequest(req.body);
        if (!validation.isValid) {
            return res.status(400).json({
                success: false,
                error: 'Invalid request data',
                details: validation.errors
            });
        }

        const { signature, orderId, usdAmount, solAmount, timestamp } = req.body;

        // Verify transaction on Solana devnet
        const transactionResult = await solanaService.verifyTransaction(signature);
        
        if (!transactionResult.success) {
            logger.error('Transaction verification failed:', transactionResult.error);
            return res.status(400).json({
                success: false,
                error: 'Transaction verification failed',
                details: transactionResult.error
            });
        }

        // Check if transaction amount matches expected amount
        const expectedLamports = Math.floor(solAmount * 1000000000); // Convert SOL to lamports
        if (transactionResult.amount !== expectedLamports) {
            logger.error('Transaction amount mismatch:', {
                expected: expectedLamports,
                actual: transactionResult.amount
            });
            return res.status(400).json({
                success: false,
                error: 'Transaction amount mismatch'
            });
        }

        // Update order status in database
        const dbResult = await databaseService.updateOrderStatus(orderId, {
            payment_method: 'sol',
            payment_status: 'completed',
            transaction_signature: signature,
            sol_amount: solAmount,
            usd_amount: usdAmount,
            payment_timestamp: timestamp
        });

        if (!dbResult.success) {
            logger.error('Database update failed:', dbResult.error);
            return res.status(500).json({
                success: false,
                error: 'Failed to update order status',
                details: dbResult.error
            });
        }

        logger.info('Transaction verified and order updated successfully:', {
            signature,
            orderId,
            amount: solAmount
        });

        res.json({
            success: true,
            message: 'Transaction verified and order updated successfully',
            transaction: {
                signature: signature,
                amount: solAmount,
                status: 'confirmed'
            },
            order: {
                id: orderId,
                status: 'paid'
            }
        });

    } catch (error) {
        logger.error('Error verifying transaction:', error);
        
        res.status(500).json({
            success: false,
            error: 'Internal server error',
            message: error.message
        });
    }
});

/**
 * GET /api/transaction-status/:signature
 * Get transaction status by signature
 */
app.get('/api/transaction-status/:signature', async (req, res) => {
    try {
        const { signature } = req.params;
        
        if (!signature || signature.length < 32) {
            return res.status(400).json({
                success: false,
                error: 'Invalid transaction signature'
            });
        }

        const status = await solanaService.getTransactionStatus(signature);
        
        res.json({
            success: true,
            signature: signature,
            status: status
        });
        
    } catch (error) {
        logger.error('Error getting transaction status:', error);
        
        res.status(500).json({
            success: false,
            error: 'Failed to get transaction status',
            message: error.message
        });
    }
});

/**
 * GET /api/orders/:orderId
 * Get order details by ID
 */
app.get('/api/orders/:orderId', async (req, res) => {
    try {
        const { orderId } = req.params;
        
        const order = await databaseService.getOrderById(orderId);
        
        if (!order) {
            return res.status(404).json({
                success: false,
                error: 'Order not found'
            });
        }

        res.json({
            success: true,
            order: order
        });
        
    } catch (error) {
        logger.error('Error getting order:', error);
        
        res.status(500).json({
            success: false,
            error: 'Failed to get order details',
            message: error.message
        });
    }
});

/**
 * POST /api/webhook/solana
 * Webhook endpoint for Solana transaction notifications (optional)
 */
app.post('/api/webhook/solana', async (req, res) => {
    try {
        logger.info('Received Solana webhook:', req.body);
        
        // Verify webhook signature if needed
        // const isValid = verifyWebhookSignature(req);
        // if (!isValid) {
        //     return res.status(401).json({ error: 'Invalid webhook signature' });
        // }

        // Process webhook data
        const { signature, status, amount } = req.body;
        
        if (status === 'confirmed') {
            // Update order status based on webhook
            await databaseService.updateOrderByTransaction(signature, {
                payment_status: 'completed',
                webhook_timestamp: new Date().toISOString()
            });
        }

        res.json({
            success: true,
            message: 'Webhook processed successfully'
        });
        
    } catch (error) {
        logger.error('Error processing webhook:', error);
        
        res.status(500).json({
            success: false,
            error: 'Failed to process webhook',
            message: error.message
        });
    }
});

// Error handling middleware
app.use((error, req, res, next) => {
    logger.error('Unhandled error:', error);
    
    res.status(500).json({
        success: false,
        error: 'Internal server error',
        message: process.env.NODE_ENV === 'development' ? error.message : 'Something went wrong'
    });
});

// 404 handler
app.use('*', (req, res) => {
    res.status(404).json({
        success: false,
        error: 'Endpoint not found',
        path: req.originalUrl
    });
});

// Graceful shutdown
process.on('SIGTERM', () => {
    logger.info('SIGTERM received, shutting down gracefully');
    process.exit(0);
});

process.on('SIGINT', () => {
    logger.info('SIGINT received, shutting down gracefully');
    process.exit(0);
});

// Start server
app.listen(PORT, () => {
    logger.info(`E-FARM Solana Backend running on port ${PORT}`);
    logger.info(`Environment: ${process.env.NODE_ENV || 'development'}`);
    logger.info(`Health check: http://localhost:${PORT}/health`);
});

module.exports = app;
