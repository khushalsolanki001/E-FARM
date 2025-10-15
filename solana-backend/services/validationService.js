/**
 * Validation Service
 * 
 * Handles input validation for all API endpoints:
 * - Request data validation
 * - Solana address validation
 * - Transaction signature validation
 * - Order data validation
 */

const Joi = require('joi');
const logger = require('../utils/logger');

class ValidationService {
    constructor() {
        this.solanaAddressRegex = /^[1-9A-HJ-NP-Za-km-z]{32,44}$/;
        this.transactionSignatureRegex = /^[1-9A-HJ-NP-Za-km-z]{87,88}$/;
    }

    /**
     * Validate transaction verification request
     * @param {Object} data - Request data
     * @returns {Object} Validation result
     */
    validateTransactionRequest(data) {
        const schema = Joi.object({
            signature: Joi.string()
                .pattern(this.transactionSignatureRegex)
                .required()
                .messages({
                    'string.pattern.base': 'Invalid transaction signature format',
                    'any.required': 'Transaction signature is required'
                }),
            orderId: Joi.string()
                .min(1)
                .max(255)
                .required()
                .messages({
                    'string.min': 'Order ID cannot be empty',
                    'string.max': 'Order ID is too long',
                    'any.required': 'Order ID is required'
                }),
            usdAmount: Joi.number()
                .positive()
                .precision(2)
                .required()
                .messages({
                    'number.positive': 'USD amount must be positive',
                    'number.precision': 'USD amount can have maximum 2 decimal places',
                    'any.required': 'USD amount is required'
                }),
            solAmount: Joi.number()
                .positive()
                .precision(9)
                .required()
                .messages({
                    'number.positive': 'SOL amount must be positive',
                    'number.precision': 'SOL amount can have maximum 9 decimal places',
                    'any.required': 'SOL amount is required'
                }),
            timestamp: Joi.string()
                .isoDate()
                .required()
                .messages({
                    'string.isoDate': 'Timestamp must be a valid ISO date',
                    'any.required': 'Timestamp is required'
                })
        });

        const { error, value } = schema.validate(data, { abortEarly: false });

        if (error) {
            const errors = error.details.map(detail => ({
                field: detail.path.join('.'),
                message: detail.message
            }));

            logger.warn('Transaction request validation failed:', errors);
            
            return {
                isValid: false,
                errors: errors,
                data: null
            };
        }

        return {
            isValid: true,
            errors: [],
            data: value
        };
    }

    /**
     * Validate Solana address
     * @param {string} address - Solana address
     * @returns {boolean} Is valid address
     */
    validateSolanaAddress(address) {
        if (!address || typeof address !== 'string') {
            return false;
        }

        return this.solanaAddressRegex.test(address);
    }

    /**
     * Validate transaction signature
     * @param {string} signature - Transaction signature
     * @returns {boolean} Is valid signature
     */
    validateTransactionSignature(signature) {
        if (!signature || typeof signature !== 'string') {
            return false;
        }

        return this.transactionSignatureRegex.test(signature);
    }

    /**
     * Validate order ID
     * @param {string} orderId - Order ID
     * @returns {Object} Validation result
     */
    validateOrderId(orderId) {
        const schema = Joi.string()
            .min(1)
            .max(255)
            .pattern(/^[a-zA-Z0-9_-]+$/)
            .required();

        const { error } = schema.validate(orderId);

        if (error) {
            return {
                isValid: false,
                error: error.details[0].message
            };
        }

        return {
            isValid: true,
            error: null
        };
    }

    /**
     * Validate payment amount
     * @param {number} amount - Payment amount
     * @param {string} currency - Currency (USD or SOL)
     * @returns {Object} Validation result
     */
    validatePaymentAmount(amount, currency = 'USD') {
        const schema = Joi.number()
            .positive()
            .precision(currency === 'USD' ? 2 : 9)
            .max(currency === 'USD' ? 1000000 : 10000) // Max $1M or 10K SOL
            .required();

        const { error } = schema.validate(amount);

        if (error) {
            return {
                isValid: false,
                error: error.details[0].message
            };
        }

        return {
            isValid: true,
            error: null
        };
    }

