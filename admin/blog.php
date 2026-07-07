<?php
require_once __DIR__ . '/includes/auth.php';
$db = getDB();
$title = 'Blog';
$posts = $db->query("SELECT * FROM blog_posts ORDER BY created_at DESC");
include __DIR__ . '/includes/header.php';
?>

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
  <div><h3 class="text-lg font-semibold text-stone-800">Blog</h3><p class="text-sm text-stone-400"><?= $posts->num_rows ?> artikel</p></div>
  <a href="<?= SITE_URL ?>/admin/blog-add.php" class="btn btn-primary">+ Tambah Artikel</a>
</div>

<div class="card overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full min-w-[500px]">
      <thead><tr class="bg-stone-50 border-b border-stone-200"><th class="table-header">Judul</th><th class="table-header hidden sm:table-cell">Tanggal</th><th class="table-header text-right">Aksi</th></tr></thead>
      <tbody>
        <?php while ($p = $posts->fetch_assoc()): ?>
        <tr class="border-t border-stone-100 hover:bg-stone-50/50">
          <td class="table-cell font-medium text-stone-800"><?= htmlspecialchars($p['title']) ?></td>
          <td class="table-cell hidden sm:table-cell text-stone-400 text-xs"><?= date('d M Y', strtotime($p['created_at'])) ?></td>
          <td class="table-cell text-right whitespace-nowrap">
            <a href="<?= SITE_URL ?>/admin/blog-edit.php?id=<?= $p['id'] ?>" class="btn btn-ghost text-xs py-1">Edit</a>
            <a href="<?= SITE_URL ?>/admin/blog-delete.php?id=<?= $p['id'] ?>" class="btn btn-ghost text-xs py-1 text-red-500 hover:text-red-700 hover:bg-red-50" onclick="return confirm('Hapus artikel?')">Hapus</a>
          </td>
        </tr>
        <?php endwhile; ?>
        <?php if ($posts->num_rows === 0): ?><tr><td colspan="3" class="text-center text-stone-400 py-10 text-sm">Belum ada artikel.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
