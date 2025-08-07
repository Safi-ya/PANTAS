<?php
require 'config.php';
if (!isset($_SESSION['murid'])) {
    header("Location: index.html");
    exit;
}
$murid = $_SESSION['murid'];
$stmt = $conn->prepare("SELECT subjek, markah FROM prestasi WHERE murid_id = ?");
$stmt->bind_param("i", $murid['id']);
$stmt->execute();
$res = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="ms">
<head>
  <meta charset="UTF-8">
  <title>Prestasi Pelajar</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header><h1>Prestasi Anda</h1></header>
<main>
  <?php if ($res->num_rows > 0): ?>
    <ul>
      <?php while ($row = $res->fetch_assoc()): 
        $markah = intval($row['markah']);
        if ($markah >= 85) $gred = 'Sangat Memuaskan';
        elseif ($markah >= 70) $gred = 'Memuaskan';
        elseif ($markah >= 50) $gred = 'Kurang Memuaskan';
        else $gred = 'Buruk';
      ?>
        <li><?= htmlspecialchars($row['subjek']) ?>: <?= $markah ?> — <em><?= $gred ?></em></li>
      <?php endwhile; ?>
    </ul>
  <?php else: ?>
    <p>Tiada rekod prestasi ditemui.</p>
  <?php endif; ?>
  <p><a href="dashboard.php">← Kembali ke Dashboard</a></p>
</main>
<footer>&copy; 2025 PANTAS</footer>
</body>
</html>