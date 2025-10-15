/**
 * Solana Service
 * 
 * Handles all Solana blockchain interactions:
 * - Transaction verification
 * - Balance checking
 * - Network status monitoring
 */

const { Connection, PublicKey, Transaction } = require('@solana/web3.js');
const logger = require('../utils/logger');

class SolanaService {
    constructor() {
        this.connection = new Connection(
            process.env.SOLANA_RPC_URL || 'https://api.devnet.solana.com',
            'confirmed'
        );
        this.network = process.env.SOLANA_NETWORK || 'devnet';
        this.merchantWallet = process.env.MERCHANT_WALLET_ADDRESS;
        
        if (!this.merchantWallet) {
            logger.warn('MERCHANT_WALLET_ADDRESS not set in environment variables');
        }
    }

    /**
     * Verify a transaction on Solana devnet
     * @param {string} signature - Transaction signature
     * @returns {Promise<Object>} Verification result
     */
    async verifyTransaction(signature) {
        try {
            logger.info(`Verifying transaction: ${signature}`);

            // Get transaction details
            const transaction = await this.connection.getTransaction(signature, {
                commitment: 'confirmed',
                maxSupportedTransactionVersion: 0
            });

            if (!transaction) {
                return {
                    success: false,
                    error: 'Transaction not found'
                };
            }

            // Check if transaction was successful
            if (transaction.meta.err) {
                return {
                    success: false,
                    error: 'Transaction failed',
                    details: transaction.meta.err
                };
            }

            // Extract transfer information
            const transferInfo = this.extractTransferInfo(transaction);
            
            if (!transferInfo) {
                return {
                    success: false,
                    error: 'No transfer found in transaction'
                };
            }

            // Verify the transfer is to our merchant wallet
            if (this.merchantWallet && transferInfo.to !== this.merchantWallet) {
                return {
                    success: false,
                    error: 'Transaction not sent to merchant wallet'
                };
            }

            logger.info('Transaction verified successfully:', {
                signature,
                amount: transferInfo.amount,
                from: transferInfo.from,
                to: transferInfo.to
            });

            return {
                success: true,
                signature: signature,
                amount: transferInfo.amount,
                from: transferInfo.from,
                to: transferInfo.to,
                blockTime: transaction.blockTime,
                slot: transaction.slot
            };

        } catch (error) {
            logger.error('Error verifying transaction:', error);
            return {
                success: false,
                error: 'Failed to verify transaction',
                details: error.message
            };
        }
    }

    /**
     * Extract transfer information from transaction
     * @param {Object} transaction - Solana transaction object
     * @returns {Object|null} Transfer information
     */
    extractTransferInfo(transaction) {
        try {
            const instructions = transaction.transaction.message.instructions;
            
            for (const instruction of instructions) {
                // Check if this is a transfer instruction
                if (instruction.programIdIndex === 0) { // System program
                    const accounts = transaction.transaction.message.accountKeys;
                    const fromAccount = accounts[instruction.accounts[0]];
                    const toAccount = accounts[instruction.accounts[1]];
                    
                    // Get the amount from the transaction logs
                    const logs = transaction.meta.logMessages;
                    const transferLog = logs.find(log => 
                        log.includes('Transfer') && log.includes('lamports')
                    );
                    
                    if (transferLog) {
                        const amountMatch = transferLog.match(/(\d+)\s+lamports/);
                        if (amountMatch) {
                            return {
                                from: fromAccount.toString(),
                                to: toAccount.toString(),
                                amount: parseInt(amountMatch[1])
                            };
                        }
                    }
                }
            }
            
            return null;
        } catch (error) {
            logger.error('Error extracting transfer info:', error);
            return null;
        }
    }

    /**
     * Get transaction status
     * @param {string} signature - Transaction signature
     * @returns {Promise<Object>} Transaction status
     */
    async getTransactionStatus(signature) {
        try {
            const transaction = await this.connection.getTransaction(signature);
            
            if (!transaction) {
                return {
                    status: 'not_found',
                    message: 'Transaction not found'
                };
            }

            if (transaction.meta.err) {
                return {
                    status: 'failed',
                    message: 'Transaction failed',
                    error: transaction.meta.err
                };
            }

            return {
                status: 'confirmed',
                message: 'Transaction confirmed',
                blockTime: transaction.blockTime,
                slot: transaction.slot,
                fee: transaction.meta.fee
            };

        } catch (error) {
            logger.error('Error getting transaction status:', error);
            return {
                status: 'error',
                message: 'Error retrieving transaction status',
                error: error.message
            };
        }
    }

    /**
     * Get account balance
     * @param {string} publicKey - Public key string
     * @returns {Promise<number>} Balance in SOL
     */
    async getAccountBalance(publicKey) {
        try {
            const pubKey = new PublicKey(publicKey);
            const balance = await this.connection.getBalance(pubKey);
            return balance / 1000000000; // Convert lamports to SOL
        } catch (error) {
            logger.error('Error getting account balance:', error);
            throw error;
        }
    }

    /**
     * Check if an address is valid
     * @param {string} address - Solana address
     * @returns {boolean} Is valid address
     */
    isValidAddress(address) {
        try {
            new PublicKey(address);
            return true;
        } catch (error) {
            return false;
        }
    }

    /**
     * Get network status
     * @returns {Promise<Object>} Network status
     */
    async getNetworkStatus() {
        try {
            const version = await this.connection.getVersion();
            const health = await this.connection.getHealth();
            const slot = await this.connection.getSlot();
            
            return {
                network: this.network,
                version: version['solana-core'],
                health: health,
                currentSlot: slot,
                rpcUrl: this.connection.rpcEndpoint
            };
        } catch (error) {
            logger.error('Error getting network status:', error);
            return {
                network: this.network,
                status: 'error',
                error: error.message
            };
        }
    }

    /**
     * Wait for transaction confirmation
     * @param {string} signature - Transaction signature
     * @param {number} timeout - Timeout in milliseconds
     * @returns {Promise<Object>} Confirmation result
     */
    async waitForConfirmation(signature, timeout = 30000) {
        try {
            const startTime = Date.now();
            
            while (Date.now() - startTime < timeout) {
                const status = await this.getTransactionStatus(signature);
                
                if (status.status === 'confirmed') {
                    return {
                        success: true,
                        status: status
                    };
                } else if (status.status === 'failed') {
                    return {
                        success: false,
                        error: 'Transaction failed',
                        status: status
                    };
                }
                
                // Wait 2 seconds before checking again
                await new Promise(resolve => setTimeout(resolve, 2000));
            }
            
            return {
                success: false,
                error: 'Transaction confirmation timeout'
            };
            
        } catch (error) {
            logger.error('Error waiting for confirmation:', error);
            return {
                success: false,
                error: error.message
            };
        }
    }
}

module.exports = new SolanaService();
