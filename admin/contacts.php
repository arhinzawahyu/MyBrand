<?php
require_once __DIR__ . '/includes/auth.php';
$db = getDB();
$title = 'Messages';

if (isset($_GET['delete'])) { $db->query("DELETE FROM contacts WHERE id={$_GET['delete']}"); redirect(SITE_URL . '/admin/contacts.php'); }
$messages = $db->query("SELECT * FROM contacts ORDER BY created_at DESC");

include __DIR__ . '/includes/header.php';
?>

<div class="card overflow-hidden">
  <?php if ($messages->num_rows === 0): ?>
    <p class="text-stone-400 text-sm py-12 text-center">Belum ada pesan.</p>
  <?php else: ?>
  <div class="overflow-x-auto">
    <table class="w-full min-w-[500px]">
      <thead><tr class="bg-stone-50 border-b border-stone-200"><th class="table-header">Nama</th><th class="table-header hidden sm:table-cell">Email</th><th class="table-header">Pesan</th><th class="table-header hidden sm:table-cell">Tanggal</th><th class="table-header text-right">Aksi</th></tr></thead>
      <tbody>
        <?php while ($m = $messages->fetch_assoc()): ?>
        <tr class="border-t border-stone-100 hover:bg-stone-50/50">
          <td class="table-cell font-medium text-stone-800"><?= htmlspecialchars($m['name']) ?></td>
          <td class="table-cell hidden sm:table-cell text-stone-500"><?= htmlspecialchars($m['email']) ?></td>
          <td class="table-cell text-stone-600 max-w-[200px] truncate"><?= htmlspecialchars($m['message']) ?></td>
          <td class="table-cell hidden sm:table-cell text-stone-400 text-xs"><?= date('d M Y', strtotime($m['created_at'])) ?></td>
          <td class="table-cell text-right"><a href="?delete=<?= $m['id'] ?>" class="btn btn-ghost text-xs py-1 text-red-500 hover:text-red-700 hover:bg-red-50" onclick="return confirm('Hapus pesan?')">Hapus</a></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
