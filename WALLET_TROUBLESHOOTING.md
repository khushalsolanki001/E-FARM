# 🔧 Wallet Connection Troubleshooting Guide

## 🚨 **If Wallet is Not Connecting on Your Site**

### **Step 1: Check Debug Information**
1. Go to your payment page: `http://localhost/E-FARM/user/sale.php`
2. Select "Pay with SOL" option
3. Look at the debug information that appears below the "Connect Phantom Wallet" button
4. Check if all three items show ✅ (green) or ❌ (red)

### **Step 2: Common Issues and Solutions**

#### **❌ Solana Web3: Not loaded**
**Problem:** The Solana Web3.js library failed to load
**Solutions:**
1. **Check internet connection** - The library loads from CDN
2. **Try refreshing the page** - Sometimes CDN is slow
3. **Check browser console** for error messages (F12 → Console)
4. **Try different browser** - Some browsers block CDN resources

#### **❌ Phantom Wallet: Not detected**
**Problem:** Phantom wallet extension is not installed or not detected
**Solutions:**
1. **Install Phantom Wallet:**
   - Go to [phantom.app](https://phantom.app)
   - Click "Download" → "Chrome" or "Firefox"
   - Install the extension
   - **Restart your browser** after installation

2. **Switch to Devnet:**
   - Open Phantom wallet
   - Click the gear icon (Settings)
   - Go to "Developer Settings"
   - Change Network to "Devnet"
   - Refresh your payment page

3. **Check if extension is enabled:**
   - Go to browser extensions (chrome://extensions/)
   - Make sure Phantom is enabled
   - Try disabling and re-enabling it

#### **❌ Backend: Connection failed**
**Problem:** PHP backend is not running or not accessible
**Solutions:**
1. **Check XAMPP is running:**
   - Make sure Apache is running in XAMPP Control Panel
   - Check if port 80 is not blocked

2. **Test backend directly:**
   - Go to: `http://localhost/E-FARM/solana-backend-php/health.php`
   - Should show: `{"status":"healthy",...}`

3. **Check file permissions:**
   - Make sure PHP files are readable
   - Check if .htaccess is working

### **Step 3: Advanced Troubleshooting**

#### **Browser Console Errors**
1. **Open browser console:** Press F12 → Console tab
2. **Look for red error messages**
3. **Common errors:**
   - `CORS error` → Backend CORS issue
   - `Failed to fetch` → Network/backend issue
   - `solanaWeb3 is not defined` → Library loading issue

#### **Network Issues**
1. **Check if you can access:**
   - `https://unpkg.com/@solana/web3.js@latest/lib/index.iife.min.js`
   - `https://api.coingecko.com/api/v3/simple/price?ids=solana&vs_currencies=usd`

2. **Try different network:**
   - Switch from WiFi to mobile data
   - Try different internet connection

#### **Browser Compatibility**
- **Chrome:** ✅ Recommended
- **Firefox:** ✅ Works
- **Edge:** ✅ Works
- **Safari:** ⚠️ May have issues
- **Mobile browsers:** ❌ Not recommended

### **Step 4: Test Individual Components**

#### **Test 1: Wallet Connection Only**
- Go to: `http://localhost/E-FARM/test-wallet-connection.html`
- Click "Check Libraries"
- Click "Connect Wallet"
- This tests only wallet connection without payment

#### **Test 2: Backend Only**
- Go to: `http://localhost/E-FARM/solana-backend-php/health.php`
- Should show health status
- Go to: `http://localhost/E-FARM/solana-backend-php/sol-price.php`
- Should show SOL price

#### **Test 3: Complete Payment Flow**
- Go to: `http://localhost/E-FARM/test-solana-payment.html`
- Test all components step by step

### **Step 5: Get Devnet SOL**

If wallet connects but you need test SOL:
1. **Open Phantom wallet**
2. **Copy your wallet address**
3. **Go to:** [Solana Faucet](https://faucet.solana.com)
4. **Paste your address**
5. **Request devnet SOL** (free test tokens)

### **Step 6: Still Not Working?**

#### **Check These Files Exist:**
- ✅ `solana-payment.js` (in root directory)
- ✅ `solana-backend-php/health.php`
- ✅ `solana-backend-php/sol-price.php`
- ✅ `solana-backend-php/verify-transaction.php`

#### **Check File Permissions:**
- All PHP files should be readable
- JavaScript files should be accessible
- .htaccess should be working

#### **Check XAMPP Configuration:**
- Apache is running on port 80
- PHP is enabled
- MySQL is running (for database)

### **Step 7: Alternative Solutions**

#### **If CDN is blocked:**
1. **Download Solana Web3.js locally:**
   ```bash
   curl -o solana-web3.js https://unpkg.com/@solana/web3.js@latest/lib/index.iife.min.js
   ```
2. **Update the script tag:**
   ```html
   <script src="solana-web3.js"></script>
   ```

#### **If Phantom doesn't work:**
1. **Try other wallets:**
   - Solflare
   - Backpack
   - Glow

2. **Update wallet detection code** in `solana-payment.js`

### **Step 8: Contact Support**

If nothing works, provide this information:
1. **Browser and version**
2. **Operating system**
3. **Debug information** from the payment page
4. **Console error messages**
5. **Screenshot** of the debug section

---

## 🎯 **Quick Checklist**

- [ ] Phantom wallet installed and enabled
- [ ] Phantom set to Devnet network
- [ ] Browser refreshed after wallet installation
- [ ] XAMPP Apache running
- [ ] Internet connection working
- [ ] No browser extensions blocking scripts
- [ ] Console shows no errors
- [ ] Debug info shows all ✅ green

---

**Most Common Issue:** Phantom wallet not installed or not set to Devnet! 🔧
