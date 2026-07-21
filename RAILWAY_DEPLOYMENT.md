# 🚂 StitchSmart — Complete Railway Deployment Guide

StitchSmart ko **Railway (railway.app)** par deploy karne ke liye is guide mein tamam steps tafseel se diye gaye hain. Application mein **koi functionality change kiye baghair** Railway ke tamám standards (Nixpacks, environment variables, dynamic ports, database auto-seeding) ko mukammal taur par configure kar diya gaya hai!

---

## ✨ Kya Changes Ki Gayi Hain? (Summary)
1. **Dynamic Railway Environment Variables:**
   * `config/config.php` aur `config/database.php` ab Railway ke default MySQL variables (`MYSQLHOST`, `MYSQLPORT`, `MYSQLUSER`, `MYSQLPASSWORD`, `MYSQLDATABASE`) aur Railway Domains (`RAILWAY_PUBLIC_DOMAIN`, `RAILWAY_STATIC_URL`) ko automatically read karte hain.
   * Local development (XAMPP / localhost) pehlay ki tarah 100% perfectly kaam karegi kyunke defaults retain rakhe gaye hain.
2. **Automated Database Seeding (Zero Manual SQL Import!):**
   * First time jab Railway par database connect hoga aur `admin` table mojood nahi hogi, tab PHP app automatically `db/stitchsmart (2).sql` ko read karke sab tables aur seed data create kar degi.
3. **Nixpacks & Procfile Ready:**
   * **PHP Web App:** Root folder mein `router.php`, `Procfile` aur `nixpacks.toml` add kiye gaye hain taake Railway ka dynamic `$PORT` aur URL routing flawlessly chalay.
   * **Python FastAPI Chatbot:** `FYP-Chatbot/FYP-Chatbot` folder mein `Procfile` aur `nixpacks.toml` add kiye gaye hain taake uvicorn server dynamic port par run ho sake.

---

## 🛠️ Railway par Deploy Karne Ke 3 Aasan Steps

### Step 1: GitHub Repository Connect Karen
1. Apne project folder (`Stitch-Smart`) ko **GitHub** par push karen (agar pehlay se nahi kiya).
2. [Railway Dashboard](https://railway.app/dashboard) par jayein aur **"New Project"** -> **"Deploy from GitHub repo"** par click karen.

---

### Step 2: MySQL Database Add Karen
1. Apne Railway project ke andar **"New" (+ button)** -> **"Database"** -> **"Add MySQL"** par click karen.
2. Railway kuch seconds mein MySQL container ready kar dega.

---

### Step 3: Web App (PHP) aur Chatbot (Python) Services Setup Karen

Aapke project mein 2 main application components hain jo Railway par as separate services ya single project chalingi:

#### Service A: PHP Web Application (Main Store)
1. Railway project mein **"New"** -> **"GitHub Repo"** select karke wahi repository add karen.
2. Service ke **Settings** mein jayein:
   * **Root Directory:** Blank chhorein ya `/` rakhein.
3. Service ke **Variables** tab mein jayein aur **"Add Variable Reference"** par click karke MySQL database se connect karen (taake `MYSQLHOST`, `MYSQLUSER`, `MYSQLPASSWORD`, `MYSQLDATABASE` automatically inject ho jayein).
4. Mazeed yeh Variables add karen:
   * `APP_ENV=production`
   * `APP_DEBUG=false`
   * `GOOGLE_API_KEY=your_gemini_api_key_here`
   * `RAILWAY_SERVICE_FYP_CHATBOT_URL=https://your-chatbot-url.up.railway.app` *(Chatbot deploy hone ke baad iska URL yahan daal den)*
5. **Settings** -> **Networking** -> **"Generate Domain"** par click karen. Aapki web app live ho jayegi aur first request par database auto-seed ho jayega!

#### Service B: Python FastAPI Chatbot (AI Assistant)
1. Railway project mein wapas **"New"** -> **"GitHub Repo"** select karke dobara wahi repository add karen.
2. Is service ka naam **`FYP-Chatbot`** rakhein.
3. Service ke **Settings** -> **Root Directory** ko set karen:
   * **Root Directory:** `FYP-Chatbot/FYP-Chatbot`
4. Service ke **Variables** tab mein yeh Variable add karen:
   * `GOOGLE_API_KEY=your_gemini_api_key_here`
5. **Settings** -> **Networking** -> **"Generate Domain"** par click karen (e.g. `stitchsmart-chatbot.up.railway.app`).
6. Is generated domain ko **Service A (PHP Web App)** ke variables mein `RAILWAY_SERVICE_FYP_CHATBOT_URL` ya `CHATBOT_API_URL` ke taur par add kar den.

---

### Step 4: Persistent Volume Add Karen (For Images/Products)
Railway par containers refresh hote rehte hain. Jab aap admin panel se koi nayi product ya category add karte hain toh uski image delete na ho, iske liye aik Volume zaroori hai.
1. Apne **Service A (PHP Web App)** par click karen.
2. **"Volumes"** tab mein jayein.
3. **"New Volume"** par click karen.
4. Mount Path mein exact yeh path likhein: `/app/public/uploads` aur save kar den.
5. Railway khud hi app ko redeploy karega aur iske baad aapki upload ki hui har image pakki (persistent) save hogi, kabhi delete/broken nahi hogi!

---

## 🚀 Mubarak Ho!
Aapka pora **StitchSmart** project (PHP MySQL Store + RAG Chatbot) Railway par strictly unke requirements ke mutabik bina kisi functionality change ke deploy hone ke liye 100% ready hai!
