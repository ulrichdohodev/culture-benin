# Culture Bénin - Railway MySQL Database Configuration

## Railway Database Setup

### 1. Create MySQL Database on Railway

1. Go to [Railway](https://railway.app)
2. Create a new project: **culture-benin-db**
3. Add a new service: **MySQL**
4. Railway will automatically provision a MySQL database

### 2. Get Database Credentials

After MySQL is provisioned, Railway will provide:
- **Host**: `<random>.railway.app`
- **Port**: `<port>` (usually a random port like 6379)
- **Database**: `railway`
- **Username**: `root`
- **Password**: `<generated-password>`

Or use the `DATABASE_URL` format:
```
mysql://root:<password>@<host>:<port>/railway
```

### 3. Configure Render with Railway Database

In your Render dashboard for `culture-benin` service, add these environment variables:

```bash
DB_CONNECTION=mysql
DB_HOST=<railway-mysql-host>
DB_PORT=<railway-mysql-port>
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=<railway-mysql-password>
```

### 4. Network Configuration

**Important**: Railway databases are accessible from the public internet by default.
No special network configuration needed for Render → Railway connection.

### 5. Initial Database Setup

The Laravel migrations will run automatically on first deployment via the `00-laravel-script.sh`.

To manually run migrations and seeders:
```bash
# SSH into Render container
php artisan migrate --force
php artisan db:seed --force
```

### 6. Backup Strategy

Railway provides automatic backups. You can also:

```bash
# Create manual backup (from Render container)
php artisan backup:run

# Or use Railway CLI
railway run mysqldump railway > backup.sql
```

### 7. Database Access

To connect to Railway MySQL from your local machine:

```bash
# Install Railway CLI
npm install -g @railway/cli

# Login
railway login

# Link to project
railway link

# Connect to database
railway connect mysql
```

### 8. Monitoring

- Railway Dashboard: Monitor CPU, Memory, Network usage
- Render Logs: Check application logs for database errors
- Laravel Logs: Available in Render dashboard

### Environment Variables Summary

**Render (Backend):**
```env
APP_NAME=CultureBenin
APP_ENV=production
APP_DEBUG=false
APP_URL=https://culture-benin.onrender.com
APP_KEY=<generate-with-artisan>

DB_CONNECTION=mysql
DB_HOST=<railway-host>
DB_PORT=<railway-port>
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=<railway-password>

SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database

MAIL_MAILER=log
```

### Troubleshooting

**Connection Issues:**
1. Verify Railway database is running
2. Check firewall rules (Railway allows all IPs by default)
3. Verify credentials are correct in Render
4. Check Render logs for specific errors

**Migration Failures:**
1. SSH into Render: `php artisan migrate:status`
2. Check database exists: `php artisan db:show`
3. Rollback if needed: `php artisan migrate:rollback`

**Performance:**
- Railway MySQL: Shared resources on free plan
- Consider upgrading for production workloads
- Monitor slow queries in Laravel logs
