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

Ini adalah proyek website **LanggarBoy** — brand apparel lokal yang gue buat dari nol. Full native, tanpa framework PHP, tanpa library JS. Server-side pake PHP, database MySQL, styling pake Tailwind CSS, dan interaksi frontend pake Vanilla JS murni.

Kenapa gue bikin ini? Karena gue pengen punya platform sendiri buat brand baju skena yang gue bangun. Minimalis, tajam, dan berani beda — sama seperti konsep brand-nya.

## Yang Bisa Dilakukan

| Fitur | Ceritanya |
|-------|-----------|
| 🎠 **Hero Carousel** | Auto-slide 3 slide, transisi mulus, dot navigasi |
| 🌙 **Dark Mode** | Toggle di navbar, tersimpan di localStorage, transisi smooth ke seluruh element |
| 📱 **Mobile Fullscreen Menu** | Begitu diklik, nutup full screen dengan animasi link muncul satu-satu |
| 🏷️ **Katalog Produk** | Gallery produk + filter per kategori + sorting harga |
| 🎨 **Detail Produk** | Pilih warna (color dot), pilih size, atur quantity, accordion info |
| 🛒 **Cart + Checkout** | Nambah ke keranjang via localStorage, form checkout disimpan ke database MySQL |
| 🔍 **Scroll Reveal** | Section muncul dengan animasi pas di-scroll pake IntersectionObserver |
| ❓ **FAQ Accordion** | Interaktif, buka satu nutup yang lain |
| 📝 **Blog** | Artikel dari database, siap develop lebih lanjut |
| ⚙️ **Admin Panel** | Simple admin buat lihat pesanan masuk, pake basic auth |

## Tech Stack

```
Frontend   : HTML5, Tailwind CSS (CDN), Vanilla JS
Backend    : PHP 8+ (native, no framework)
Database   : MySQL 8
Server     : Apache (XAMPP)
```

## Struktur Folder

```
C:\xampp\htdocs\MyBrand\
├── index.php              # Halaman utama
├── products.php           # Katalog produk
├── product.php            # Detail produk
├── about.php              # Tentang brand
├── faq.php                # FAQ
├── blog.php               # Journal
├── checkout.php           # Checkout
├── kontak.php             # Contact form handler
│
├── includes/              # Komponen yang dipake berulang
│   ├── config.php         # Config DB + helper
│   ├── functions.php      # Semua query logic
│   ├── header.php         # Head + opening HTML
│   ├── navbar.php         # Navigasi (desktop + mobile)
│   └── footer.php         # Footer + closing tag
│
├── assets/
│   ├── css/style.css      # Styling kustom
│   └── js/main.js         # Semua JavaScript
│
├── admin/
│   └── index.php          # Dashboard admin
│
└── database/
    ├── schema.sql         # Struktur tabel
    └── seed.sql           # Data contoh
```

## Database

Ada 8 tabel yang saling relasi:

```
categories      → Kategori produk
products        → Data produk (harga, deskripsi, label new/pre-order)
product_images  → Gambar (satu produk bisa banyak gambar)
product_colors  → Varian warna
product_sizes   → Varian ukuran
orders          → Data pesanan dan status
order_items     → Isi dari setiap pesanan
blog_posts      → Artikel blog
```

## Cara Jalanin

**Sebelum mulai, pastiin udah install XAMPP.**

```bash
# 1. Clone
cd C:\xampp\htdocs
git clone https://github.com/arhinzawahyu/MyBrand.git

# 2. Setup database
C:\xampp\mysql\bin\mysql.exe -u root < database\schema.sql
C:\xampp\mysql\bin\mysql.exe -u root < database\seed.sql

# 3. Buka XAMPP, start Apache + MySQL

# 4. Buka browser
http://localhost/MyBrand/
```

**Admin panel:** `http://localhost/MyBrand/admin/`
```
Username: admin
Password: langgarboy123
```

## Author

**Arhinza Wahyu**  
[github.com/arhinzawahyu](https://github.com/arhinzawahyu)

---

<div align="center">
  <p>Dibikin dengan 🩸, ☕, dan tekad buat bikin sesuatu yang gue banggain</p>
  <p>
    <a href="https://github.com/arhinzawahyu/MyBrand/issues">Report Bug</a>
    ·
    <a href="https://github.com/arhinzawahyu/MyBrand/issues">Saran Fitur</a>
  </p>
  <br/>
  <p><strong>Klaim Ga Emang Ga?</strong></p>
</div>
