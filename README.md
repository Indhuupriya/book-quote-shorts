# 📚 Book Quote Shorts (Laravel + Vanilla JS)

A simple web app built as part of the **Notion Press Full Stack Developer Assessment**.  
It displays short book quotes like "reels" with smooth transitions, navigation, autoplay, like & share options.

---

## 🚀 Features

- Display quotes with **author name & book title**
- Smooth transitions (fade/slide)
- Navigation: **Next / Previous / Auto-play**
- Like button (with DB update)
- Share button (native share / copy to clipboard)
- Responsive layout
- Clean, structured code (Laravel backend + Vanilla JS frontend)

---

## 🛠️ Tech Stack

- **Backend**: PHP 8, Laravel 10, MySQL/SQLite
- **Frontend**: Vanilla JavaScript, Blade templates, CSS
- **Database**: MySQL (or SQLite for local quick setup)

---

## 📂 Project Structure
book-quote-shorts/
├── app/Models/Quote.php
├── app/Http/Controllers/Api/QuoteController.php
├── database/migrations/xxxx_create_quotes_table.php
├── database/seeders/QuotesTableSeeder.php
├── resources/views/app.blade.php
└── routes/
├── api.php
└── web.php

## ⚡ Installation (Local)

1. Clone repo  
   git clone https://github.com/Indhuupriya/book-quote-shorts.git
   cd book-quote-shorts

2. Install dependencies
   composer install
3.Copy .env file
    cp .env.example .env
    php artisan key:generate
4.Configure .env (MySQL example):
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=book_quotes
    DB_USERNAME=root
    DB_PASSWORD=
5.Run migrations + seeders
    php artisan migrate --seed
    php artisan db:seed --class=QuotesTableSeeder
6.Serve app
    php artisan serve
    Visit → http://127.0.0.1:8000
   
## ⚡API Endpoints
GET /api/quotes → List all quotes
GET /api/quotes/{id} → Single quote
POST /api/quotes/{id}/like → Like a quote


