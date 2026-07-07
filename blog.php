<?php
require_once __DIR__ . '/includes/functions.php';
$title = 'Journal — LanggarBoy';
$posts = getBlogPosts();
include __DIR__ . '/includes/header.php';
?>

<div class="pt-28 pb-20">
  <div class="max-w-7xl mx-auto px-6">
    <div class="mb-14 reveal">
      <p class="text-xs uppercase tracking-[0.2em] text-stone-400 mb-3">Journal</p>
      <h1 class="text-3xl md:text-5xl font-bold tracking-tight">Blog</h1>
      <p class="mt-4 text-sm text-stone-500 dark:text-stone-400">Catatan, inspirasi, dan obrolan seputar fashion dan budaya anak muda.</p>
    </div>

    <div class="grid md:grid-cols-3 gap-10">
      <?php foreach ($posts as $i => $post): ?>
      <article class="group cursor-pointer reveal" style="transition-delay: <?= $i * 0.1 ?>s">
        <div class="aspect-[4/3] bg-stone-200 dark:bg-stone-800 overflow-hidden mb-5">
          <div class="w-full h-full bg-cover bg-center group-hover:scale-105 transition-transform duration-700" style="background-image: url('<?= $post['image'] ?>')"></div>
        </div>
        <p class="text-xs text-stone-400 mb-2"><?= date('j F Y', strtotime($post['created_at'])) ?></p>
        <h3 class="text-base font-bold mb-2 group-hover:text-stone-500 transition-colors"><?= $post['title'] ?></h3>
        <p class="text-sm text-stone-500 leading-relaxed"><?= $post['excerpt'] ?></p>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
