# 🏨 Integrative Project: Laravel Hotel Reservation Management Suite with Email Support

A Laravel-based hotel reservation system that allows users to book rooms, receive email confirmations, and manage reservations efficiently.

---

## 🚀 Getting Started

### ✅ Prerequisites

- [XAMPP](https://www.apachefriends.org/index.html) (Apache, MySQL)
- PHP >= 8.0
- Composer
- Laravel CLI

---

## 🛠️ Setup Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/laraviel-suite.git
cd laraviel-suite
```

---

### 2. Create the `.env` File

Inside the `laraviel-suite` folder, create a `.env` file manually or by copying the example:

```bash
cp .env.example .env
```

Then update the following database configuration based on your XAMPP setup:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laraviel_suite
DB_USERNAME=root
DB_PASSWORD=   # Leave empty if no password
```

---

### 3. Configure Email (Gmail SMTP)

Set up your Google App password and use it here:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="laraviel-suite"
```

> ⚠️ **Important:** Use [Google App Passwords](https://support.google.com/accounts/answer/185833) instead of your Gmail password.

---

### 4. Install Dependencies

```bash
composer install
```

---

### 5. Generate Application Key

```bash
php artisan key:generate
```

---

### 6. Run Database Migrations

Ensure your MySQL server is running in XAMPP, then run:

```bash
php artisan migrate
```

---

### 7. Start the Laravel Development Server

```bash
php artisan serve
```

Visit: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 💡 Features

- 🛏️ Hotel room booking system
- 📧 Email confirmations using Gmail SMTP
- 📋 Admin and user dashboards
- 📅 Reservation management
- 🧾 Clean UI using Laravel Blade

---

## 📄 License

This project is licensed under the MIT License — free for personal and commercial use.

---

## 🤝 Contributing

Contributions are welcome! Please fork the repo and submit a pull request.

---

## 📧 Contact

For issues or collaboration, email: `kirkfabonnnn@gmail.com`
