1. install lumen (composer lumen)
1. npm init -y
1. npm install
	1. dotenv
	1. pg & pg-hstore
	1. sequelize
1. update package.json (type : "module")
1. composer install
	1. aura/sqlquery
	1. firebase/php-jwt
	1. hidehelo/nanoid-php
	1. nesbot/carbon 2.72.5
	1. pyaesoneaung/to-raw-sql
	1. respect/validation
1. delete artisan
1. update .gitignore
1. new file in root
	1. database.js
	1. dbsync.js
	1. drop.js
	1. env.js
	1. seed.js
1. new directory modules
1. test db connection (node database.js)
1. modules
1. dbsync
1. seed
1. (optional) check drop
1. .env
	1. APP_NAME
	1. APP_KEY (32 char)
	1. APP_URL
	1. APP_TIMEZONE=Asia/Jakarta
1. routes get return `env('APP_NAME',$router->app->version());`
1. buat `CorsMiddleware.php` pada `app/Http/Middleware`
1. daftarkan middleware di `bootstrap/app.php`
1. `Exception` untuk `404 Not Found`
1. uncomment `// $app->withFacades();` menjadi `$app->withFacades();` di file `bootstrap.php/app.php`
1. App/Helper
	1. Controller Helper
1. app/Http/Controllers/Controller.php@afterMiddleware
1. router