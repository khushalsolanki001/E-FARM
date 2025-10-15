/**
 * E-FARM Solana Setup Test Script
 * 
 * This script tests if your Solana payment system is properly configured
 */

const axios = require('axios');
const { Connection } = require('@solana/web3.js');

async function testSolanaSetup() {
    console.log('🧪 Testing E-FARM Solana Payment Setup');
    console.log('=====================================\n');

    let allTestsPassed = true;

    // Test 1: Backend server connectivity
    console.log('1. Testing backend server connectivity...');
    try {
        const response = await axios.get('http://localhost:3000/health', { timeout: 5000 });
        if (response.status === 200) {
            console.log('✅ Backend server is running');
        } else {
            console.log('❌ Backend server returned unexpected status:', response.status);
            allTestsPassed = false;
        }
    } catch (error) {
        console.log('❌ Backend server is not running or not accessible');
        console.log('   Make sure to start the server with: cd solana-backend && npm start');
        allTestsPassed = false;
    }

    // Test 2: SOL price API
    console.log('\n2. Testing SOL price API...');
    try {
        const response = await axios.get('http://localhost:3000/api/sol-price', { timeout: 10000 });
        if (response.status === 200 && response.data.success) {
            console.log('✅ SOL price API working - Current price: $' + response.data.price);
        } else {
            console.log('❌ SOL price API returned unexpected response');
            allTestsPassed = false;
        }
    } catch (error) {
        console.log('❌ SOL price API failed:', error.message);
        allTestsPassed = false;
    }

    // Test 3: Solana devnet connection
    console.log('\n3. Testing Solana devnet connection...');
    try {
        const connection = new Connection('https://api.devnet.solana.com', 'confirmed');
        const version = await connection.getVersion();
        console.log('✅ Solana devnet connection successful');
        console.log('   Solana version:', version['solana-core']);
    } catch (error) {
        console.log('❌ Solana devnet connection failed:', error.message);
        allTestsPassed = false;
    }

    // Test 4: Environment variables
    console.log('\n4. Testing environment variables...');
    const requiredEnvVars = [
        'DB_HOST',
        'DB_USER', 
        'DB_NAME',
        'SOLANA_NETWORK'
    ];

    const missingVars = [];
    requiredEnvVars.forEach(varName => {
        if (!process.env[varName]) {
            missingVars.push(varName);
        }
    });

    if (missingVars.length === 0) {
        console.log('✅ All required environment variables are set');
    } else {
        console.log('❌ Missing environment variables:', missingVars.join(', '));
        console.log('   Please check your .env file');
        allTestsPassed = false;
    }

    // Test 5: Database connection (if available)
    console.log('\n5. Testing database connection...');
    try {
        const mysql = require('mysql2/promise');
        const connection = await mysql.createConnection({
            host: process.env.DB_HOST || '127.0.0.1',
            user: process.env.DB_USER || 'root',
            password: process.env.DB_PASSWORD || '',
            database: process.env.DB_NAME || 'alb'
        });
        
        await connection.ping();
        await connection.end();
        console.log('✅ Database connection successful');
    } catch (error) {
        console.log('❌ Database connection failed:', error.message);
        console.log('   Make sure MySQL is running and credentials are correct');
        allTestsPassed = false;
    }

    // Summary
    console.log('\n' + '='.repeat(50));
    if (allTestsPassed) {
        console.log('🎉 All tests passed! Your Solana payment system is ready.');
        console.log('\nNext steps:');
        console.log('1. Install Phantom wallet browser extension');
        console.log('2. Get devnet SOL from https://faucet.solana.com');
        console.log('3. Test payments on your website');
    } else {
        console.log('❌ Some tests failed. Please fix the issues above.');
        console.log('\nTroubleshooting:');
        console.log('1. Make sure the backend server is running');
        console.log('2. Check your .env file configuration');
        console.log('3. Verify MySQL is running');
        console.log('4. Check your internet connection');
    }
    console.log('='.repeat(50));
}

// Run the test
testSolanaSetup().catch(console.error);
