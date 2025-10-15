#!/bin/bash

# E-FARM Solana Payment Setup Script
# This script helps you set up the Solana payment system

echo "🚀 E-FARM Solana Payment Setup"
echo "================================"

# Check if Node.js is installed
if ! command -v node &> /dev/null; then
    echo "❌ Node.js is not installed. Please install Node.js first."
    echo "   Visit: https://nodejs.org/"
    exit 1
fi

echo "✅ Node.js is installed: $(node --version)"

# Check if npm is installed
if ! command -v npm &> /dev/null; then
    echo "❌ npm is not installed. Please install npm first."
    exit 1
fi

echo "✅ npm is installed: $(npm --version)"

# Navigate to backend directory
if [ ! -d "solana-backend" ]; then
    echo "❌ solana-backend directory not found!"
    echo "   Please make sure you're running this script from the E-FARM root directory."
    exit 1
fi

cd solana-backend

# Install dependencies
echo "📦 Installing backend dependencies..."
npm install

if [ $? -eq 0 ]; then
    echo "✅ Backend dependencies installed successfully"
else
    echo "❌ Failed to install backend dependencies"
    exit 1
fi

# Create .env file if it doesn't exist
if [ ! -f ".env" ]; then
    echo "📝 Creating .env file..."
    cp env.example .env
    echo "✅ .env file created from template"
    echo "⚠️  Please edit .env file with your configuration:"
    echo "   - Set your MERCHANT_WALLET_ADDRESS"
    echo "   - Configure database settings"
    echo "   - Set other environment variables as needed"
else
    echo "✅ .env file already exists"
fi

# Create logs directory
if [ ! -d "logs" ]; then
    echo "📁 Creating logs directory..."
    mkdir logs
    echo "✅ Logs directory created"
else
    echo "✅ Logs directory already exists"
fi

# Go back to root directory
cd ..

echo ""
echo "🎉 Setup completed successfully!"
echo ""
echo "Next steps:"
echo "1. Edit solana-backend/.env file with your settings"
echo "2. Start the backend server:"
echo "   cd solana-backend && npm start"
echo "3. Update your payment page to use sale_with_solana.php"
echo "4. Test the payment flow with devnet SOL"
echo ""
echo "For detailed instructions, see SOLANA_INTEGRATION_GUIDE.md"
echo ""
echo "🔗 Useful links:"
echo "   - Phantom Wallet: https://phantom.app"
echo "   - Solana Faucet: https://faucet.solana.com"
echo "   - Solana Devnet Explorer: https://explorer.solana.com/?cluster=devnet"
