<div align="center">
  <br/>
  <h1>LANGGAR<span style="color:#A31F34">BOY</span></h1>
  <p><em>Bukan Sekadar Baju</em></p>
  <br/>
  <p>
    <img src="https://img.shields.io/badge/PHP-777BB4?style=flat&logo=php&logoColor=white" alt="PHP"/>
    <img src="https://img.shields.io/badge/MySQL-4479A1?style=flat&logo=mysql&logoColor=white" alt="MySQL"/>
    <img src="https://img.shields.io/badge/Tailwind_CSS-06B6D4?style=flat&logo=tailwind-css&logoColor=white" alt="Tailwind CSS"/>
    <img src="https://img.shields.io/badge/JavaScript-F7DF1E?style=flat&logo=javascript&logoColor=black" alt="JavaScript"/>
    <img src="https://img.shields.io/badge/License-MIT-blue" alt="MIT License"/>
  </p>
  <br/>
</div>

**LanggarBoy** is an e-commerce platform for a local apparel brand, built from scratch using native PHP, MySQL, Tailwind CSS, and vanilla JavaScript. This project serves as the official web presence for a streetwear brand that embraces minimalist aesthetics with a bold identity.

---

## Table of Contents

- [Features](#features)
- [Technology Stack](#technology-stack)
- [Screenshots](#screenshots)
- [Project Structure](#project-structure)
- [Database Schema](#database-schema)
- [Installation](#installation)
- [Admin Panel](#admin-panel)
- [Contributing](#contributing)
- [License](#license)
- [Author](#author)

---

## Features

### Frontend

| Feature | Description |
|---------|-------------|
| **Hero Carousel** | Auto-rotating banner with crossfade transitions and dot navigation |
| **Dark Mode** | Persistent theme toggle with smooth CSS transitions across all elements |
| **Fullscreen Mobile Menu** | Full-screen overlay with staggered link animations on mobile devices |
| **Product Catalog** | Grid gallery with category filtering (T-Shirts, Hoodies, Pants, Accessories) and 4 sorting options |
| **Product Detail** | Color variant selection, size chart, quantity adjustment, accordion-style information panels |
| **Cart & Checkout** | Client-side cart via localStorage with form submission persisted to MySQL |
| **Scroll Reveal** | Section entrance animations powered by IntersectionObserver |
| **FAQ Accordion** | Interactive expand/collapse with smooth height transitions |

### Backend

| Feature | Description |
|---------|-------------|
| **Native PHP** | Clean MVC-inspired structure using `includes/` for reusable components |
| **MySQL Database** | 8 relational tables managing products, categories, variants, orders, and blog content |
| **Admin Dashboard** | Order management interface protected by HTTP Basic Authentication |
| **Blog Engine** | Database-driven articles, ready for CMS expansion |

---

## Technology Stack

```
Layer       Technology
──────────  ───────────────────────────────
Frontend    HTML5, Tailwind CSS (CDN), Vanilla JavaScript
Backend     PHP 8+ (Native, no framework)
Database    MySQL 8
Server      Apache (XAMPP)
Design      Minimalist, monochrome with signature oxblood #A31F34
```

---

## Screenshots

| Page | Description |
|------|-------------|
| **Home** | Hero carousel, featured products grid, category cards, call-to-action section |
| **Products** | Gallery grid with category filter and sort controls |
| **Product Detail** | Color picker, size selector, quantity input, information accordion |
| **Checkout** | Cart review, customer form, order submission |
| **FAQ** | Accordion-style frequently asked questions |
| **About** | Brand story with core pillars (Design, Quality, Community) |
| **Admin** | Order table dashboard with database statistics |

---

## Project Structure

```
MyBrand/
│
├── *.php                  # Application pages
│
├── includes/              # Reusable components
│   ├── config.php         # Database configuration and helper functions
│   ├── functions.php      # Business logic and query layer
│   ├── header.php         # HTML document head and opening body
│   ├── navbar.php         # Responsive navigation bar
│   └── footer.php         # Closing document structure and scripts
│
├── assets/
│   ├── css/style.css      # Custom stylesheets
│   └── js/main.js         # Client-side application logic
│
├── admin/                 # Administrative interface
│   └── index.php          # Dashboard (Basic Auth protected)
│
└── database/
    ├── schema.sql         # Database structure (8 tables)
    └── seed.sql           # Sample dataset
```

---

## Database Schema

The application uses 8 interrelated MySQL tables:

```
categories (1) ──── (N) products (1) ──── (N) product_images
                              (1) ──── (N) product_colors
                              (1) ──── (N) product_sizes
                              (1) ──── (N) order_items (N) ──── (1) orders

blog_posts (independent)
contacts (independent)
```

### Table Details

| Table | Purpose | Key Fields |
|-------|---------|------------|
| `categories` | Product taxonomy | id, name, slug, image |
| `products` | Core product data | id, name, price, description, is_new, is_pre_order, category_id (FK) |
| `product_images` | Multiple product images | id, product_id (FK), url, sort_order |
| `product_colors` | Color variants | id, product_id (FK), name, hex |
| `product_sizes` | Size variants | id, product_id (FK), name |
| `orders` | Customer orders | id, customer_name, email, total, status (enum) |
| `order_items` | Order line items | id, order_id (FK), product_id (FK), size, color, quantity |
| `blog_posts` | Blog articles | id, title, slug, excerpt, content, image |

---

## Installation

### Prerequisites

- [XAMPP](https://www.apachefriends.org/) (Apache + MySQL + PHP 8+)
- [Git](https://git-scm.com/)

### Setup Instructions

```bash
# 1. Clone the repository
cd C:\xampp\htdocs
git clone https://github.com/arhinzawahyu/MyBrand.git

# 2. Import the database
C:\xampp\mysql\bin\mysql.exe -u root < MyBrand\database\schema.sql
C:\xampp\mysql\bin\mysql.exe -u root < MyBrand\database\seed.sql

# 3. Start XAMPP services
#    Apache → Start
#    MySQL  → Start

# 4. Access the application
http://localhost/MyBrand/
```

### Alternative: PHP Built-in Server

```bash
cd C:\xampp\htdocs\MyBrand
php -S localhost:8000
```

Then visit `http://localhost:8000`

---

## Admin Panel

Access the administrative interface at:

```
URL:      http://localhost/MyBrand/admin/
Username: admin
Password: langgarboy123
```

> **Security Notice:** The admin panel currently uses HTTP Basic Authentication. For production deployments, it is strongly recommended to implement a more robust authentication mechanism and update the default credentials.

---

## Contributing

Contributions are welcome. If you have suggestions for improvements or encounter any issues, please feel free to submit an issue or pull request.

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/your-feature`)
3. Commit your changes (`git commit -m 'Add some feature'`)
4. Push to the branch (`git push origin feature/your-feature`)
5. Open a pull request

---

## License

This project is licensed under the MIT License — see the [LICENSE](LICENSE) file for details.

---

## Author

**Arhinza Wahyu**

- GitHub: [@arhinzawahyu](https://github.com/arhinzawahyu)

---

<div align="center">
  <br/>
  <p>
    <a href="https://github.com/arhinzawahyu/MyBrand/issues">Report Issue</a>
    &nbsp;·&nbsp;
    <a href="https://github.com/arhinzawahyu/MyBrand/issues">Feature Request</a>
  </p>
  <br/>
</div>
