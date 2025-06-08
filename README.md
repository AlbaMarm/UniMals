# ⯨UniMals⯩

**UniMals** is a virtual pet game built with Laravel and TailwindCSS, where you can care for your own digital creature! Feed them, clean them, give them water, and let them sleep to keep them happy. Watch them grow, earn coins, and level up as you interact with them in a cozy, animated environment.

---

<p align="center">
  <img src="public/images/skybanner.png" alt="UniMals Banner" width="800"/>
</p>


---

## ✧ Features ✧

- 🎮 **Interactive Pet**
  - Click to make your pet happy
  - Level up your pet with interactions

- 🍖 **Feed & Drink System**
  - Buttons trigger feeding and drinking animations
  - Stats update in real-time

- 🧼 **Cleaning & Bathing**
  - Soap bubbles appear when cleaning
  - Cleanliness stat increases

- 💤 **Sleep System**
  - Toggle sleep mode: pet image grayscales and screen darkens
  - Gradually restores sleepiness stat

- 💰 **Earnings & Level Up**
  - Earn coins by making your pet happy
  - Visual coin and level-up alerts using SweetAlert

- 📈 **Live Stats**
  - Hunger, thirst, cleanliness, and sleep bars update every minute

- 🛒 **Shop System**
  - Buy items for your pet
  - View purchased items in your home

- 💬 **Motivational Toasts**
  - Sweet floating messages that appear when clicking the pet

---

## 🛠 Built With 🛠
<img src="https://skillicons.dev/icons?i=laravel,tailwind,css,html,javascript,php,mysql" height="40"/>

---

## ✦ Downloading instructions ✦
Make sure you have the following installed:

- [Composer](https://getcomposer.org/download/)
- [PHP](https://www.php.net/downloads.php)
- [Node.js and npm](https://nodejs.org/en/download)

### ☛ Installation ☚

```bash
# First you clone the repository
git clone https://github.com/AlbaMarm/UniMals.git

# Move into the project directory
cd UniMals

# Install PHP dependencies
composer install

# Install frontend dependencies
npm install

# Copy and configure your environment. Add your mailtrap info in the .env if you want to check it out
cp .env.example .env

# Generate app key
php artisan key:generate

# Run database migrations
php artisan migrate

# (Optional) Seed with test data
php artisan migrate:fresh --seed

# Compile assets
npm run dev

# Serve the app
php artisan serve
```
---
## ✉ Optional: Mailtrap setup for testing feedback emails ✉

If you’d like to see the feedback emails in your inbox during development, you can use [Mailtrap](https://mailtrap.io/). Mailtrap acts as a fake SMTP server so you don’t send real emails while testing.

1. **Sign up** at [mailtrap.io](https://mailtrap.io/).  
2. **Create an Inbox** and copy your SMTP credentials (host, port, username, password).  
3. **Update your `.env`** file in the project root with the Mailtrap settings:

   ```dotenv
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=your_mailtrap_username
   MAIL_PASSWORD=your_mailtrap_password
   MAIL_ENCRYPTION=null

   MAIL_FROM_ADDRESS=feedback@unimals.test
   MAIL_FROM_NAME="${APP_NAME}"

   ```

---
## ⯨Autor/a⯩

- **Nombre:** Alba Marmolejo Ramos  
- **Email:** alba03943@gmail.com  
- **GitHub:** [@AlbaMarm](https://github.com/AlbaMarm)  
- **LinkedIn:** [Alba Marmolejo Ramos](https://www.linkedin.com/in/alba-marmolejo-ramos-34b833331/)

---
### Copyright (c) 2025 AlbaMarm
Este proyecto está bajo una licencia [MIT](LICENSE.txt).