    /**
     * Validate webhook payload
     * @param {Object} payload - Webhook payload
     * @returns {Object} Validation result
     */
    validateWebhookPayload(payload) {
        const schema = Joi.object({
            signature: Joi.string()
                .pattern(this.transactionSignatureRegex)
                .required(),
            status: Joi.string()
                .valid('pending', 'confirmed', 'failed')
                .required(),
            amount: Joi.number()
                .positive()
                .optional(),
            timestamp: Joi.string()
                .isoDate()
                .optional()
        });

        const { error, value } = schema.validate(payload, { abortEarly: false });

        if (error) {
            const errors = error.details.map(detail => ({
                field: detail.path.join('.'),
                message: detail.message
            }));

            return {
                isValid: false,
                errors: errors,
                data: null
            };
        }

        return {
            isValid: true,
            errors: [],
            data: value
        };
    }

    /**
     * Validate user ID
     * @param {string|number} userId - User ID
     * @returns {Object} Validation result
     */
    validateUserId(userId) {
        const schema = Joi.alternatives()
            .try(
                Joi.string().pattern(/^\d+$/),
                Joi.number().integer().positive()
            )
            .required();

        const { error } = schema.validate(userId);

        if (error) {
            return {
                isValid: false,
                error: 'Invalid user ID format'
            };
        }

        return {
            isValid: true,
            error: null
        };
    }

    /**
     * Sanitize input string
     * @param {string} input - Input string
     * @returns {string} Sanitized string
     */
    sanitizeString(input) {
        if (typeof input !== 'string') {
            return '';
        }

        return input
            .trim()
            .replace(/[<>]/g, '') // Remove potential HTML tags
            .substring(0, 1000); // Limit length
    }

    /**
     * Validate and sanitize search parameters
     * @param {Object} params - Search parameters
     * @returns {Object} Validation result
     */
    validateSearchParams(params) {
        const schema = Joi.object({
            query: Joi.string()
                .max(100)
                .optional(),
            limit: Joi.number()
                .integer()
                .min(1)
                .max(100)
                .default(50),
            offset: Joi.number()
                .integer()
                .min(0)
                .default(0),
            sortBy: Joi.string()
                .valid('created_at', 'amount', 'status')
                .default('created_at'),
            sortOrder: Joi.string()
                .valid('asc', 'desc')
                .default('desc')
        });

        const { error, value } = schema.validate(params, { abortEarly: false });

        if (error) {
            const errors = error.details.map(detail => ({
                field: detail.path.join('.'),
                message: detail.message
            }));

            return {
                isValid: false,
                errors: errors,
                data: null
            };
        }

        return {
            isValid: true,
            errors: [],
            data: value
        };
    }

    /**
     * Validate API key
     * @param {string} apiKey - API key
     * @returns {boolean} Is valid API key
     */
    validateApiKey(apiKey) {
        if (!apiKey || typeof apiKey !== 'string') {
            return false;
        }

        // Basic API key validation (you can enhance this)
        return apiKey.length >= 32 && /^[a-zA-Z0-9_-]+$/.test(apiKey);
    }

    /**
     * Validate rate limit parameters
     * @param {Object} params - Rate limit parameters
     * @returns {Object} Validation result
     */
    validateRateLimitParams(params) {
        const schema = Joi.object({
            windowMs: Joi.number()
                .integer()
                .min(1000)
                .max(3600000) // Max 1 hour
                .default(900000), // 15 minutes
            maxRequests: Joi.number()
                .integer()
                .min(1)
                .max(10000)
                .default(100)
        });

        const { error, value } = schema.validate(params, { abortEarly: false });

        if (error) {
            return {
                isValid: false,
                error: error.details[0].message
            };
        }

        return {
            isValid: true,
            error: null,
            data: value
        };
    }
}

module.exports = new ValidationService();
