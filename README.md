<div align="center">
  <br/>
  <h1>LANGGAR<span style="color:#A31F34">BOY</span></h1>
  <p><strong>Bukan Sekadar Baju</strong></p>
  <br/>
  <p>
    <img src="https://img.shields.io/badge/PHP-777BB4?style=flat&logo=php&logoColor=white" alt="PHP"/>
    <img src="https://img.shields.io/badge/MySQL-4479A1?style=flat&logo=mysql&logoColor=white" alt="MySQL"/>
    <img src="https://img.shields.io/badge/Tailwind_CSS-06B6D4?style=flat&logo=tailwind-css&logoColor=white" alt="Tailwind CSS"/>
    <img src="https://img.shields.io/badge/JavaScript-F7DF1E?style=flat&logo=javascript&logoColor=black" alt="JavaScript"/>
    <img src="https://img.shields.io/badge/license-MIT-blue" alt="License"/>
  </p>
  <br/>
</div>

---

## Tentang

**LanggarBoy** adalah brand apparel lokal yang lahir dari kegelisahan — dari rasa bosan terhadap apa yang "seharusnya." Minimalis, tajam, untuk anak muda yang berani beda.

Website ini dibangun dengan stack native: **PHP** di sisi server, **MySQL** untuk database, **Tailwind CSS** (via CDN) untuk styling, dan **Vanilla JavaScript** untuk interaktivitas.

## Fitur

| Fitur | Keterangan |
|-------|-----------|
| 🎠 **Hero Carousel** | Auto-slide dengan transisi mulus |
| 🌙 **Dark Mode** | Toggle dengan persistensi localStorage, transisi smooth |
| 📱 **Mobile Fullscreen Menu** | Overlay fullscreen dengan animasi fade-up |
| 🏷️ **Katalog Produk** | Gallery dengan filter kategori + sorting (terbaru/termurah/termahal) |
| 🎨 **Product Detail** | Pilihan warna, size, quantity, accordion info |
| 🛒 **Cart + Checkout** | localStorage cart → form checkout → simpan ke database |
| 🔍 **Scroll Reveal** | Animasi muncul saat scroll via IntersectionObserver |
| ❓ **FAQ Accordion** | Interaktif, smooth open/close |
| 📝 **Blog** | Daftar artikel dari database |
| ⚙️ **Admin Panel** | Lihat pesanan masuk (basic auth) |

## Tech Stack

```
Frontend   : HTML5, Tailwind CSS (CDN), Vanilla JS
Backend    : PHP 8+ (native, no framework)
Database   : MySQL 8 (via XAMPP)
Server     : Apache (XAMPP)
```

## Struktur Project

```
C:\xampp\htdocs\MyBrand\
├── index.php              # Beranda — hero carousel, featured, kategori, CTA
├── products.php           # Katalog produk — filter + sort
├── product.php            # Detail produk — warna, size, qty, cart
├── about.php              # Tentang brand
├── faq.php                # FAQ accordion interaktif
├── blog.php               # Journal / blog
├── checkout.php           # Keranjang + form checkout
├── kontak.php             # Handler form kontak
│
├── includes/
│   ├── config.php         # Koneksi database + helper rupiah()
│   ├── functions.php      # Query functions (produk, kategori, order)
│   ├── header.php         # HTML head + Tailwind CDN + navbar
│   ├── navbar.php         # Navigasi desktop + mobile overlay
│   └── footer.php         # Footer + JS loader
│
├── assets/
│   ├── css/style.css      # Custom CSS — dark mode, animasi, carousel
│   └── js/main.js         # JS — dark mode, carousel, menu, FAQ, cart
│
├── admin/
│   └── index.php          # Admin panel (basic auth)
│
├── database/
│   ├── schema.sql         # Struktur tabel (8 tables)
│   └── seed.sql           # Data dummy (8 produk, 4 kategori, 3 blog)
│
└── README.md
```

## Database

8 tabel MySQL:

```
categories      → Kategori produk (kaos, hoodie, celana, aksesoris)
products        → Produk (price, description, is_new, is_pre_order)
product_images  → Gambar per produk (multiple)
product_colors  → Varian warna per produk
product_sizes   → Varian ukuran per produk
orders          → Pesanan (customer data, status, total)
order_items     → Item dalam pesanan (product, size, color, qty)
blog_posts      → Artikel blog
```

## Instalasi Lokal

**Prerequisites:**
- XAMPP (Apache + MySQL + PHP)
- Git

**Langkah:**

```bash
# 1. Clone repo ke htdocs
cd C:\xampp\htdocs
git clone https://github.com/arhinzawahyu/MyBrand.git

# 2. Import database
C:\xampp\mysql\bin\mysql.exe -u root < database\schema.sql
C:\xampp\mysql\bin\mysql.exe -u root < database\seed.sql

# 3. Start Apache & MySQL via XAMPP Control Panel

# 4. Buka di browser
http://localhost/MyBrand/
```

**Login Admin:** `http://localhost/MyBrand/admin/`
```
Username: admin
Password: langgarboy123
```

## Screenshots

> *(Tambahin screenshot di sini kalo udah)*

| Halaman | Deskripsi |
|---------|-----------|
| Beranda | Hero carousel, featured products, kategori, CTA section |
| Produk | Gallery + filter kategori + sort harga |
| Detail | Pilih warna, size, quantity, tambah ke keranjang |
| Checkout | Form pesanan, simpan ke database |
| Admin | Lihat semua pesanan masuk |

## Author

**Arhinza Wahyu**  
[github.com/arhinzawahyu](https://github.com/arhinzawahyu)

---

<div align="center">
  <p>Dibuat dengan 🩸, ☕, dan 3 teguk kopi hitam</p>
  <p>
    <a href="https://github.com/arhinzawahyu/MyBrand/issues">Report Bug</a>
    ·
    <a href="https://github.com/arhinzawahyu/MyBrand/issues">Request Fitur</a>
  </p>
</div>
