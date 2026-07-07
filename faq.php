<?php
require_once __DIR__ . '/includes/functions.php';
$title = 'FAQ — LanggarBoy';
include __DIR__ . '/includes/header.php';

$faqs = [
  ['Gimana cara order?', 'Pilih produk yang kamu mau, tentukan size dan warna, lalu klik Tambah ke Keranjang. Lanjut ke checkout dan isi data pengiriman. Kami akan konfirmasi via email/WA.'],
  ['Berapa lama pengiriman?', 'Untuk ready stock, kami proses 1x24 jam lalu kirim via J&T / SiCepat. Estimasi sampai 2-5 hari kerja tergantung lokasi.'],
  ['Gimana sistem pre-order?', 'Pre-order berlaku untuk produk tertentu yang ditandai label Pre-Order. Waktu produksi 1-2 minggu, lalu langsung kami kirim.'],
  ['Bisa return atau exchange?', 'Bisa dalam 7 hari setelah barang diterima, dengan syarat barang masih dalam kondisi original (belum dipakai, label masih intact). Kami tidak menerima return karena salah ukuran — pastikan cek size guide!'],
  ['Size chart-nya gimana?', 'Kami pakai standar Asian fit dengan cutting oversized khusus untuk beberapa model. Detail lengkap ada di halaman Size Guide.'],
  ['Minimal belanja berapa?', 'Nggak ada minimal belanja. Tapi free shipping minimal Rp300.000 untuk area Jabodetabek dan Rp400.000 untuk luar Jabodetabek.'],
  ['Cara perawatan produk?', 'Cuci dengan air dingin, jangan pakai pemutih, jangan direndam terlalu lama, setrika dengan suhu rendah. Biar awet, balik pakaian sebelum dicuci.'],
  ['Ada diskon untuk pembelian pertama?', 'Follow Instagram @LanggarBoy dan pantau terus — kami rutin ngasih promo dan early access buat followers.'],
];
?>

<div class="pt-28 pb-20">
  <div class="max-w-3xl mx-auto px-6">
    <div class="mb-14 reveal">
      <p class="text-xs uppercase tracking-[0.2em] text-stone-400 mb-3">Info</p>
      <h1 class="text-3xl md:text-5xl font-bold tracking-tight">FAQ</h1>
      <p class="mt-4 text-sm text-stone-500 dark:text-stone-400 leading-relaxed">Pertanyaan yang sering diajukan. Kalo masih ada yang kurang, DM kami di Instagram.</p>
    </div>

    <div class="space-y-3">
      <?php foreach ($faqs as $i => $faq): ?>
      <div class="faq-item border border-stone-200 dark:border-stone-800">
        <button class="faq-btn w-full flex items-center justify-between px-6 py-5 text-left text-sm font-medium hover:bg-stone-50 dark:hover:bg-stone-900/50 transition-colors">
          <span><?= $faq[0] ?></span>
          <span class="faq-icon text-lg transition-transform duration-300">+</span>
        </button>
        <div class="faq-answer overflow-hidden max-h-0 transition-all duration-300">
          <p class="px-6 pb-5 text-sm text-stone-500 dark:text-stone-400 leading-relaxed"><?= $faq[1] ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="mt-16 text-center border-t border-stone-200 dark:border-stone-800 pt-10 reveal">
      <a href="<?= SITE_URL ?>/products.php" class="inline-block bg-stone-900 dark:bg-stone-100 text-white dark:text-stone-900 px-8 py-3 text-sm uppercase tracking-[0.15em] font-medium hover:bg-stone-700 dark:hover:bg-stone-300 transition-colors">Mulai Belanja</a>
    </div>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
