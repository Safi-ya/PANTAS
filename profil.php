<?php
require 'config.php';

// Pastikan pelajar telah login
if (!isset($_SESSION['murid'])) {
    header("Location: index.html");
    exit;
}

// Ambil ID murid dari session
$id = $_SESSION['murid']['id'];

// Dapatkan maklumat penuh murid dari database
$stmt = $conn->prepare("SELECT * FROM murid WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$murid = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="ms">
<head>
  <meta charset="UTF-8">
  <title>Profil Pelajar</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Profil Pelajar</h1>
  </header>
  <main>
   <p><strong>Nama:</strong> <?= htmlspecialchars($murid['nama']) ?></p>
<p><strong>Kod Sekolah:</strong> <?= htmlspecialchars($murid['kod_sekolah']) ?></p>
<p><strong>Nombor Siri:</strong> <?= htmlspecialchars($murid['nombor_siri']) ?></p>
<p><strong>Jantina:</strong> <?= htmlspecialchars($murid['jantina'] ?? '-') ?></p>
<p><strong>Tarikh Lahir:</strong> <?= htmlspecialchars($murid['tarikh_lahir'] ?? '-') ?></p>
<p><strong>Kelas:</strong> <?= htmlspecialchars($murid['kelas'] ?? '-') ?></p>

    <p><a href="dashboard.php">← Kembali ke Dashboard</a></p>
  </main>
  <footer>&copy; 2025 PANTAS</footer>
</body>
</html>