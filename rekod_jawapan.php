<?php
require 'config.php';

// Pastikan hanya admin boleh akses
if (!isset($_SESSION['admin'])) {
    header("Location: admin.html");
    exit;
}

// Dapatkan rekod serahan lengkap (bersama nama murid, tajuk kerja & arahan tugasan)
$sql = "SELECT s.id, m.nama, k.tajuk, k.arahan, s.jawapan, s.tarikh_serah, s.penilaian, s.komen
        FROM serahan s
        JOIN murid m ON s.murid_id = m.id
        JOIN kerja k ON s.kerja_id = k.id
        ORDER BY s.tarikh_serah DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8" />
    <title>Rekod Jawapan Murid</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<header>
    <h1>Rekod Jawapan Murid</h1>
</header>
<main>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <section style="margin-bottom:2rem; padding-bottom:1rem; border-bottom:1px solid #ccc;">
                <h3><?= htmlspecialchars($row['tajuk']) ?></h3>
                <p><strong>Nama Murid:</strong> <?= htmlspecialchars($row['nama']) ?></p>

                <p><strong>Soalan / Arahan Tugasan:</strong><br><?= nl2br(htmlspecialchars($row['arahan'])) ?></p>

                <p><strong>Tarikh Serah:</strong> <?= htmlspecialchars($row['tarikh_serah']) ?></p>

                <p><strong>Jawapan Murid:</strong><br><?= nl2br(htmlspecialchars($row['jawapan'])) ?></p>

                <?php if ($row['penilaian'] || $row['komen']): ?>
                    <hr>
                    <p><strong>Penilaian:</strong> <?= htmlspecialchars($row['penilaian']) ?: '-' ?></p>
                    <p><strong>Komen:</strong><br><?= nl2br(htmlspecialchars($row['komen'])) ?: '-' ?></p>
                <?php else: ?>
                    <p><em>Belum dinilai.</em></p>
                <?php endif; ?>
            </section>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Tiada rekod serahan dijumpai.</p>
    <?php endif; ?>
</main>
<footer>
    <a href="admin_dashboard.php">← Kembali ke Dashboard</a>
</footer>
</body>
</html>
