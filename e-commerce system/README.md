# 🛒 Online E-Commerce System

This project is a simple full-stack e-commerce web application built with **Laravel (Backend)** and **Vue.js (Frontend)**.  
It includes features for browsing products, adding them to a cart, placing orders, and viewing order summaries.

## 🚀 Features

- Product listing with dynamic data from the backend
- Add to Cart and Checkout functionality
- Order creation and summary email confirmation
- Dockerized environment for Laravel, MySQL, and Nginx
- REST API between frontend and backend services

online-e-commerce-system/
├── backend/ # Laravel 12 backend API
├── frontend/ # Vue.js frontend
├── docker-compose.yml
├── Dockerfile
└── README.md


Make sure you have these installed:

- [Docker Desktop](https://www.docker.com/)
- [Git](https://git-scm.com/)
- [Node.js](https://nodejs.org/) (if running the frontend locally)
- A GitHub account (for pushing this repo)

## 🐳 Provisioning and Setup

Clone this repository:

```bash
git clone https://github.com/<your-username>/online-e-commerce-system.git
cd online-e-commerce-system


Build and Start Containers
docker-compose up -d --build

This will start:

backend (Laravel app)
mysql_db (MySQL database)
nginx (web server)

Run Migrations and Seeders

Inside the backend container:
docker exec -it backend php artisan migrate --seed
This creates tables and seeds example product data.

Access the Application

Service	URL
Frontend	http://localhost:5173
Backend API	http://localhost/api/products
phpMyAdmin (optional if configured)	http://localhost:8080

Testing

You can run Laravel tests using:
docker exec -it backend php artisan test
Or manually test API routes via Postman or browser.


Common Commands
Command	Description

docker ps	Check running containers
docker logs backend	View backend logs
docker exec -it backend bash	Enter Laravel container
docker-compose down	Stop and remove containers


Environment Configuration
Make sure your .env file inside backend/ includes:

APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:xxxxxxxxxxxxxxxxxxxxxxxxxxx
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=mysql_db
DB_PORT=3306
DB_DATABASE=ecommerce
DB_USERNAME=root
DB_PASSWORD=root


If you have a .env.example, copy it:

cp .env.example .env


Then generate the Laravel key:

docker exec -it backend php artisan key:generate


Author

John Carl Murillo
📧 Email: your-email@example.com
🌐 GitHub: https://github.com/<your-username>

License

This project is open-source and available under the MIT License
.

# for frontend side

Frontend Setup (Vue.js3)

If you want to run or modify the frontend locally (outside Docker):

cd frontend
npm install
npm run dev


By default, it will start on http://localhost:5173
 and connect to the backend API.


 Frontend Tests

If you have frontend tests configured (e.g., Vitest or Jest), run:

cd frontend
npm run test



Deployment Notes

To make this project public:

Push your code to a new GitHub repository:

git add .
git commit -m "Initial commit"
git branch -M main
git remote add origin https://github.com/<your-username>/online-e-commerce-system.git
git push -u origin main


Make sure the repository is Public on GitHub.
for email testing, i use mailtrap

Include this README.md file in the root directory.
