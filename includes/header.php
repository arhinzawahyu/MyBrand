<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?? 'LanggarBoy — Bukan Sekadar Baju' ?></title>
  <meta name="description" content="Brand baju skena lokal. Minimalis, berani, buat yang beda.">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            signature: { DEFAULT: '#A31F34', light: '#D94A5E', dark: '#7A1425' },
          },
          fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
        }
      }
    }
  </script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="bg-white dark:bg-stone-950 text-stone-900 dark:text-stone-100 font-sans antialiased min-h-screen flex flex-col">
<?php require_once __DIR__ . '/navbar.php'; ?>
<main class="flex-1">
