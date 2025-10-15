/**
 * Price Service
 * 
 * Handles cryptocurrency price fetching from various sources:
 * - CoinGecko API (primary)
 * - Fallback mechanisms
 * - Price caching and rate limiting
 */

const axios = require('axios');
const logger = require('../utils/logger');

class PriceService {
    constructor() {
        this.coingeckoUrl = process.env.COINGECKO_API_URL || 'https://api.coingecko.com/api/v3';
        this.cache = new Map();
        this.cacheTimeout = 60000; // 1 minute cache
        this.lastFetchTime = 0;
        this.minFetchInterval = 10000; // Minimum 10 seconds between fetches
    }

    /**
     * Get current SOL price in USD
     * @returns {Promise<number>} SOL price in USD
     */
    async getSolPrice() {
        try {
            // Check cache first
            const cachedPrice = this.getCachedPrice();
            if (cachedPrice !== null) {
                logger.info('Using cached SOL price:', cachedPrice);
                return cachedPrice;
            }

            // Rate limiting check
            const now = Date.now();
            if (now - this.lastFetchTime < this.minFetchInterval) {
                logger.warn('Rate limiting: too frequent price requests');
                throw new Error('Rate limit exceeded. Please wait before requesting price again.');
            }

            logger.info('Fetching SOL price from CoinGecko');
            
            const response = await axios.get(`${this.coingeckoUrl}/simple/price`, {
                params: {
                    ids: 'solana',
                    vs_currencies: 'usd',
                    include_24hr_change: true,
                    include_last_updated_at: true
                },
                timeout: 10000, // 10 second timeout
                headers: {
                    'User-Agent': 'E-FARM-Solana-Backend/1.0.0'
                }
            });

            if (response.status !== 200) {
                throw new Error(`CoinGecko API returned status ${response.status}`);
            }

            const data = response.data;
            
            if (!data.solana || !data.solana.usd) {
                throw new Error('Invalid response format from CoinGecko');
            }

            const price = data.solana.usd;
            const change24h = data.solana.usd_24h_change;
            const lastUpdated = data.solana.last_updated_at;

            // Cache the price
            this.cachePrice(price, change24h, lastUpdated);
            
            this.lastFetchTime = now;
            
            logger.info('SOL price fetched successfully:', {
                price: price,
                change24h: change24h,
                lastUpdated: new Date(lastUpdated * 1000).toISOString()
            });

            return price;

        } catch (error) {
            logger.error('Error fetching SOL price from CoinGecko:', error);
            
            // Try fallback methods
            return await this.getFallbackPrice();
        }
    }

    /**
     * Get cached price if available and not expired
     * @returns {number|null} Cached price or null
     */
    getCachedPrice() {
        const cached = this.cache.get('sol_price');
        if (!cached) return null;

        const now = Date.now();
        if (now - cached.timestamp > this.cacheTimeout) {
            this.cache.delete('sol_price');
            return null;
        }

        return cached.price;
    }

    /**
     * Cache price data
     * @param {number} price - SOL price
     * @param {number} change24h - 24h price change
     * @param {number} lastUpdated - Last updated timestamp
     */
    cachePrice(price, change24h, lastUpdated) {
        this.cache.set('sol_price', {
            price: price,
            change24h: change24h,
            lastUpdated: lastUpdated,
            timestamp: Date.now()
        });
    }

    /**
     * Fallback price fetching methods
     * @returns {Promise<number>} SOL price
     */
    async getFallbackPrice() {
        logger.info('Attempting fallback price fetching methods');

        // Method 1: Try alternative CoinGecko endpoint
        try {
            const response = await axios.get(`${this.coingeckoUrl}/coins/solana`, {
                timeout: 5000,
                headers: {
                    'User-Agent': 'E-FARM-Solana-Backend/1.0.0'
                }
            });

            if (response.data && response.data.market_data && response.data.market_data.current_price) {
                const price = response.data.market_data.current_price.usd;
                logger.info('Fallback price fetched from alternative endpoint:', price);
                return price;
            }
        } catch (error) {
            logger.warn('Fallback method 1 failed:', error.message);
        }

        // Method 2: Use cached price if available (even if expired)
        const cached = this.cache.get('sol_price');
        if (cached) {
            logger.warn('Using expired cached price as last resort:', cached.price);
            return cached.price;
        }

        // Method 3: Return a reasonable default price
        const defaultPrice = 100; // Reasonable default for SOL
        logger.warn('All price fetching methods failed, using default price:', defaultPrice);
        return defaultPrice;
    }

    /**
     * Get multiple cryptocurrency prices
     * @param {Array<string>} coinIds - Array of coin IDs
     * @param {Array<string>} currencies - Array of currency codes
     * @returns {Promise<Object>} Prices object
     */
    async getMultiplePrices(coinIds = ['solana'], currencies = ['usd']) {
        try {
            const response = await axios.get(`${this.coingeckoUrl}/simple/price`, {
                params: {
                    ids: coinIds.join(','),
                    vs_currencies: currencies.join(','),
                    include_24hr_change: true
                },
                timeout: 10000
            });

            return response.data;
        } catch (error) {
            logger.error('Error fetching multiple prices:', error);
            throw error;
        }
    }

    /**
     * Get price history for a coin
     * @param {string} coinId - Coin ID
     * @param {number} days - Number of days
     * @returns {Promise<Array>} Price history
     */
    async getPriceHistory(coinId = 'solana', days = 7) {
        try {
            const response = await axios.get(`${this.coingeckoUrl}/coins/${coinId}/market_chart`, {
                params: {
                    vs_currency: 'usd',
                    days: days
                },
                timeout: 10000
            });

            return response.data;
        } catch (error) {
            logger.error('Error fetching price history:', error);
            throw error;
        }
    }

    /**
     * Convert USD amount to SOL
     * @param {number} usdAmount - Amount in USD
     * @returns {Promise<number>} Amount in SOL
     */
    async convertUsdToSol(usdAmount) {
        try {
            const solPrice = await this.getSolPrice();
            return usdAmount / solPrice;
        } catch (error) {
            logger.error('Error converting USD to SOL:', error);
            throw error;
        }
    }

    /**
     * Convert SOL amount to USD
     * @param {number} solAmount - Amount in SOL
     * @returns {Promise<number>} Amount in USD
     */
    async convertSolToUsd(solAmount) {
        try {
            const solPrice = await this.getSolPrice();
            return solAmount * solPrice;
        } catch (error) {
            logger.error('Error converting SOL to USD:', error);
            throw error;
        }
    }

    /**
     * Get price statistics
     * @returns {Promise<Object>} Price statistics
     */
    async getPriceStats() {
        try {
            const cached = this.cache.get('sol_price');
            if (!cached) {
                await this.getSolPrice();
                return this.getPriceStats();
            }

            return {
                currentPrice: cached.price,
                change24h: cached.change24h,
                lastUpdated: new Date(cached.lastUpdated * 1000).toISOString(),
                cacheAge: Date.now() - cached.timestamp
            };
        } catch (error) {
            logger.error('Error getting price stats:', error);
            throw error;
        }
    }

    /**
     * Clear price cache
     */
    clearCache() {
        this.cache.clear();
        logger.info('Price cache cleared');
    }

    /**
     * Set cache timeout
     * @param {number} timeout - Timeout in milliseconds
     */
    setCacheTimeout(timeout) {
        this.cacheTimeout = timeout;
        logger.info('Cache timeout updated to:', timeout);
    }
}

module.exports = new PriceService();
