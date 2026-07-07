<?php
require_once __DIR__ . '/includes/auth.php';
$db = getDB();
$title = 'Messages';
$messages = $db->query("SELECT * FROM contacts ORDER BY created_at DESC");

if (isset($_GET['delete'])) {
  $db->query("DELETE FROM contacts WHERE id={$_GET['delete']}");
  redirect(SITE_URL . '/admin/contacts.php');
}

include __DIR__ . '/includes/header.php';
?>

<div class="card p-0 overflow-hidden">
  <?php if ($messages->num_rows === 0): ?>
    <p class="text-stone-500 text-sm py-10 text-center">Belum ada pesan.</p>
  <?php else: ?>
  <table class="w-full">
    <thead>
      <tr class="border-b border-stone-800 bg-stone-900/50">
        <th class="table-header">Nama</th>
        <th class="table-header hidden md:table-cell">Email</th>
        <th class="table-header">Pesan</th>
        <th class="table-header hidden md:table-cell">Tanggal</th>
        <th class="table-header text-right">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($m = $messages->fetch_assoc()): ?>
      <tr class="border-b border-stone-800/50 hover:bg-stone-800/30">
        <td class="table-cell font-medium"><?= htmlspecialchars($m['name']) ?></td>
        <td class="table-cell hidden md:table-cell text-stone-400"><?= htmlspecialchars($m['email']) ?></td>
        <td class="table-cell text-stone-400 max-w-xs truncate"><?= htmlspecialchars($m['message']) ?></td>
        <td class="table-cell hidden md:table-cell text-stone-400"><?= date('d M Y', strtotime($m['created_at'])) ?></td>
        <td class="table-cell text-right">
          <a href="?delete=<?= $m['id'] ?>" class="btn btn-ghost text-xs text-red-400" onclick="return confirm('Hapus pesan?')">Hapus</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
