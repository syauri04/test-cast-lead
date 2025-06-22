# 🧩 Full-Stack Developer Interview Test Case

A full-stack lead collection and management system built for the Full-Stack Developer Interview Test Case.

✅ WordPress (frontend form)  
✅ Laravel (backend API)  
✅ PostgreSQL (leads + error logs)  
✅ Error logging & security  
✅ Docker/VPS ready  
✅ Bonus: CI/CD, Unit Tests, Redis (optional)

---

## 📁 Project Structure

```
lead-management-system/
├── lead-api/                  # Laravel backend API
├── lead-wp/                   # WordPress (form page/theme/plugin)
├── database/
│   ├── schema.sql             # DB schema (leads + error_logs)
│   └── sample_data.sql        # Dummy sample data
├── docker-compose.yml         # Docker setup (optional)
├── README.md                  # Setup & deployment instructions
```

---

## 🔧 Requirements

For VPS installation:

- Ubuntu 22.04 LTS (or similar)
- PHP 8.2+
- PostgreSQL
- Nginx
- Composer
- Git
- Laravel 10.x
- WordPress 6.x

Or use Docker (optional).

---

## 🛠 Setup Instructions (Manual/VPS)

### 1. Clone Repository

```bash
git clone https://github.com/syauri04/test-cast-lead.git
cd lead-management-system
```

---

### 2. Setup PostgreSQL

```bash
sudo -u postgres psql
```

```sql
-- Leads DB
CREATE DATABASE leads_db;
CREATE USER leaduser WITH PASSWORD 'leadpass';
GRANT ALL PRIVILEGES ON DATABASE leads_db TO leaduser;

-- Logging DB
CREATE DATABASE error_logs;
GRANT ALL PRIVILEGES ON DATABASE error_logs TO leaduser;
\q
```

---

### 3. Setup Laravel API

```bash
cd lead-api
composer install
cp .env.example .env
php artisan key:generate
```

Edit `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=leads_db
DB_USERNAME=leaduser
DB_PASSWORD=leadpass

LOG_DB_HOST=127.0.0.1
LOG_DB_DATABASE=error_logs
LOG_DB_USERNAME=leaduser
LOG_DB_PASSWORD=leadpass
```

Run migration:

```bash
php artisan migrate
```

---

### 4. Setup WordPress

```bash
cd lead-wp
# Run WordPress installation as usual via browser
```

- Include your custom theme or plugin containing the lead submission form
- Form submits to: `POST /api/leads` via `wp_remote_post()`

---

### 5. Nginx Configuration

```nginx
server {
    listen 80;
    server_name mydomain.com;
    root /var/www/lead-wp;
    index index.php index.html;
    location / {
        try_files $uri $uri/ /index.php?$args;
    }
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}

server {
    listen 80;
    server_name api.mydomain.com;
    root /var/www/lead-api/public;
    index index.php;
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

---

## 🐘 Sample Database Data

```bash
psql -h localhost -U leaduser -d leads_db -f database/sample_data.sql
```

---

## 🔑 API Security

All endpoints are secured using a Bearer Token.

Example:

```bash
curl -H "Authorization: Bearer supersecrettoken" http://api.mydomain.com/api/leads
```

---

## 🌐 Access URLs

| Component      | Example URL                       |
| -------------- | --------------------------------- |
| WordPress Form | http://mydomain.com/form-lead     |
| API Endpoint   | http://api.mydomain.com/api/leads |

---

## 🐳 Docker (Optional)

If you're using Docker, run:

```bash
docker-compose up -d --build
```

Refer to `docker-compose.yml` for the full setup including WordPress + Laravel + PostgreSQL.

---

## 👨‍💻 Author

Developed for Full-Stack Developer Interview Test  
© 2025 Rifan Ahmad Syauri
