/**
 * Logger Utility
 * 
 * Centralized logging system for the Solana backend:
 * - Multiple log levels (error, warn, info, debug)
 * - Timestamp formatting
 * - Environment-based configuration
 * - File and console output options
 */

const fs = require('fs');
const path = require('path');

class Logger {
    constructor() {
        this.logLevel = process.env.LOG_LEVEL || 'info';
        this.logDir = process.env.LOG_DIR || './logs';
        this.enableFileLogging = process.env.ENABLE_FILE_LOGGING !== 'false';
        this.enableConsoleLogging = process.env.ENABLE_CONSOLE_LOGGING !== 'false';
        
        this.levels = {
            error: 0,
            warn: 1,
            info: 2,
            debug: 3
        };

        this.colors = {
            error: '\x1b[31m', // Red
            warn: '\x1b[33m',  // Yellow
            info: '\x1b[36m',  // Cyan
            debug: '\x1b[90m', // Gray
            reset: '\x1b[0m'   // Reset
        };

        // Ensure log directory exists
        if (this.enableFileLogging) {
            this.ensureLogDirectory();
        }
    }

    /**
     * Ensure log directory exists
     */
    ensureLogDirectory() {
        try {
            if (!fs.existsSync(this.logDir)) {
                fs.mkdirSync(this.logDir, { recursive: true });
            }
        } catch (error) {
            console.error('Failed to create log directory:', error);
            this.enableFileLogging = false;
        }
    }

    /**
     * Get current timestamp
     * @returns {string} Formatted timestamp
     */
    getTimestamp() {
        return new Date().toISOString();
    }

    /**
     * Format log message
     * @param {string} level - Log level
     * @param {string} message - Log message
     * @param {Object} meta - Additional metadata
     * @returns {string} Formatted log message
     */
    formatMessage(level, message, meta = {}) {
        const timestamp = this.getTimestamp();
        const metaStr = Object.keys(meta).length > 0 ? ` ${JSON.stringify(meta)}` : '';
        return `[${timestamp}] [${level.toUpperCase()}] ${message}${metaStr}`;
    }

    /**
     * Check if log level should be logged
     * @param {string} level - Log level
     * @returns {boolean} Should log
     */
    shouldLog(level) {
        return this.levels[level] <= this.levels[this.logLevel];
    }

    /**
     * Write to log file
     * @param {string} message - Log message
     */
    writeToFile(message) {
        if (!this.enableFileLogging) return;

        try {
            const date = new Date().toISOString().split('T')[0];
            const logFile = path.join(this.logDir, `solana-backend-${date}.log`);
            
            fs.appendFileSync(logFile, message + '\n');
        } catch (error) {
            console.error('Failed to write to log file:', error);
        }
    }

    /**
     * Write to console
     * @param {string} level - Log level
     * @param {string} message - Log message
     */
    writeToConsole(level, message) {
        if (!this.enableConsoleLogging) return;

        const color = this.colors[level] || this.colors.reset;
        const reset = this.colors.reset;
        
        console.log(`${color}${message}${reset}`);
    }

    /**
     * Log message
     * @param {string} level - Log level
     * @param {string} message - Log message
     * @param {Object} meta - Additional metadata
     */
    log(level, message, meta = {}) {
        if (!this.shouldLog(level)) return;

        const formattedMessage = this.formatMessage(level, message, meta);
        
        this.writeToConsole(level, formattedMessage);
        this.writeToFile(formattedMessage);
    }

    /**
     * Log error message
     * @param {string} message - Error message
     * @param {Object|Error} meta - Error object or metadata
     */
    error(message, meta = {}) {
        if (meta instanceof Error) {
            meta = {
                message: meta.message,
                stack: meta.stack,
                name: meta.name
            };
        }
        this.log('error', message, meta);
    }

    /**
     * Log warning message
     * @param {string} message - Warning message
     * @param {Object} meta - Additional metadata
     */
    warn(message, meta = {}) {
        this.log('warn', message, meta);
    }

    /**
     * Log info message
     * @param {string} message - Info message
     * @param {Object} meta - Additional metadata
     */
    info(message, meta = {}) {
        this.log('info', message, meta);
    }

    /**
     * Log debug message
     * @param {string} message - Debug message
     * @param {Object} meta - Additional metadata
     */
    debug(message, meta = {}) {
        this.log('debug', message, meta);
    }

    /**
     * Log API request
     * @param {Object} req - Express request object
     * @param {Object} res - Express response object
     * @param {number} duration - Request duration in ms
     */
    logRequest(req, res, duration) {
        const meta = {
            method: req.method,
            url: req.url,
            statusCode: res.statusCode,
            duration: `${duration}ms`,
            userAgent: req.get('User-Agent'),
            ip: req.ip || req.connection.remoteAddress
        };

        const level = res.statusCode >= 400 ? 'warn' : 'info';
        this.log(level, `${req.method} ${req.url} - ${res.statusCode}`, meta);
    }

    /**
     * Log database operation
     * @param {string} operation - Database operation
     * @param {string} table - Table name
     * @param {Object} meta - Additional metadata
     */
    logDatabase(operation, table, meta = {}) {
        this.info(`Database ${operation} on ${table}`, meta);
    }

    /**
     * Log Solana transaction
     * @param {string} action - Transaction action
     * @param {string} signature - Transaction signature
     * @param {Object} meta - Additional metadata
     */
    logTransaction(action, signature, meta = {}) {
        this.info(`Solana transaction ${action}`, {
            signature,
            ...meta
        });
    }

    /**
     * Log payment processing
     * @param {string} action - Payment action
     * @param {string} orderId - Order ID
     * @param {Object} meta - Additional metadata
     */
    logPayment(action, orderId, meta = {}) {
        this.info(`Payment ${action}`, {
            orderId,
            ...meta
        });
    }

    /**
     * Set log level
     * @param {string} level - New log level
     */
    setLogLevel(level) {
        if (this.levels.hasOwnProperty(level)) {
            this.logLevel = level;
            this.info(`Log level changed to: ${level}`);
        } else {
            this.warn(`Invalid log level: ${level}`);
        }
    }

    /**
     * Get current log level
     * @returns {string} Current log level
     */
    getLogLevel() {
        return this.logLevel;
    }

    /**
     * Enable/disable file logging
     * @param {boolean} enable - Enable file logging
     */
    setFileLogging(enable) {
        this.enableFileLogging = enable;
        if (enable) {
            this.ensureLogDirectory();
        }
    }

    /**
     * Enable/disable console logging
     * @param {boolean} enable - Enable console logging
     */
    setConsoleLogging(enable) {
        this.enableConsoleLogging = enable;
    }

    /**
     * Get log statistics
     * @returns {Object} Log statistics
     */
    getStats() {
        return {
            logLevel: this.logLevel,
            fileLogging: this.enableFileLogging,
            consoleLogging: this.enableConsoleLogging,
            logDirectory: this.logDir
        };
    }
}

module.exports = new Logger();
