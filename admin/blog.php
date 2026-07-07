<?php
require_once __DIR__ . '/includes/auth.php';
$db = getDB();
$title = 'Blog';
$posts = $db->query("SELECT * FROM blog_posts ORDER BY created_at DESC");

include __DIR__ . '/includes/header.php';
?>

<div class="flex items-center justify-between mb-6">
  <p class="text-sm text-stone-400"><?= $posts->num_rows ?> artikel</p>
  <a href="<?= SITE_URL ?>/admin/blog-add.php" class="btn btn-primary">+ Tambah Artikel</a>
</div>

<div class="card p-0 overflow-hidden">
  <table class="w-full">
    <thead>
      <tr class="border-b border-stone-800 bg-stone-900/50">
        <th class="table-header">Judul</th>
        <th class="table-header hidden md:table-cell">Tanggal</th>
        <th class="table-header text-right">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($p = $posts->fetch_assoc()): ?>
      <tr class="border-b border-stone-800/50 hover:bg-stone-800/30">
        <td class="table-cell font-medium"><?= htmlspecialchars($p['title']) ?></td>
        <td class="table-cell hidden md:table-cell text-stone-400"><?= date('d M Y', strtotime($p['created_at'])) ?></td>
        <td class="table-cell text-right">
          <a href="<?= SITE_URL ?>/admin/blog-edit.php?id=<?= $p['id'] ?>" class="btn btn-ghost text-xs">Edit</a>
          <a href="<?= SITE_URL ?>/admin/blog-delete.php?id=<?= $p['id'] ?>" class="btn btn-ghost text-xs text-red-400" onclick="return confirm('Hapus artikel?')">Hapus</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
