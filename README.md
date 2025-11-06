# Mini Social Feed API (Laravel + JWT)

A mini social feed RESTful backend inspired by Facebook. Users can **register, login, create posts (text, image, video), like, unlike, comment, and view feed**.

---

## Tech Stack

- **Framework:** Laravel 12  
- **Authentication:** JWT (`tymon/jwt-auth`)  
- **Database:** MySQL  
- **Storage:** Local 
- **Response Format:** Laravel API Resources/Collections (JSON)  
- **API Type:** RESTful

---

## ⚙️ Setup Instructions

### 1️⃣ Clone & Install
```bash
git clone https://github.com/<your-username>/mini-social-api.git
cd mini-social-api
composer install
cp .env.example .env
php artisan jwt:secret
php artisan migrate
php artisan storage:link
php artisan serve


# Configure .env

APP_NAME="Mini Social Feed API"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=social_feed_api
DB_USERNAME=root
DB_PASSWORD=

# Run the App
php artisan serve

Open in browser: http://localhost:8000

# Authentication

# Use Bearer Token in headers for all protected routes:

Authorization: Bearer <your_token_here>

# API Endpoints

#Feature               #Method          #Endpoint                      #Description
Register               POST            /api/auth/register              Register new user
Login	               POST	           /api/auth/login	               Get JWT token
Profile (Me)	       GET	           /api/auth/me	                   Get current user
Logout	               POST	           /api/auth/logout	               Logout user
Create Post	           POST	           /api/posts	           Create post (text + optional media)
All Posts	           GET	           /api/posts	           Get all posts (latest first)
View Post	           GET	           /api/posts/{id}	               Get single post
Delete Post	           DELETE	       /api/posts/{id}	               Delete post (owner only)
Like Post	           POST	           /api/posts/{id}/like	           Like a post
Unlike Post	           POST	           /api/posts/{id}/unlike	       Unlike a post
Comment Post	       POST	           /api/posts/{id}/comment	       Add comment
Get Comments	       GET	           /api/posts/{id}/comments	       List comments
Feed	               GET	         /api/feed	    Posts with author, likes, comments, liked status


# Commands Summary

#Purpose	                      #Command
Migrate DB	                      php artisan migrate  # First setup your .env
Generate JWT Key	              php artisan jwt:secret
Storage Link	                  php artisan storage:link
Clear Cache	                      php artisan config:clear && php artisan cache:clear
Serve App	                      php artisan serve


# Challenges & Assumptions

Media files stored locally under /storage/app/public/posts/

Post deletion restricted to owner only

Feed returns all posts with Post author details	- Like count - Commen count	- Whether the current user liked the post or not

JWT token expiration follows default settings in config/jwt.php

Assumes single MySQL database



👨‍💻 Author

Suneel Kumar
Full Stack Web Developer
📧 suneelkumarsk036@gmail.com

📞 +91-9793581152
🌐 New Delhi, India

✅ License

MIT License — Free for learning and interviews.  
