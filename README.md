# Laravel Shorter URL Generator

A simple URL shortener built with Laravel (10/11).

## Requirements
- PHP >= 8.1
- Composer
- MySQL
- Git
- (Optional) Node.js / npm for frontend assets

## Quick setup
1. Clone
```bash
git clone https://github.com/anshulbhati/shorter-url.git
cd shorter-url
```
2. Environment
```bash
cp .env.example .env
php artisan key:generate
```
Edit .env and set DB and session values:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shorter_url
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=file
```
Add mail settings if sending email.

3. Install dependencies
```bash
composer install
# optional frontend
npm install
npm run build
```

4. Database
```bash
php artisan migrate --seed
```

5. Run app and queue
```bash
php artisan serve
php artisan queue:listen   # or: php artisan queue:work
```

## What this project includes
- Migrations to create the schema
- Seeders (including Super Admin / Role seeder)
- Middleware for routes & auth
- Authentication (login/guard checks)
- Gates for authorization
- Mail invitations
- Queue support for sending mail without delay

## Troubleshooting (common fixes)
- Ensure storage permissions: `php artisan storage:link` and correct permissions on storage/bootstrap/cache
- If migrations fail: `composer dump-autoload` then `php artisan migrate`
- Clear caches: `php artisan config:clear && php artisan route:clear && php artisan cache:clear`

## Contributing / Debugging help
- Open an issue with steps to reproduce, error messages and relevant logs
- For small UI/spelling fixes, create a PR with concise commits

Thank you.
