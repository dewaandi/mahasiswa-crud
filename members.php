<?php
require_once __DIR__ . '/inc/config.php';
$maha = new Mahasiswa();
$rows = $maha->getAll();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Daftar Mahasiswa</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header><h1>Daftar Mahasiswa</h1></header>
  <nav>
    <ul>
      <li><a href="members.php">List</a></li>
      <li><a href="create.php">Tambah</a></li>
    </ul>
  </nav>

  <?php Utility::showFlash(); ?>

  <table>
    <thead>
      <tr>
        <th>#</th><th>NIM</th><th>Nama</th><th>Prodi</th><th>Angkatan</th><th>Status</th><th>Foto</th><th>Aksi</th>
      </tr>
    </thead>
    <tbody>
    <?php if (empty($rows)): ?>
      <tr><td colspan="8">Belum ada data mahasiswa.</td></tr>
    <?php else: ?>
      <?php foreach ($rows as $r): ?>
      <tr>
        <td><?= htmlspecialchars($r['id']) ?></td>
        <td><?= htmlspecialchars($r['nim']) ?></td>
        <td><?= htmlspecialchars($r['nama']) ?></td>
        <td><?= htmlspecialchars($r['prodi']) ?></td>
        <td><?= htmlspecialchars($r['angkatan']) ?></td>
        <td><?= htmlspecialchars($r['status']) ?></td>
        <td>
          <?php if (!empty($r['foto'])): ?>
            <img src="uploads/<?= htmlspecialchars($r['foto']) ?>" alt="foto" style="height:60px;">
          <?php endif; ?>
        </td>
        <td>
          <a href="edit.php?id=<?= $r['id'] ?>">Edit</a> |
          <a href="delete.php?id=<?= $r['id'] ?>" onclick="return confirm('Hapus data?')">Delete</a>
        </td>
      </tr>
      <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
  </table>
</body>
</html>
