# Book Lending System

## **Technologies Used**

- **PHP 8.2**  
- **Laravel 10**  
- **MySQL 8**  
- **Docker & Docker Compose**  

---

## **Setup Instructions**

### **1️⃣ Clone the project**

```bash
git clonehttps://github.com/dinaedona/BookLendingSystem.git
cd <project-folder>
```

---

### **2️⃣ Build & Run with Docker**

```bash
docker-compose up --build
```

This will:

- Start the **Laravel API** on `http://127.0.0.1:8000`
- Start **MySQL** on port `3306`

---

### **3️⃣ Environment Configuration**

`.env`:

Ensure this DB configuration matches Docker:

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=book_lending_system
DB_USERNAME=selise
DB_PASSWORD=selise

CACHE_STORE=file
SESSION_DRIVER=file
```

---

### **4️⃣ Install dependencies**

```bash
docker-compose exec app composer install
```

---

### **5️⃣ Generate App Key**

```bash
docker-compose exec app php artisan key:generate
```

---

### **6️⃣Run Migrations and Import Stored Procedures**

Run Laravel Migrations
This will create the users table and other required tables:

```bash
docker-compose exec app php artisan migrate
```


