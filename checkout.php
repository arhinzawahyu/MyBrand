<?php
require_once __DIR__ . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'] ?? '';
  $email = $_POST['email'] ?? '';
  $phone = $_POST['phone'] ?? '';
  $address = $_POST['address'] ?? '';
  $notes = $_POST['notes'] ?? '';
  $items = json_decode($_POST['items'] ?? '[]', true);
  $total = array_reduce($items, fn($sum, $i) => $sum + ($i['price'] * $i['quantity']), 0);

  if ($name && $email && $total > 0) {
    $order_id = createOrder(
      ['name' => $name, 'email' => $email, 'phone' => $phone, 'address' => $address, 'notes' => $notes, 'total' => $total],
      $items
    );
    $success = true;
  } else {
    $error = 'Harap isi semua field yang diperlukan.';
  }
}

$title = 'Checkout — LanggarBoy';
include __DIR__ . '/includes/header.php';
?>

<div class="pt-28 pb-20">
  <div class="max-w-3xl mx-auto px-6">
    <?php if (isset($success)): ?>
    <div class="text-center py-20 reveal">
      <h2 class="text-3xl font-bold mb-4">Pesanan Berhasil!</h2>
      <p class="text-stone-500 mb-2">Terima kasih, <?= htmlspecialchars($name) ?>.</p>
      <p class="text-stone-500 mb-8">Kami akan konfirmasi via email dalam 1x24 jam.</p>
      <a href="<?= SITE_URL ?>/products.php" class="inline-block bg-stone-900 dark:bg-stone-100 text-white dark:text-stone-900 px-8 py-3 text-sm uppercase tracking-[0.15em] font-medium">Lanjut Belanja</a>
    </div>
    <?php else: ?>
    <div class="reveal">
      <p class="text-xs uppercase tracking-[0.2em] text-stone-400 mb-2">Checkout</p>
      <h1 class="text-3xl md:text-5xl font-bold tracking-tight mb-10">Keranjang</h1>
    </div>

    <?php if (isset($error)): ?>
    <p class="text-red-500 text-sm mb-4"><?= $error ?></p>
    <?php endif; ?>

    <div class="space-y-4 mb-10" id="cartItems"></div>

    <form method="POST" class="space-y-5 reveal">
      <input type="hidden" name="items" id="cartInput">
      <div class="grid md:grid-cols-2 gap-5">
        <input type="text" name="name" placeholder="Nama Lengkap *" required class="w-full border border-stone-300 dark:border-stone-700 bg-transparent px-4 py-3 text-sm focus:outline-none focus:border-stone-900 dark:focus:border-stone-100">
        <input type="email" name="email" placeholder="Email *" required class="w-full border border-stone-300 dark:border-stone-700 bg-transparent px-4 py-3 text-sm focus:outline-none focus:border-stone-900 dark:focus:border-stone-100">
      </div>
      <input type="tel" name="phone" placeholder="No. HP" class="w-full border border-stone-300 dark:border-stone-700 bg-transparent px-4 py-3 text-sm focus:outline-none focus:border-stone-900 dark:focus:border-stone-100">
      <textarea name="address" placeholder="Alamat Lengkap" rows="3" class="w-full border border-stone-300 dark:border-stone-700 bg-transparent px-4 py-3 text-sm focus:outline-none focus:border-stone-900 dark:focus:border-stone-100"></textarea>
      <textarea name="notes" placeholder="Catatan (opsional)" rows="2" class="w-full border border-stone-300 dark:border-stone-700 bg-transparent px-4 py-3 text-sm focus:outline-none focus:border-stone-900 dark:focus:border-stone-100"></textarea>

      <div class="flex justify-between items-center pt-4 border-t border-stone-200 dark:border-stone-800">
        <span class="text-lg font-bold" id="cartTotal">Total: Rp0</span>
        <button type="submit" class="bg-stone-900 dark:bg-stone-100 text-white dark:text-stone-900 px-8 py-3 text-sm uppercase tracking-[0.15em] font-medium hover:bg-stone-700 transition-colors">
          Pesan Sekarang
        </button>
      </div>
    </form>
    <?php endif; ?>
  </div>
</div>

<script>
function renderCart() {
  const cart = JSON.parse(localStorage.getItem('langgarboy_cart') || '[]');
  const container = document.getElementById('cartItems');
  const totalEl = document.getElementById('cartTotal');
  const input = document.getElementById('cartInput');

  if (cart.length === 0 && !document.querySelector('.text-center.py-20')) {
    container.innerHTML = '<p class="text-stone-400 text-sm text-center py-10">Keranjang kosong.</p>';
    if (totalEl) totalEl.textContent = 'Total: Rp0';
    return;
  }

  let html = '';
  let total = 0;
  cart.forEach((item, i) => {
    total += item.price * item.quantity;
    html += `
      <div class="flex items-center justify-between border border-stone-200 dark:border-stone-800 p-4">
        <div>
          <p class="text-sm font-medium">${item.name}</p>
          <p class="text-xs text-stone-500">${item.size ? item.size + ' / ' : ''}${item.color || ''} x ${item.quantity}</p>
        </div>
        <div class="text-right">
          <p class="text-sm font-medium">Rp${(item.price * item.quantity).toLocaleString('id-ID')}</p>
          <button onclick="removeFromCart(${i})" class="text-[10px] uppercase tracking-wider text-stone-400 hover:text-red-500">Hapus</button>
        </div>
      </div>
    `;
  });

  container.innerHTML = html;
  if (totalEl) totalEl.textContent = 'Total: Rp' + total.toLocaleString('id-ID');
  if (input) input.value = JSON.stringify(cart);
}

function removeFromCart(index) {
  let cart = JSON.parse(localStorage.getItem('langgarboy_cart') || '[]');
  cart.splice(index, 1);
  localStorage.setItem('langgarboy_cart', JSON.stringify(cart));
  renderCart();
}

renderCart();
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
