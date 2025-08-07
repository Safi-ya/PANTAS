<?php
require 'config.php';
if (!isset($_SESSION['admin'])) { header("Location: admin.html"); exit; }
if ($_SERVER['REQUEST_METHOD']==='POST') {
  $tajuk = trim($_POST['tajuk']);
  $arahan = trim($_POST['soalan']);
  $tarikh_hantar = $_POST['tarikh_hantar'];
  $stmt = $conn->prepare("INSERT INTO kerja (tajuk, arahan, tarikh_hantar) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $tajuk, $soalan, $tarikh_hantar);
  $stmt->execute();
  echo "<script>alert('Tugasan ditambah!'); window.location.href='admin_dashboard.php';</script>";
}
?>
<!DOCTYPE html><html lang="ms"><head><meta charset="UTF-8"><title>Tambah Tugasan</title><link rel="stylesheet" href="style.css"></head>
<body>
<header><h1>Tambah Tugasan</h1></header>
<main>
  <form method="POST" action="tambah_kerja.php">
    <label>Tajuk:</label><input name="tajuk" required>
    <label>Soalan:</label><textarea name="soalan" required></textarea>
    <label>Tarikh Hantar:</label><input type="date" name="tarikh_hantar" required>
    <button type="submit">Tambah</button>
  </form>
</main>
<footer><a href="admin_dashboard.php">← Dashboard Admin</a></footer>
</body></html>