<?php
require 'config.php';
if (!isset($_SESSION['murid'])) {
    header("Location: index.html");
    exit;
}
$murid_id = $_SESSION['murid']['id'];

// Ambil tugasan yang belum dihantar
$stmt = $conn->prepare("
    SELECT * FROM kerja 
    WHERE id NOT IN (
        SELECT kerja_id FROM serahan WHERE murid_id = ?
    )
    ORDER BY tarikh_hantar ASC
");
$stmt->bind_param("i", $murid_id);
$stmt->execute();
$res = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="ms">
<head>
  <meta charset="UTF-8">
  <title>Kerja Sekolah Saya</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f4fdf8;
      margin: 0;
      padding: 0;
    }
    header {
      background: #0D3512;
      color: white;
      padding: 20px 0;
      text-align: center;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    header h1 {
      margin: 0;
      font-size: 2rem;
      letter-spacing: 1px;
    }
    main {
      padding: 30px 20px;
      max-width: 850px;
      margin: auto;
    }
    section {
      background: #ffffff;
      padding: 25px;
      border-radius: 12px;
      margin-bottom: 30px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      transition: transform 0.2s ease;
    }
    section:hover {
      transform: translateY(-3px);
    }
    section h3 {
      margin-top: 0;
      color: #0D3512;
      font-size: 1.5rem;
    }
    p {
      font-size: 1rem;
      margin: 10px 0;
      line-height: 1.5;
    }
    form {
      margin-top: 15px;
    }
    form label {
      font-weight: bold;
      display: block;
      margin-bottom: 5px;
    }
    form textarea {
      width: 100%;
      height: 120px;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 6px;
      resize: vertical;
      font-size: 1rem;
      background: #f9f9f9;
      box-sizing: border-box;
    }
    form button {
      margin-top: 12px;
      background: #0D3512;
      color: white;
      border: none;
      padding: 10px 22px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 1rem;
      font-weight: bold;
      transition: background 0.3s ease;
    }
    form button:hover {
      background: #196a2f;
    }
    footer {
      text-align: center;
      padding: 20px;
      background: #e0e0e0;
      margin-top: 50px;
    }
    footer a {
      text-decoration: none;
      color: #0D3512;
      font-weight: bold;
      transition: color 0.3s ease;
    }
    footer a:hover {
      color: #196a2f;
    }
  </style>
</head>
<body>

<header>
  <h1>Tugasan Belum Dihantar</h1>
</header>

<main>
  <?php if ($res->num_rows > 0): ?>
    <?php while ($k = $res->fetch_assoc()): ?>
      <section>
        <h3><?= htmlspecialchars($k['tajuk']) ?></h3>
        <p><strong>Soalan:</strong> <?= nl2br(htmlspecialchars($k['arahan'])) ?></p>
        <p><strong>Tarikh Hantar:</strong> <?= htmlspecialchars($k['tarikh_hantar']) ?></p>

        <form action="submit_kerja.php" method="POST">
          <label for="jawapan_<?= $k['id'] ?>">Jawapan Anda:</label>
          <textarea name="jawapan" id="jawapan_<?= $k['id'] ?>" placeholder="Tulis jawapan anda di sini..." required></textarea>
          <input type="hidden" name="kerja_id" value="<?= $k['id'] ?>">
          <button type="submit">📤 Hantar Tugasan</button>
        </form>
      </section>
    <?php endwhile; ?>
  <?php else: ?>
    <p style="text-align: center; font-size: 1.1rem;">✅ Semua tugasan telah dihantar. Tahniah!</p>
  <?php endif; ?>
</main>

<footer>
  <a href="dashboard.php">← Kembali ke Dashboard</a>
</footer>

</body>
</html>