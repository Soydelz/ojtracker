# OJT Tracker - Railway Deployment Guide

## Step 1: Create Railway Account
1. Go to https://railway.app
2. Click "Login with GitHub" or "Start a New Project"
3. Sign up/Login (free account)

## Step 2: Initialize Git (if not yet done)
```bash
git init
git add .
git commit -m "Initial commit for deployment"
```

## Step 3: Deploy to Railway

### Option A: Deploy from GitHub (RECOMMENDED)
1. Push your code to GitHub first:
   ```bash
   git remote add origin YOUR_GITHUB_REPO_URL
   git branch -M main
   git push -u origin main
   ```

2. In Railway:
   - Click "New Project"
   - Select "Deploy from GitHub repo"
   - Choose your repository
   - Railway will auto-detect Laravel

### Option B: Deploy using Railway CLI
1. Install Railway CLI:
   ```bash
   npm i -g @railway/cli
   ```

2. Login to Railway:
   ```bash
   railway login
   ```

3. Initialize and deploy:
   ```bash
   railway init
   railway up
   ```

## Step 4: Add MySQL Database
1. In your Railway project dashboard
2. Click "New" → "Database" → "Add MySQL"
3. Railway will automatically create a MySQL database

## Step 5: Configure Environment Variables
In Railway dashboard, go to your project → Variables, add these:

```
APP_NAME="OJT Tracker"
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://your-app.railway.app

DB_CONNECTION=mysql
DB_HOST=${{MYSQL_HOST}}
DB_PORT=${{MYSQL_PORT}}
DB_DATABASE=${{MYSQL_DATABASE}}
DB_USERNAME=${{MYSQL_USER}}
DB_PASSWORD=${{MYSQL_PASSWORD}}

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=syydlzz@gmail.com
MAIL_PASSWORD=giyf bpfr dbfu sffl
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=syydlzz@gmail.com
MAIL_FROM_NAME="OJT Tracker"

SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

**Note:** Railway automatically injects MySQL variables (MYSQL_HOST, MYSQL_PORT, etc.) when you add the MySQL service.

## Step 6: Generate APP_KEY
Run this locally to get your APP_KEY:
```bash
php artisan key:generate --show
```
Copy the output and paste it in Railway's `APP_KEY` variable.

## Step 7: Run Migrations
After deployment, open Railway's project → Click on your service → "Settings" → "Deploy" section, add this to **Build Command**:
```bash
php artisan migrate --force
```

Or run manually in Railway's terminal:
```bash
php artisan migrate --force
```

## Step 8: Storage Link
In Railway terminal, run:
```bash
php artisan storage:link
```

## Common Issues & Solutions

### Issue: 500 Error
- Check APP_KEY is set
- Verify database connection
- Check Railway logs

### Issue: Database not connecting
- Ensure MySQL service is running
- Check environment variables are correctly referenced

### Issue: Assets not loading
- Run `npm run build` before deployment
- Check APP_URL matches your Railway URL

## Your Railway URLs
- Project Dashboard: https://railway.app/project/YOUR_PROJECT_ID
- Live URL: https://your-app.railway.app (Railway will provide this)

## Cost
Railway provides **$5 free credit per month** which is enough for a small project like this.

---

Need help? Check Railway docs: https://docs.railway.app/
