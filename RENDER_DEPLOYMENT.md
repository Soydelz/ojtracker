# OJTracker - Render.com Deployment Guide

## 🚀 Quick Deploy Steps

### 1. **Push to GitHub**
```bash
git add .
git commit -m "Add Render.com configuration"
git push origin main
```

### 2. **Create Render Account**
- Go to https://render.com
- Sign up with GitHub account
- Connect your GitHub repository

### 3. **Create PostgreSQL Database**
1. Click "New +" → "PostgreSQL"
2. Name: `ojtracker-db`
3. Database: `ojtracker`
4. Region: Singapore (closest to PH)
5. Plan: **Free**
6. Click "Create Database"
7. **Copy the Internal Database URL** (starts with `postgres://`)

### 4. **Create Web Service**
1. Click "New +" → "Web Service"
2. Connect your GitHub repo: `OJTracker`
3. Configure:
   - **Name**: `ojtracker`
   - **Region**: Singapore
   - **Branch**: `main`
   - **Root Directory**: (leave blank)
   - **Runtime**: PHP
   - **Build Command**: 
     ```bash
     bash render-build.sh
     ```
   - **Start Command**:
     ```bash
     php artisan migrate --force && php artisan storage:link && php artisan serve --host=0.0.0.0 --port=$PORT
     ```
   - **Plan**: Free

### 5. **Add Environment Variables**
Click "Advanced" → Add these:

```
APP_NAME=OJTracker
APP_ENV=production
APP_KEY=base64:YOUR_KEY_HERE
APP_DEBUG=false
APP_URL=https://your-app-name.onrender.com

DB_CONNECTION=pgsql
DB_HOST=[from database internal URL - host part]
DB_PORT=5432
DB_DATABASE=ojtracker
DB_USERNAME=[from database internal URL - username]
DB_PASSWORD=[from database internal URL - password]

LOG_CHANNEL=errorlog
LOG_LEVEL=error

SESSION_DRIVER=cookie
SESSION_LIFETIME=120

CACHE_DRIVER=array
QUEUE_CONNECTION=sync

BROADCAST_DRIVER=log
FILESYSTEM_DISK=local
```

**To generate APP_KEY:**
```bash
php artisan key:generate --show
```

### 6. **Deploy**
- Click "Create Web Service"
- Wait 5-10 minutes for first deployment
- Your app will be live at: `https://your-app-name.onrender.com`

---

## 📌 Important Notes

### Free Tier Limitations:
- ⏰ **Sleeps after 15 min** of inactivity (30s cold start)
- 💾 **PostgreSQL free for 90 days**, then $7/month
- 🚀 **750 hours/month** web service (enough for backup use)

### Avoiding Sleep:
- Use a uptime monitor (e.g., UptimeRobot) to ping every 14 minutes
- Or upgrade to paid plan ($7/month - no sleep)

### Database Connection:
Make sure your `config/database.php` has PostgreSQL configured:
```php
'pgsql' => [
    'driver' => 'pgsql',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '5432'),
    'database' => env('DB_DATABASE', 'forge'),
    'username' => env('DB_USERNAME', 'forge'),
    'password' => env('DB_PASSWORD', ''),
    // ... rest of config
],
```

---

## 🔄 Both Railway & Render Active

**Pwede mag-run ang duha at the same time:**
- Railway: `https://ojtracker.up.railway.app`
- Render: `https://ojtracker.onrender.com`

Each has:
- ✅ Separate databases
- ✅ Separate environment variables
- ✅ Same codebase from GitHub

**When Railway expires:**
- Just update your main URL to Render
- All data in Railway database will be lost (unless you backup)
- Render becomes your primary deployment

---

## 🆘 Troubleshooting

### Build fails?
- Check PHP version in `composer.json`
- Ensure all dependencies in `composer.json`

### Database connection error?
- Verify DATABASE_URL or individual DB_* variables
- Check database is in same region

### 500 Error?
- Check logs in Render dashboard
- Ensure APP_KEY is set
- Run `php artisan config:clear`

---

## 💡 Pro Tips

1. **Keep Railway as primary** until it expires
2. **Test Render deployment** early to catch issues
3. **Backup Railway database** before migration
4. **Update DNS/domain** when switching

**Need help?** Render has good documentation: https://render.com/docs/deploy-php-laravel

---

## 📊 MySQL to PostgreSQL Migration

### What Changed:
✅ **Code is now compatible with BOTH MySQL and PostgreSQL!**
- Date formatting automatically detects database type
- No breaking changes to your current MySQL setup
- Same code works on Railway (MySQL) and Render (PostgreSQL)

### For Railway (Continue using MySQL):
- No changes needed!
- Keep using `DB_CONNECTION=mysql`
- Everything works as before

### For Render.com (Will use PostgreSQL):
- Render will automatically use `DB_CONNECTION=pgsql`
- Date search queries work the same way
- Tables will be created fresh via migrations

### 🔄 Migrating Data (Optional):

**If you want to transfer existing data from Railway MySQL to Render PostgreSQL:**

#### Option 1: Manual Export/Import (Simple)
```bash
# 1. Export from Railway MySQL (on your local)
php artisan tinker
>>> User::all()->toJson();  // Copy output
>>> DtrLog::all()->toJson(); // Copy output
>>> Accomplishment::all()->toJson(); // Copy output

# 2. Import to Render (via tinker on Render)
# Connect to Render shell and run php artisan tinker
>>> User::insert(json_decode('paste here', true));
```

#### Option 2: Using Database Dump (Advanced)
```bash
# Export from Railway
mysqldump -h railway.host -u user -p database > backup.sql

# Convert to PostgreSQL format (use online tools or pgloader)
# Then import to Render PostgreSQL
```

**Note:** For fresh start (recommended for testing), just let Render create new database and test with sample data.
