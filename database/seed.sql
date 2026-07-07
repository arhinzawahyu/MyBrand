USE langgarboy;

INSERT INTO categories (id, name, slug, image, product_count) VALUES
(1, 'Kaos', 'kaos', 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=600&q=80', 2),
(2, 'Hoodie', 'hoodie', 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=600&q=80', 2),
(3, 'Celana', 'celana', 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=600&q=80', 2),
(4, 'Aksesoris', 'aksesoris', 'https://images.unsplash.com/photo-1601924994987-69e26d50dc26?w=600&q=80', 2);

INSERT INTO products (id, name, slug, category_id, price, original_price, description, is_new, is_pre_order) VALUES
(1, 'Silhouette Tee', 'silhouette-tee', 1, 189000, NULL, 'Oversized cotton tee dengan signature branding. Dropped shoulders, reinforced seams. Pre-washed untuk worn-in feel klasik.', 1, 0),
(2, 'Langgar Hoodie', 'langgar-hoodie', 2, 359000, 399000, 'Heavyweight 400gsm french terry hoodie. Oversized fit, ribbed cuffs, kangaroo pocket dengan hidden media channel.', 0, 0),
(3, 'Fragment Balaclava', 'fragment-balaclava', 4, 89000, NULL, 'Seamless knit balaclava. One size fits all. Breathable cotton-acrylic blend.', 1, 0),
(4, 'Cargo Wide Pant', 'cargo-wide-pant', 3, 289000, NULL, 'Wide leg cargo pants dengan adjustable waist. Six-pocket configuration. Heavyweight cotton twill.', 0, 0),
(5, 'Distorted Logo Tee', 'distorted-logo-tee', 1, 199000, NULL, 'Graphic tee dengan distorted wordmark print. Regular fit, 180gsm combed ring-spun cotton.', 0, 0),
(6, 'Panel Cap', 'panel-cap', 4, 129000, NULL, 'Six-panel unstructured cap dengan embroidered logo. Adjustable brass buckle closure.', 0, 1),
(7, 'Relaxed Zip Hoodie', 'relaxed-zip-hoodie', 2, 389000, NULL, 'Full-zip hoodie heavyweight fleece. Dropped shoulder, side seam pockets, ribbed hem.', 0, 0),
(8, 'Pleated Wide Pant', 'pleated-wide-pant', 3, 269000, NULL, 'Pleated wide leg trousers elastic waist. Tapered leg. Lightweight linen-cotton blend.', 1, 0);

INSERT INTO product_images (product_id, url, sort_order) VALUES
(1, 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800&q=80', 0),
(1, 'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?w=800&q=80', 1),
(2, 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=800&q=80', 0),
(2, 'https://images.unsplash.com/photo-1578768079052-aa76e52ff62e?w=800&q=80', 1),
(3, 'https://images.unsplash.com/photo-1601924994987-69e26d50dc26?w=800&q=80', 0),
(3, 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=800&q=80', 1),
(4, 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=800&q=80', 0),
(4, 'https://images.unsplash.com/photo-1473966968600-fa801b869a1a?w=800&q=80', 1),
(5, 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=800&q=80', 0),
(5, 'https://images.unsplash.com/photo-1618354691373-d851c5c3a990?w=800&q=80', 1),
(6, 'https://images.unsplash.com/photo-1588850561407-ed78c282e89b?w=800&q=80', 0),
(6, 'https://images.unsplash.com/photo-1556306535-0f09a537f0a3?w=800&q=80', 1),
(7, 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=800&q=80', 0),
(7, 'https://images.unsplash.com/photo-1620799140408-edc6dcb6d633?w=800&q=80', 1),
(8, 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=800&q=80', 0),
(8, 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&q=80', 1);

INSERT INTO product_colors (product_id, name, hex) VALUES
(1, 'Black', '#0a0a0a'), (1, 'White', '#f5f5f5'), (1, 'Clay', '#8B7355'),
(2, 'Black', '#0a0a0a'), (2, 'Oxblood', '#6B1D2F'), (2, 'Grey', '#6B7280'),
(3, 'Black', '#0a0a0a'), (3, 'Burgundy', '#7A1425'),
(4, 'Black', '#0a0a0a'), (4, 'Olive', '#4A5D23'), (4, 'Khaki', '#C3B091'),
(5, 'White', '#f5f5f5'), (5, 'Black', '#0a0a0a'),
(6, 'Black', '#0a0a0a'), (6, 'Navy', '#1B2838'),
(7, 'Grey', '#6B7280'), (7, 'Black', '#0a0a0a'), (7, 'Oxblood', '#6B1D2F'),
(8, 'Black', '#0a0a0a'), (8, 'Cream', '#F5F0E8');

INSERT INTO product_sizes (product_id, name) VALUES
(1, 'S'), (1, 'M'), (1, 'L'), (1, 'XL'), (1, 'XXL'),
(2, 'M'), (2, 'L'), (2, 'XL'), (2, 'XXL'),
(3, 'One Size'),
(4, 'S'), (4, 'M'), (4, 'L'), (4, 'XL'),
(5, 'S'), (5, 'M'), (5, 'L'), (5, 'XL'),
(6, 'One Size'),
(7, 'M'), (7, 'L'), (7, 'XL'), (7, 'XXL'),
(8, 'S'), (8, 'M'), (8, 'L'), (8, 'XL');

INSERT INTO blog_posts (title, slug, excerpt, image) VALUES
('Mengapa Oversized Fit Masih Jadi Raja', 'oversized-fit-masih-raja', 'Dari runway sampai pinggir jalan, oversized fit nggak pernah mati. Ini alasan kenapa.', 'https://images.unsplash.com/photo-1607345366928-5ea672c38765?w=600&q=80'),
('Cara Mix & Match Basics biar Gak Keliatan Membosankan', 'mix-match-basics', 'Putih item doang? Bisa. Tapi ada caranya biar tetep menarik.', 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=600&q=80'),
('Perawatan Baju Biar Awet Sampai Bertahun-tahun', 'perawatan-baju-awet', 'Investasi baju skena jangan rusak gara-gara salah cuci. Simak tipsnya.', 'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?w=600&q=80');
