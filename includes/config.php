<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'langgarboy');
define('SITE_URL', '/MyBrand');
define('SITE_NAME', 'LanggarBoy');

function getDB() {
  static $db = null;
  if ($db === null) {
    try {
      $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
      if ($db->connect_error) throw new Exception($db->connect_error);
      $db->set_charset('utf8mb4');
    } catch (Exception $e) {
      die('Database connection failed: ' . $e->getMessage());
    }
  }
  return $db;
}

function rupiah($amount) {
  return 'Rp' . number_format($amount, 0, ',', '.');
}
