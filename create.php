<?php
require_once __DIR__ . '/inc/config.php';
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Tambah Mahasiswa</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header><h1>Tambah Mahasiswa</h1></header>
<nav>
  <ul>
    <li><a href="members.php">List</a></li>
    <li><a href="create.php">Tambah</a></li>
  </ul>
</nav>

<?php Utility::showFlash(); ?>

<form action="save.php" method="post" enctype="multipart/form-data">
  <div class="form-row">
    <label>Nama*</label><br>
    <input type="text" name="nama" required maxlength="100">
  </div>
  <div class="form-row">
    <label>NIM*</label><br>
    <input type="text" name="nim" required maxlength="20">
  </div>
  <div class="form-row">
    <label>Prodi*</label><br>
    <select name="prodi" required>
      <option value="">--Pilih--</option>
      <option value="TI">TI</option>
      <option value="SI">SI</option>
      <option value="MI">MI</option>
    </select>
  </div>
  <div class="form-row">
    <label>Angkatan*</label><br>
    <input type="number" name="angkatan" required min="1900" max="2100">
  </div>
  <div class="form-row">
    <label>Status*</label><br>
    <select name="status" required>
      <option value="aktif">Aktif</option>
      <option value="nonaktif">Nonaktif</option>
    </select>
  </div>
  <div class="form-row">
    <label>Foto (jpg/png, &lt; 2MB)</label><br>
    <input type="file" name="foto" accept=".jpg,.jpeg,.png">
  </div>
  <button type="submit">Simpan</button>
</form>
</body>
</html>
