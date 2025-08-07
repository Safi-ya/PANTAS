<?php
require 'config.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin.html");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sid = intval($_POST['serah_id']);
    $pen = trim($_POST['penilaian']);
    $komen = trim($_POST['komen']);

    $stmt = $conn->prepare("UPDATE serahan SET penilaian=?, komen=? WHERE id=?");
    $stmt->bind_param("ssi", $pen, $komen, $sid);
    $stmt->execute();

    echo "<script>alert('Nilai disimpan!'); window.location.href='nilai_kerja.php';</script>";
    exit;
}

$res = $conn->query("
    SELECT s.id AS sid, m.nama, k.tajuk, s.jawapan 
    FROM serahan s 
    JOIN murid m ON s.murid_id = m.id 
    JOIN kerja k ON s.kerja_id = k.id
    WHERE s.penilaian IS NULL OR s.penilaian = ''
");
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Penilaian Tugasan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Penilaian Tugasan</h1>
</header>

<main>
    <?php while ($s = $res->fetch_assoc()): ?>
        <section>
            <h3><?= htmlspecialchars($s['tajuk']) ?></h3>
            <p><strong>Pelajar:</strong> <?= htmlspecialchars($s['nama']) ?></p>
            <p><strong>Jawapan:</strong><br><?= nl2br(htmlspecialchars($s['jawapan'])) ?></p>
            <form method="POST" action="">
                <input type="hidden" name="serah_id" value="<?= $s['sid'] ?>">
                <label>Penilaian (contoh: Sangat Baik / Memuaskan):</label><br>
                <input type="text" name="penilaian" required><br><br>
                <label>Komen:</label><br>
                <textarea name="komen" rows="4" cols="50"></textarea><br><br>
                <button type="submit">Simpan Nilai</button>
            </form>
        </section>
        <hr>
    <?php endwhile; ?>
</main>

<footer>
    &copy; 2025 PANTAS
</footer>

</body>
</html>
