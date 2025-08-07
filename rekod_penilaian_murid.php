<?php
require 'config.php';
if (!isset($_SESSION['murid'])) {
    header("Location: index.html");
    exit;
}
$murid_id = $_SESSION['murid']['id'];

$stmt = $conn->prepare("
  SELECT k.tajuk, s.jawapan, s.penilaian, s.komen
  FROM serahan s
  JOIN kerja k ON s.kerja_id = k.id
  WHERE s.murid_id = ?
  ORDER BY s.tarikh_serah DESC
");
$stmt->bind_param("i", $murid_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ms">
<head>
  <meta charset="UTF-8">
  <title>Rekod Penilaian</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header><h1>Rekod Penilaian dan Komen Cikgu</h1></header>
<main>
  <?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
      <section>
        <h3><?= htmlspecialchars($row['tajuk']) ?></h3>
        <p><strong>Jawapan Anda:</strong><br><?= nl2br(htmlspecialchars($row['jawapan'])) ?></p>
        <p><strong>Penilaian:</strong> <?= htmlspecialchars($row['penilaian'] ?: 'Belum dinilai') ?></p>
        <p><strong>Komen Cikgu:</strong><br><?= nl2br(htmlspecialchars($row['komen'] ?: 'Tiada komen') ) ?></p>
      </section>
      <hr>
    <?php endwhile; ?>
  <?php else: ?>
    <p>Tiada rekod penilaian untuk anda setakat ini.</p>
  <?php endif; ?>
</main>
<footer><a href="dashboard.php">← Kembali ke Dashboard</a></footer>
</body>
</html>
