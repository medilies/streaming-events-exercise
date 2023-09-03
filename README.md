# Streaming Events Exercise

## System requirements

-   PHP 8.1
-   MySQL database server
-   Composer

[Donwload XAMPP for windows](https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/8.1.12/)
[Download Composer](https://getcomposer.org/download/)

## Deployment steps

```bash
git clone https://github.com/medilies/streaming-events-exercise
```

```bash
cd streaming-events-exercise
```

```bash
composer install
```

```bash
npm i
```

```bash
npm run build
```

Create a database

```bash
cp .env.example .env
```

Set `DB_DATABASE` `DB_USERNAME` `DB_PASSWORD`

```bash
php artisan key:generate
```

```bash
php artisan optimize:clear
```

```bash
php artisan migrate:fresh --seed
```

Set GitHub Oauth provider and `GITHUB_CLIENT_ID`, `GITHUB_CLIENT_SECRET`

## APIs docs

Run:

```bash
php artisan scribe:generate
```

Open `api-docs\index.html` in a browser.

![db](./db_diagram.png)
