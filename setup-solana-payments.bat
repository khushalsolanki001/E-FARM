@echo off
echo 🚀 E-FARM Solana Payment Setup
echo ================================

REM Check if Node.js is installed
node --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Node.js is not installed. Please install Node.js first.
    echo    Visit: https://nodejs.org/
    pause
    exit /b 1
)

echo ✅ Node.js is installed
node --version

REM Check if npm is installed
npm --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ npm is not installed. Please install npm first.
    pause
    exit /b 1
)

echo ✅ npm is installed
npm --version

REM Navigate to backend directory
if not exist "solana-backend" (
    echo ❌ solana-backend directory not found!
    echo    Please make sure you're running this script from the E-FARM root directory.
    pause
    exit /b 1
)

cd solana-backend

REM Install dependencies
echo 📦 Installing backend dependencies...
npm install

if %errorlevel% neq 0 (
    echo ❌ Failed to install backend dependencies
    pause
    exit /b 1
)

echo ✅ Backend dependencies installed successfully

REM Create .env file if it doesn't exist
if not exist ".env" (
    echo 📝 Creating .env file...
    copy env.example .env
    echo ✅ .env file created from template
    echo ⚠️  Please edit .env file with your configuration:
    echo    - Set your MERCHANT_WALLET_ADDRESS
    echo    - Configure database settings
    echo    - Set other environment variables as needed
) else (
    echo ✅ .env file already exists
)

REM Create logs directory
if not exist "logs" (
    echo 📁 Creating logs directory...
    mkdir logs
    echo ✅ Logs directory created
) else (
    echo ✅ Logs directory already exists
)

REM Go back to root directory
cd ..

echo.
echo 🎉 Setup completed successfully!
echo.
echo Next steps:
echo 1. Edit solana-backend\.env file with your settings
echo 2. Start the backend server:
echo    cd solana-backend ^&^& npm start
echo 3. Update your payment page to use sale_with_solana.php
echo 4. Test the payment flow with devnet SOL
echo.
echo For detailed instructions, see SOLANA_INTEGRATION_GUIDE.md
echo.
echo 🔗 Useful links:
echo    - Phantom Wallet: https://phantom.app
echo    - Solana Faucet: https://faucet.solana.com
echo    - Solana Devnet Explorer: https://explorer.solana.com/?cluster=devnet

pause
