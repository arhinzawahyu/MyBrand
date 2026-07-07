<?php
require_once __DIR__ . '/includes/functions.php';
$title = 'Tentang — LanggarBoy';
include __DIR__ . '/includes/header.php';
?>

<div class="pt-28 pb-20">
  <div class="max-w-7xl mx-auto px-6">
    <div class="grid md:grid-cols-2 gap-16 items-center mb-24">
      <div class="reveal">
        <p class="text-xs uppercase tracking-[0.2em] text-stone-400 mb-3">Tentang</p>
        <h1 class="text-3xl md:text-6xl font-bold tracking-tight leading-tight">Bukan sekadar <span class="text-signature">baju</span></h1>
      </div>
      <div class="reveal" style="transition-delay: 0.15s">
        <div class="space-y-5 text-sm text-stone-600 dark:text-stone-400 leading-relaxed">
          <p>LanggarBoy lahir dari kegelisahan. Dari rasa bosan terhadap apa yang "seharusnya." Kami percaya fashion bukan cuma soal pakaian — tapi soal identitas, soal keberanian untuk tidak ikut arus.</p>
          <p>Setiap koleksi kami desain dengan pendekatan minimalis yang tajam. Garis-garis bersih, potongan yang presisi, detail yang nggak teriak tapi tetap berbicara. Ini untuk anak muda yang percaya bahwa kadang, kurang itu lebih — dan yang paling berani adalah mereka yang bisa diam tapi tetap diperhatikan.</p>
        </div>
      </div>
    </div>

    <div class="aspect-[2/1] bg-stone-200 dark:bg-stone-800 mb-24 flex items-center justify-center reveal">
      <span class="text-stone-400 text-sm uppercase tracking-[0.15em]">Visual Placeholder</span>
    </div>

    <div class="grid md:grid-cols-3 gap-12 mb-24">
      <?php foreach ([
        ['01', 'Desain', 'Setiap detail diperhitungkan. Dari pemilihan kain hingga jahitan akhir.'],
        ['02', 'Kualitas', 'Kami pilih bahan terbaik. Bukan cuma soal tampilan, tapi juga kenyamanan.'],
        ['03', 'Komunitas', 'Buat yang berani beda. LanggarBoy adalah gerakan, bukan sekadar label.'],
      ] as $i => $item): ?>
      <div class="reveal border-t border-stone-300 dark:border-stone-700 pt-6" style="transition-delay: <?= $i * 0.1 ?>s">
        <span class="text-3xl font-bold text-stone-200 dark:text-stone-800"><?= $item[0] ?></span>
        <h3 class="text-lg font-bold mt-3 mb-2"><?= $item[1] ?></h3>
        <p class="text-sm text-stone-500 leading-relaxed"><?= $item[2] ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
