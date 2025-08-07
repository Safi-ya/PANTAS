<?php
require 'config.php';
if (!isset($_SESSION['murid'])) {
  header("Location: index.html");
  exit;
}
$murid = $_SESSION['murid'];

// Fungsi untuk papar header & nav
function paparHeader($tajuk) {
  global $murid;
  echo <<<HTML
<!DOCTYPE html>
<html lang="ms">
<head>
  <meta charset="UTF-8">
  <title>{$tajuk}</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
  <h1>PANTAS</h1>
</header>
<nav>
  <a href="profil.php">Profil</a> |
  <a href="prestasi.php">Prestasi</a> |
  <a href="kerja_pelajar.php">Kerja Sekolah</a> |
  <a href="rekod_penilaian_murid.php">Rekod Penilaian</a> |
  <a href="logout.php">Log Keluar</a>
</nav>
<main>
HTML;
}

// Fungsi untuk papar footer
function paparFooter() {
  echo <<<HTML
</main>
<footer>&copy; 2025 PANTAS</footer>
</body>
</html>
HTML;
}
?>

<?php
// Guna fungsi untuk papar kandungan utama
paparHeader("Dashboard Pelajar");
?>

<h2>Selamat Datang, <?= htmlspecialchars($murid['nama']) ?>!</h2>
<p>Selamat belajar dan menyelesaikan tugasan yang diberi 😎👍</p>

<?php
paparFooter();
?>