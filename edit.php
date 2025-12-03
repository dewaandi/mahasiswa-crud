<?php
require_once __DIR__ . '/inc/config.php';

$id = (int)($_GET['id'] ?? 0);
$m = new Mahasiswa();
if (!$m->setById($id)) {
    Utility::redirect('members.php', 'Data tidak ditemukan.');
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit Mahasiswa</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header><h1>Edit Mahasiswa</h1></header>
<nav>
  <ul>
    <li><a href="members.php">List</a></li>
    <li><a href="create.php">Tambah</a></li>
  </ul>
</nav>

<?php Utility::showFlash(); ?>

<form action="update.php" method="post" enctype="multipart/form-data">
  <input type="hidden" name="id" value="<?= htmlspecialchars($m->id) ?>">
  <div class="form-row">
    <label>Nama*</label><br>
    <input type="text" name="nama" required maxlength="100" value="<?= htmlspecialchars($m->nama) ?>">
  </div>
  <div class="form-row">
    <label>NIM*</label><br>
    <input type="text" name="nim" required maxlength="20" value="<?= htmlspecialchars($m->nim) ?>">
  </div>
  <div class="form-row">
    <label>Prodi*</label><br>
    <select name="prodi" required>
      <option value="">--Pilih--</option>
      <option value="TI" <?= $m->prodi === 'TI' ? 'selected' : '' ?>>TI</option>
      <option value="SI" <?= $m->prodi === 'SI' ? 'selected' : '' ?>>SI</option>
      <option value="MI" <?= $m->prodi === 'MI' ? 'selected' : '' ?>>MI</option>
    </select>
  </div>
  <div class="form-row">
    <label>Angkatan*</label><br>
    <input type="number" name="angkatan" required min="1900" max="2100" value="<?= htmlspecialchars($m->angkatan) ?>">
  </div>
  <div class="form-row">
    <label>Status*</label><br>
    <select name="status" required>
      <option value="aktif" <?= $m->status === 'aktif' ? 'selected' : '' ?>>Aktif</option>
      <option value="nonaktif" <?= $m->status === 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
    </select>
  </div>
  <div class="form-row">
    <label>Foto (biarkan kosong jika tidak ganti)</label><br>
    <?php if (!empty($m->foto)): ?>
      <img src="uploads/<?= htmlspecialchars($m->foto) ?>" style="height:80px;"><br>
    <?php endif; ?>
    <input type="file" name="foto" accept=".jpg,.jpeg,.png">
  </div>
  <button type="submit">Update</button>
</form>
</body>
</html>
