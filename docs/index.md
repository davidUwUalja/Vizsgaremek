# Dokumentáció
FinalProject/
├── backend/                 # Laravel Backend
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   │   ├── AuthController.php
│   │   │   │   ├── ProductController.php
│   │   │   │   └── OrderController.php
│   │   │   ├── Middleware/
│   │   │   └── Requests/
│   │   ├── Models/
│   │   │   ├── User.php
│   │   │   ├── Product.php
│   │   │   └── Order.php
│   │   └── Services/
│   │       └── PaymentService.php
│   ├── config/
│   ├── database/
│   │   ├── migrations/
│   │   │   ├── 2023_12_10_000001_create_users_table.php
│   │   │   ├── 2023_12_10_000002_create_products_table.php
│   │   │   └── 2023_12_10_000003_create_orders_table.php
│   │   ├── seeders/
│   │   │   ├── ProductSeeder.php
│   │   │   └── UserSeeder.php
│   ├── routes/
│   │   ├── api.php
│   │   └── web.php
│   ├── tests/
│   │   ├── Feature/
│   │   │   ├── ProductApiTest.php
│   │   │   └── UserApiTest.php
│   │   └── Unit/
│   │       ├── PaymentServiceTest.php
│   │       └── OrderModelTest.php
│   └── Dockerfile
├── frontend/                # Vue.js Frontend
│   ├── public/
│   │   ├── index.html
│   │   └── favicon.ico
│   ├── src/
│   │   ├── assets/
│   │   │   ├── images/
│   │   │   │   └── logo.png
│   │   ├── components/
│   │   │   ├── ProductCard.vue
│   │   │   ├── ShoppingCart.vue
│   │   │   └── Navbar.vue
│   │   ├── layouts/
│   │   │   └── MainLayout.vue
│   │   ├── pages/
│   │   │   ├── Home.vue
│   │   │   ├── ProductList.vue
│   │   │   └── Checkout.vue
│   │   ├── router/
│   │   │   └── index.js
│   │   ├── stores/
│   │   │   ├── productStore.js
│   │   │   └── userStore.js
│   │   ├── utils/
│   │   │   └── apiClient.js
│   │   ├── App.vue
│   │   └── main.js
│   ├── tests/
│   │   ├── e2e/
│   │   ├── unit/
│   │   │   ├── ShoppingCartTest.js
│   │   │   └── NavbarTest.js
│   │   └── integration/
│   │       ├── ProductListIntegrationTest.js
│   │       └── CheckoutIntegrationTest.js
│   └── Dockerfile
├── api/                     # C# REST API
│   ├── Controllers/
│   │   ├── ProductController.cs
│   │   └── OrderController.cs
│   ├── Models/
│   │   ├── Product.cs
│   │   ├── Order.cs
│   │   └── User.cs
│   ├── Services/
│   │   └── ReportService.cs
│   ├── Tests/
│   │   ├── ProductControllerTest.cs
│   │   └── OrderServiceTest.cs
│   ├── Program.cs
│   ├── Startup.cs
│   └── Dockerfile
├── sql/                     # SQL Scripts
│   ├── create_schema.sql
│   ├── seed_data.sql
│   ├── optimize_indexes.sql
│   └── test_queries.sql
├── docker-compose.yml
└── README.md