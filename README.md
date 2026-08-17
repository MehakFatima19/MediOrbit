# MediOrbit - Advanced Clinical Metabolic Portal

MediOrbit is a fully functional, premium-grade clinical health analyzer and medical blog system replicating the high-end **MediCompass** design language.

## Key Features

1. **NutriScan AI (Personal Health Analyzer):**
   * **Dynamic Condition Selector:** Click through 12 different metabolic and chronic conditions to instantly recalculate and animate daily budget targets.
   * **Food Dish Analyzer:** Drag-and-drop or browse to upload food pictures, triggering a simulated Vision AI parsing engine that returns deep macronutrient metrics.
   * **Kcal Budget allowance Dashboard:** High-fidelity soft blue calculation block featuring a live mathematical equation and a color-coded percentage tracker bar.
   * **AI Treatment Bot Warning Alert:** Soft warn-colored bottom alert card providing safety reviews, portion sizing recommendations, and a live Urdu Nastaliq translation toggle.

2. **Wellness Guide (Medical Articles System):**
   * **Bilingual Blog Grid:** Highly polished 4x3 responsive catalog displaying clinical category headers, reading times, custom serif typography, and descriptive details.
   * **Asynchronous AJAX Pagination:** Dynamically loads the next 6 articles smoothly on scroll/click of "Load More" without reloading.
   * **Immersive Frosted detail modal:** A deep frosted-glass blur backdrop overlay displaying full pathological descriptions, causes, and customized food restrictions, complete with real-time English-Urdu translation.

3. **Dual Connection Engine (MySQL & SQLite):**
   * Pre-configured to target your local MySQL Server.
   * Seamlessly falls back to a self-seeding SQLite file database (`database/mediorbit.sqlite`) if MySQL is not yet configured or online, guaranteeing 100% plug-and-play functionality out-of-the-box.

---

## Codebase Directory Structure

```text
mediorbit/
├── index.php                 # View 1: NutriScan AI Page
├── wellness.php              # View 2: Wellness Guide Page
│
├── config/
│   └── db.php                # Database configuration & hybrid MySQL/SQLite adapter
│
├── database/
│   ├── schema.sql            # Core database schema & Urdu-English seed datasets
│   └── setup.php             # Self-seeding database setup wizard
│
├── includes/
│   ├── navbar.php            # Sticky header navigation
│   └── footer.php            # Minimalist medical footer
│
├── css/
│   └── style.css             # Main styling tokens, layouts, and animations
│
├── js/
│   └── main.js               # Frontend state, counters, dropzones, and AJAX PAGINATOR
│
└── uploads/                  # Temporary image upload storage
```

---

## Local Setup & Run Guide

### Option A: Zero Configuration (SQLite Plug-and-Play)
1. Copy or move this `mediorbit` directory into your local web server root (e.g., `C:\xampp\htdocs\mediorbit` or `C:\wamp64\www\mediorbit`).
2. Start XAMPP/WAMP (Apache module only).
3. Open your browser and navigate to:
   `http://localhost/mediorbit/index.php`
4. The system will detect that no MySQL connection has been configured yet, activate **SQLite Mode** dynamically, and display a top notification bar.
5. Click **"Run Database Setup Wizard Now"** or visit:
   `http://localhost/mediorbit/database/setup.php`
6. The database will automatically self-initialize and seed 100% of the bilingual conditions and articles, and your site is fully operational!

### Option B: Local MySQL Configuration
1. Open XAMPP/WAMP Control Panel and start **MySQL** and **Apache**.
2. If your MySQL credentials differ from standard values (default is `root` with no password), open `config/db.php` in a text editor and update:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'mediorbit');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   ```
3. Open your browser and navigate to the Setup Wizard:
   `http://localhost/mediorbit/database/setup.php`
4. The wizard will create the `mediorbit` database, construct the tables, and seed the clinical dataset automatically.
5. Open your portal at:
   `http://localhost/mediorbit/index.php`
