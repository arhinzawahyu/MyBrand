<?php
require_once __DIR__ . '/../includes/config.php';

if (isAdmin()) redirect(SITE_URL . '/admin/dashboard.php');

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $db = getDB();
  $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->bind_param('s', $_POST['username']);
  $stmt->execute();
  $user = $stmt->get_result()->fetch_assoc();

  if ($user && password_verify($_POST['password'], $user['password'])) {
    $_SESSION['admin_id'] = $user['id'];
    $_SESSION['admin_name'] = $user['full_name'];
    redirect(SITE_URL . '/admin/dashboard.php');
  } else {
    $error = 'Username atau password salah.';
  }
}
?>
<!DOCTYPE html>
<html lang="id" class="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login — LanggarBoy Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>body{font-family:'Inter',sans-serif;}</style>
</head>
<body class="bg-stone-950 text-stone-100 min-h-screen flex items-center justify-center">
  <div class="w-full max-w-sm mx-4">
    <div class="text-center mb-8">
      <h1 class="text-2xl font-bold">LANGGAR<span class="text-signature">BOY</span></h1>
      <p class="text-sm text-stone-500 mt-1">Admin Panel</p>
    </div>
    <form method="POST" class="bg-stone-900 border border-stone-800 rounded-xl p-8 space-y-5">
      <?php if ($error): ?>
        <p class="text-sm text-red-400 bg-red-900/20 border border-red-800 rounded-lg px-4 py-2"><?= $error ?></p>
      <?php endif; ?>
      <div>
        <label class="block text-sm font-medium text-stone-300 mb-1.5">Username</label>
        <input type="text" name="username" required class="w-full bg-stone-800/50 border border-stone-700 rounded-lg px-4 py-2.5 text-sm text-stone-100 placeholder-stone-500 focus:outline-none focus:border-signature transition-colors" placeholder="admin">
      </div>
      <div>
        <label class="block text-sm font-medium text-stone-300 mb-1.5">Password</label>
        <input type="password" name="password" required class="w-full bg-stone-800/50 border border-stone-700 rounded-lg px-4 py-2.5 text-sm text-stone-100 placeholder-stone-500 focus:outline-none focus:border-signature transition-colors" placeholder="••••••••">
      </div>
      <button type="submit" class="w-full bg-signature text-white rounded-lg px-4 py-2.5 text-sm font-medium hover:bg-signature-dark transition-colors">Masuk</button>
    </form>
  </div>
</body>
</html>
