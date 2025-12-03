<?php
require_once __DIR__ . '/inc/config.php';

function validateForm($post, $file) {
    $errors = [];

    // required
    if (empty(trim($post['nama'] ?? ''))) $errors[] = 'Nama wajib diisi.';
    if (empty(trim($post['nim'] ?? ''))) $errors[] = 'NIM wajib diisi.';
    if (empty($post['prodi'] ?? '')) $errors[] = 'Prodi wajib dipilih.';
    if (!isset($post['angkatan']) || !is_numeric($post['angkatan'])) $errors[] = 'Angkatan harus angka.';
    if (!in_array($post['status'] ?? '', ['aktif','nonaktif'])) $errors[] = 'Status tidak valid.';

    // file (opsional)
    if (!empty($file['foto']['name'])) {
        $allowed = ['image/jpeg','image/png'];
        if (!in_array($file['foto']['type'], $allowed)) {
            $errors[] = 'Tipe file harus JPG/PNG.';
        }
        if ($file['foto']['size'] > 2 * 1024 * 1024) {
            $errors[] = 'Ukuran file maksimal 2MB.';
        }
    }

    return $errors;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = validateForm($_POST, $_FILES);

    if (!empty($errors)) {
        Utility::redirect('create.php', implode(' ', $errors));
    }

    // handle file upload
    $fotoFilename = null;
    if (!empty($_FILES['foto']['name'])) {
        $tmp = $_FILES['foto']['tmp_name'];
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $fotoFilename = time() . '_' . bin2hex(random_bytes(5)) . '.' . $ext;
        $dest = __DIR__ . '/uploads/' . $fotoFilename;
        if (!move_uploaded_file($tmp, $dest)) {
            Utility::redirect('create.php', 'Gagal mengunggah file.');
        }
    }

    $m = new Mahasiswa();
    $data = [
        'nama' => trim($_POST['nama']),
        'nim' => trim($_POST['nim']),
        'prodi' => $_POST['prodi'],
        'angkatan' => (int)$_POST['angkatan'],
        'status' => $_POST['status'],
        'foto' => $fotoFilename
    ];

    try {
        $ok = $m->create($data);
        if ($ok) {
            Utility::redirect('members.php', 'Data berhasil disimpan.');
        } else {
            Utility::redirect('create.php', 'Gagal menyimpan data.');
        }
    } catch (PDOException $e) {
        // jika gagal (mis. duplicate NIM), hapus file baru agar tidak menumpuk
        if ($fotoFilename && file_exists(__DIR__ . '/uploads/' . $fotoFilename)) {
            unlink(__DIR__ . '/uploads/' . $fotoFilename);
        }
        Utility::redirect('create.php', 'Terjadi error: ' . $e->getMessage());
    }
}
Utility::redirect('create.php');
