/**
 * Database Service
 * 
 * Handles all database operations for the E-FARM system:
 * - Order management
 * - Payment tracking
 * - Transaction logging
 * - User data management
 */

const mysql = require('mysql2/promise');
const logger = require('../utils/logger');

class DatabaseService {
    constructor() {
        this.config = {
            host: process.env.DB_HOST || '127.0.0.1',
            user: process.env.DB_USER || 'root',
            password: process.env.DB_PASSWORD || '',
            database: process.env.DB_NAME || 'alb',
            port: process.env.DB_PORT || 3306,
            waitForConnections: true,
            connectionLimit: 10,
            queueLimit: 0,
            acquireTimeout: 60000,
            timeout: 60000,
            reconnect: true
        };
        
        this.pool = null;
        this.initializePool();
    }

    /**
     * Initialize database connection pool
     */
    async initializePool() {
        try {
            this.pool = mysql.createPool(this.config);
            
            // Test connection
            const connection = await this.pool.getConnection();
            await connection.ping();
            connection.release();
            
            logger.info('Database connection pool initialized successfully');
        } catch (error) {
            logger.error('Error initializing database pool:', error);
            throw error;
        }
    }

    /**
     * Get database connection from pool
     * @returns {Promise<Connection>} Database connection
     */
    async getConnection() {
        try {
            if (!this.pool) {
                await this.initializePool();
            }
            return await this.pool.getConnection();
        } catch (error) {
            logger.error('Error getting database connection:', error);
            throw error;
        }
    }

    /**
     * Update order status with payment information
     * @param {string} orderId - Order ID
     * @param {Object} paymentData - Payment data
     * @returns {Promise<Object>} Update result
     */
    async updateOrderStatus(orderId, paymentData) {
        const connection = await this.getConnection();
        
        try {
            await connection.beginTransaction();

            // First, check if the order exists
            const [orderRows] = await connection.execute(
                'SELECT * FROM sales WHERE users_id = ? OR items_id = ? LIMIT 1',
                [orderId, orderId]
            );

            if (orderRows.length === 0) {
                throw new Error('Order not found');
            }

            const order = orderRows[0];

            // Update the sales table with payment information
            const updateQuery = `
                UPDATE sales 
                SET payment_type = ?, 
                    payment_status = ?, 
                    transaction_signature = ?, 
                    sol_amount = ?, 
                    usd_amount = ?, 
                    payment_timestamp = ?,
                    status = 1
                WHERE users_id = ? AND items_id = ?
            `;

            const [result] = await connection.execute(updateQuery, [
                paymentData.payment_method || 'sol',
                paymentData.payment_status || 'completed',
                paymentData.transaction_signature,
                paymentData.sol_amount,
                paymentData.usd_amount,
                paymentData.payment_timestamp,
                order.users_id,
                order.items_id
            ]);

            // Insert payment record into a separate payments table (if it exists)
            await this.insertPaymentRecord(connection, {
                order_id: orderId,
                ...paymentData,
                order_users_id: order.users_id,
                order_items_id: order.items_id
            });

            await connection.commit();

            logger.info('Order status updated successfully:', {
                orderId,
                paymentMethod: paymentData.payment_method,
                transactionSignature: paymentData.transaction_signature
            });

            return {
                success: true,
                message: 'Order status updated successfully',
                affectedRows: result.affectedRows
            };

        } catch (error) {
            await connection.rollback();
            logger.error('Error updating order status:', error);
            return {
                success: false,
                error: error.message
            };
        } finally {
            connection.release();
        }
    }

    /**
     * Insert payment record
     * @param {Connection} connection - Database connection
     * @param {Object} paymentData - Payment data
     */
    async insertPaymentRecord(connection, paymentData) {
        try {
            // Check if payments table exists, if not create it
            await this.ensurePaymentsTable(connection);

            const insertQuery = `
                INSERT INTO payments (
                    order_id, order_users_id, order_items_id, payment_method, 
                    payment_status, transaction_signature, sol_amount, usd_amount, 
                    payment_timestamp, created_at
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
            `;

            await connection.execute(insertQuery, [
                paymentData.order_id,
                paymentData.order_users_id,
                paymentData.order_items_id,
                paymentData.payment_method,
                paymentData.payment_status,
                paymentData.transaction_signature,
                paymentData.sol_amount,
                paymentData.usd_amount,
                paymentData.payment_timestamp
            ]);

            logger.info('Payment record inserted successfully');
        } catch (error) {
            logger.warn('Could not insert payment record:', error.message);
            // Don't throw error as this is not critical
        }
    }

    /**
     * Ensure payments table exists
     * @param {Connection} connection - Database connection
     */
    async ensurePaymentsTable(connection) {
        try {
            const createTableQuery = `
                CREATE TABLE IF NOT EXISTS payments (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    order_id VARCHAR(255) NOT NULL,
                    order_users_id INT,
                    order_items_id INT,
                    payment_method VARCHAR(50) NOT NULL,
                    payment_status VARCHAR(50) NOT NULL,
                    transaction_signature VARCHAR(255),
                    sol_amount DECIMAL(20, 9),
                    usd_amount DECIMAL(10, 2),
                    payment_timestamp TIMESTAMP,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    INDEX idx_order_id (order_id),
                    INDEX idx_transaction_signature (transaction_signature),
                    INDEX idx_payment_status (payment_status)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            `;

            await connection.execute(createTableQuery);
            logger.info('Payments table ensured');
        } catch (error) {
            logger.error('Error creating payments table:', error);
            throw error;
        }
    }

