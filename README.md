<div align="center">
  <br/>
  <h1>LANGGAR<span style="color:#A31F34">BOY</span></h1>
  <br/>
  <p>
    <img src="https://img.shields.io/badge/PHP-777BB4?style=flat&logo=php&logoColor=white"/>
    <img src="https://img.shields.io/badge/MySQL-4479A1?style=flat&logo=mysql&logoColor=white"/>
    <img src="https://img.shields.io/badge/Tailwind_CSS-06B6D4?style=flat&logo=tailwind-css&logoColor=white"/>
    <img src="https://img.shields.io/badge/JavaScript-F7DF1E?style=flat&logo=javascript&logoColor=black"/>
    <img src="https://img.shields.io/badge/License-MIT-blue"/>
  </p>
  <br/>
</div>

**LanggarBoy** adalah platform e-commerce brand apparel lokal yang gue bangun dari nol. Pure PHP native (no framework), MySQL database, Tailwind CSS, dan Vanilla JavaScript. Bukan cuma website — ini gerbang buat brand baju skena yang gue pengen bikin: minimalis, tajam, dan berani beda.

---

## Daftar Isi

- [Fitur](#fitur)
- [Tech Stack](#tech-stack)
- [Tampilan](#tampilan)
- [Struktur Project](#struktur-project)
- [Database](#database)
- [Instalasi](#instalasi)
- [Admin Panel](#admin-panel)
- [Author](#author)

---

## Fitur

### Frontend
| Fitur | Detail |
|-------|--------|
| Hero Carousel | Auto-slide 3 slide, transisi crossfade, navigasi dot |
| Dark Mode | Toggle dengan persistensi localStorage, transisi smooth di seluruh elemen |
| Mobile Fullscreen Menu | Overlay full layar dengan staggered link animation |
| Katalog Produk | Gallery grid + filter kategori (Kaos/Hoodie/Celana/Aksesoris) + 4 opsi sorting |
| Detail Produk | Pilih varian warna (color dot), pilih ukuran, atur quantity, accordion info |
| Cart & Checkout | LocalStorage cart → form checkout → data tersimpan ke database MySQL |
| Scroll Reveal | Animasi muncul via IntersectionObserver, tiap section timing berbeda |
| FAQ Accordion | Interaktif open/close dengan smooth animation |

### Backend
| Fitur | Detail |
|-------|--------|
| PHP Native | Tanpa framework, struktur MVC sederhana dengan `includes/` |
| MySQL Database | 8 tabel berelasi: produk, kategori, varian, pesanan, blog |
| Admin Panel | Dashboard sederhana lihat pesanan masuk, proteksi Basic Auth |
| Blog Engine | Artikel dari database, siap dikembangkan jadi CMS |

---

## Tech Stack

```
🖥️  Frontend   HTML5 + Tailwind CSS (CDN) + Vanilla JS
⚙️  Backend    PHP 8+ (Native, no framework)
🗄️  Database   MySQL 8
🌐  Server     Apache (XAMPP)
🎨  Desain     Minimalis, monokrom + signature oxblood #A31F34
```

---

## Tampilan

| Halaman | Deskripsi |
|---------|-----------|
| **Beranda** | Hero carousel, featured products grid, kategori cards, CTA section |
| **Produk** | Gallery grid dengan filter kategori + sort (terbaru/populer/murah/mahal) |
| **Detail Produk** | Pilihan warna, size chart, quantity, accordion detail & perawatan |
| **Checkout** | Review cart dari localStorage, form data diri, submit ke database |
| **FAQ** | Accordion interaktif 8 pertanyaan umum |
| **About** | Brand story + 3 pilar (Desain, Kualitas, Komunitas) |
| **Admin** | Dashboard tabel pesanan + statistik database |

---

## Struktur Project

```
MyBrand/
│
├── *.php                    # Halaman utama (index, products, product, about, etc.)
│
├── includes/                # Komponen reusable
│   ├── config.php           # Koneksi database + helper functions
│   ├── functions.php        # Business logic layer (queries, CRUD)
│   ├── header.php           # HTML head, Tailwind CDN, opening body
│   ├── navbar.php           # Navigation bar (static desktop, sticky mobile)
│   └── footer.php           # Footer + JavaScript loader
│
├── assets/
│   ├── css/style.css        # Custom styles (animations, dark mode, layout)
│   └── js/main.js           # All client-side logic
│
├── admin/                   # Admin panel
│   └── index.php            # Dashboard (Basic Auth protected)
│
└── database/
    ├── schema.sql           # Full database structure (8 tables)
    └── seed.sql             # Sample data (8 products, 4 categories, 3 blog posts)
```

---

## Database

Diagram relasi 8 tabel MySQL:

```
categories (1) ──── (N) products (1) ──── (N) product_images
                              (1) ──── (N) product_colors
                              (1) ──── (N) product_sizes
                              (1) ──── (N) order_items (N) ──── (1) orders

blog_posts (standalone)
contacts (standalone)
```

**Detail:**
- **categories** — Nama kategori + slug + image
- **products** — Data produk (harga, deskripsi, label new/pre-order, FK ke categories)
- **product_images** — Multiple gambar per produk (sort_order)
- **product_colors** — Varian warna (name + hex)
- **product_sizes** — Varian ukuran (S/M/L/XL/XXL/One Size)
- **orders** — Data pelanggan + total + status (pending → confirmed → shipped → completed)
- **order_items** — Item dalam pesanan (FK ke orders & products)
- **blog_posts** — Artikel blog

---

## Instalasi

### Prerequisites
- [XAMPP](https://www.apachefriends.org/) (Apache + MySQL + PHP 8+)
- [Git](https://git-scm.com/)

### Langkah Instalasi

```bash
# 1. Clone repositori
cd C:\xampp\htdocs
git clone https://github.com/arhinzawahyu/MyBrand.git

# 2. Import database
C:\xampp\mysql\bin\mysql.exe -u root < MyBrand\database\schema.sql
C:\xampp\mysql\bin\mysql.exe -u root < MyBrand\database\seed.sql

# 3. Jalankan XAMPP
#    Start Apache → Start MySQL

# 4. Buka di browser
http://localhost/MyBrand/
```

### Atau pake PHP Built-in Server

```bash
cd C:\xampp\htdocs\MyBrand
php -S localhost:8000
```

Buka `http://localhost:8000`

---

## Admin Panel

**URL:** `http://localhost/MyBrand/admin/`

**Login:**
```
Username: admin
Password: langgarboy123
```

> ⚠️ **Catatan:** Basic Auth ini cuma proteksi sederhana. Untuk production, ganti password dan implementasi authentication yang lebih aman.

---

## Author

Dibangun dengan 🩸, ☕, dan tekad buat bikin sesuatu yang bisa gue banggain.

**Arhinza Wahyu**
- GitHub: [@arhinzawahyu](https://github.com/arhinzawahyu)

---

<div align="center">
  <br/>
  <p><em>"Klaim Ga Emang Ga?"</em></p>
  <br/>
  <p>
    <a href="https://github.com/arhinzawahyu/MyBrand/issues">🐛 Report Bug</a>
    &nbsp;·&nbsp;
    <a href="https://github.com/arhinzawahyu/MyBrand/issues">💡 Saran Fitur</a>
    &nbsp;·&nbsp;
    <a href="https://github.com/arhinzawahyu/MyBrand">⭐ Star</a>
  </p>
  <br/>
</div>
