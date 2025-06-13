# 🧑‍💼 User Portal - PHP User Management System

A simple PHP-based user portal that supports registration, login, profile management, and dashboard functionality. This project demonstrates basic user authentication, file upload, and session handling.

---

## 🚀 Features

- User Registration with profile image upload
- User Login & Logout
- Authenticated Dashboard
- AJAX-based interactions
- MySQL database integration
- Basic modular structure

---

## 🛠️ Tech Stack

- PHP (Core)
- MySQL
- JavaScript / AJAX
- HTML / CSS
- Bootstrap (if used in assets)
- jQuery (optional, based on usage)

---

## 🗃️ Project Structure

```
user-portal/
│
├── index.php              # Homepage (Redirect to login)
├── register.php           # User registration form
├── login.php              # Login logic
├── logout.php             # Logout script
├── dashboard.php          # Authenticated user dashboard
├── config.php             # Database connection setup
├── auth_check.php         # Session-based access control
├── ajax.php               # AJAX endpoints (e.g., validation)
│
├── user_portal.sql        # SQL dump for users table
│
├── /uploads/              # User-uploaded profile images
├── /assets/               # CSS, JS, or image files
├── /models/               # Model components
├── /db/                   # Possibly DB interaction layer
```

---

## ⚙️ Setup Instructions

### 🔧 1. Clone the Repository

```bash
git clone https://github.com/your-username/user-portal.git
cd user-portal
```

### 🗄️ 2. Setup Database

- Create a MySQL database (e.g., `user_portal`)
- Import `user_portal.sql` using phpMyAdmin or CLI:
```bash
mysql -u root -p user_portal < user_portal.sql
```

### ⚙️ 3. Configure Database Connection

Edit the `config.php` file with your DB credentials:

```php
const DB_HOST = 'localhost';
const DB_NAME = 'user_portal'; // Database name if changed.
const DB_USER = 'YOUR_DB_USERNAME_HERE';
const DB_PASS = 'YOUR_DB_PASSWORD_HERE';
```

### 🚀 4. Run the Project

Use a local server like XAMPP, WAMP, or MAMP.

Place the folder in your `htdocs` and access:
```
http://localhost/user-portal/
```

---

## 🧪 Testing

- Register a user
- Log in using the credentials
- Access `dashboard.php`
- Test uploading a profile picture
- Use browser Dev Tools to view AJAX requests
---

## ⚠️ **Image Upload Issue?**
If profile images fail to upload, make sure the `/uploads` folder is writable:
```bash
sudo chmod -R 775 uploads/
sudo chown -R www-data:www-data uploads/
```

---

## 👨‍💻 Author

- **Sachin Sanchania** – [@sachin-sanchania](https://github.com/sachin-sanchania)
