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
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login — LanggarBoy Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script>
    tailwind.config = { theme: { extend: { colors: { signature: { DEFAULT: '#A31F34', light: '#D94A5E', dark: '#7A1425' } }, fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] } } } }
  </script>
  <style>body{font-family:'Inter',sans-serif;background:#f5f5f4;}</style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
  <div class="w-full max-w-sm">
    <div class="text-center mb-8">
      <div class="w-12 h-12 rounded-xl bg-signature flex items-center justify-center text-white text-lg font-bold mx-auto mb-3">LB</div>
      <h1 class="text-xl font-bold text-stone-800">LanggarBoy</h1>
      <p class="text-sm text-stone-400 mt-0.5">Admin Panel</p>
    </div>
    <form method="POST" class="bg-white border border-stone-200 rounded-xl shadow-sm p-8 space-y-5">
      <?php if ($error): ?>
        <div class="bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-lg"><?= $error ?></div>
      <?php endif; ?>
      <div>
        <label class="block text-sm font-medium text-stone-700 mb-1.5">Username</label>
        <input type="text" name="username" required class="w-full border border-stone-300 rounded-lg px-4 py-2.5 text-sm text-stone-800 placeholder-stone-400 focus:outline-none focus:border-signature focus:ring-1 focus:ring-signature/20" placeholder="admin">
      </div>
      <div>
        <label class="block text-sm font-medium text-stone-700 mb-1.5">Password</label>
        <input type="password" name="password" required class="w-full border border-stone-300 rounded-lg px-4 py-2.5 text-sm text-stone-800 placeholder-stone-400 focus:outline-none focus:border-signature focus:ring-1 focus:ring-signature/20" placeholder="••••••••">
      </div>
      <button type="submit" class="w-full bg-signature text-white rounded-lg px-4 py-2.5 text-sm font-medium hover:bg-signature-dark transition-colors">Masuk</button>
    </form>
  </div>
</body>
</html>