    /**
     * Get order by ID
     * @param {string} orderId - Order ID
     * @returns {Promise<Object|null>} Order data
     */
    async getOrderById(orderId) {
        const connection = await this.getConnection();
        
        try {
            const [rows] = await connection.execute(
                `SELECT s.*, u.firstname, u.lastname, u.email, u.mobile, u.adr,
                        i.name as item_name, i.brand, i.description, i.price as item_price
                 FROM sales s
                 LEFT JOIN users u ON s.users_id = u.users_id
                 LEFT JOIN items i ON s.items_id = i.items_id
                 WHERE s.users_id = ? OR s.items_id = ? OR s.id = ?
                 LIMIT 1`,
                [orderId, orderId, orderId]
            );

            return rows.length > 0 ? rows[0] : null;
        } catch (error) {
            logger.error('Error getting order by ID:', error);
            throw error;
        } finally {
            connection.release();
        }
    }

    /**
     * Update order by transaction signature
     * @param {string} signature - Transaction signature
     * @param {Object} updateData - Update data
     * @returns {Promise<Object>} Update result
     */
    async updateOrderByTransaction(signature, updateData) {
        const connection = await this.getConnection();
        
        try {
            const updateQuery = `
                UPDATE sales 
                SET payment_status = ?, webhook_timestamp = ?
                WHERE transaction_signature = ?
            `;

            const [result] = await connection.execute(updateQuery, [
                updateData.payment_status,
                updateData.webhook_timestamp,
                signature
            ]);

            return {
                success: true,
                message: 'Order updated by transaction signature',
                affectedRows: result.affectedRows
            };
        } catch (error) {
            logger.error('Error updating order by transaction:', error);
            return {
                success: false,
                error: error.message
            };
        } finally {
            connection.release();
        }
    }

    /**
     * Get payment by transaction signature
     * @param {string} signature - Transaction signature
     * @returns {Promise<Object|null>} Payment data
     */
    async getPaymentBySignature(signature) {
        const connection = await this.getConnection();
        
        try {
            const [rows] = await connection.execute(
                'SELECT * FROM payments WHERE transaction_signature = ? LIMIT 1',
                [signature]
            );

            return rows.length > 0 ? rows[0] : null;
        } catch (error) {
            logger.error('Error getting payment by signature:', error);
            throw error;
        } finally {
            connection.release();
        }
    }

    /**
     * Get all payments for a user
     * @param {number} userId - User ID
     * @param {number} limit - Limit results
     * @param {number} offset - Offset for pagination
     * @returns {Promise<Array>} Payment list
     */
    async getUserPayments(userId, limit = 50, offset = 0) {
        const connection = await this.getConnection();
        
        try {
            const [rows] = await connection.execute(
                `SELECT p.*, s.total, s.qty, i.name as item_name
                 FROM payments p
                 LEFT JOIN sales s ON p.order_users_id = s.users_id AND p.order_items_id = s.items_id
                 LEFT JOIN items i ON s.items_id = i.items_id
                 WHERE p.order_users_id = ?
                 ORDER BY p.created_at DESC
                 LIMIT ? OFFSET ?`,
                [userId, limit, offset]
            );

            return rows;
        } catch (error) {
            logger.error('Error getting user payments:', error);
            throw error;
        } finally {
            connection.release();
        }
    }

    /**
     * Get payment statistics
     * @returns {Promise<Object>} Payment statistics
     */
    async getPaymentStats() {
        const connection = await this.getConnection();
        
        try {
            const [rows] = await connection.execute(`
                SELECT 
                    COUNT(*) as total_payments,
                    SUM(CASE WHEN payment_status = 'completed' THEN 1 ELSE 0 END) as completed_payments,
                    SUM(CASE WHEN payment_method = 'sol' THEN 1 ELSE 0 END) as sol_payments,
                    SUM(CASE WHEN payment_method = 'sol' AND payment_status = 'completed' THEN sol_amount ELSE 0 END) as total_sol_received,
                    SUM(CASE WHEN payment_method = 'sol' AND payment_status = 'completed' THEN usd_amount ELSE 0 END) as total_usd_received
                FROM payments
            `);

            return rows[0];
        } catch (error) {
            logger.error('Error getting payment stats:', error);
            throw error;
        } finally {
            connection.release();
        }
    }

    /**
     * Close database connection pool
     */
    async close() {
        try {
            if (this.pool) {
                await this.pool.end();
                logger.info('Database connection pool closed');
            }
        } catch (error) {
            logger.error('Error closing database pool:', error);
        }
    }
}

module.exports = new DatabaseService();
