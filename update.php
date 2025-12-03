<?php
require_once __DIR__ . '/inc/config.php';

function validateUpdate($post, $file) {
    $errors = [];
    if (empty(trim($post['nama'] ?? ''))) $errors[] = 'Nama wajib diisi.';
    if (empty(trim($post['nim'] ?? ''))) $errors[] = 'NIM wajib diisi.';
    if (empty($post['prodi'] ?? '')) $errors[] = 'Prodi wajib dipilih.';
    if (!isset($post['angkatan']) || !is_numeric($post['angkatan'])) $errors[] = 'Angkatan harus angka.';
    if (!in_array($post['status'] ?? '', ['aktif','nonaktif'])) $errors[] = 'Status tidak valid.';

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
    $id = (int)($_POST['id'] ?? 0);
    if (!$id) Utility::redirect('members.php', 'ID tidak valid.');

    $errors = validateUpdate($_POST, $_FILES);
    if (!empty($errors)) Utility::redirect("edit.php?id=$id", implode(' ', $errors));

    $m = new Mahasiswa();
    if (!$m->setById($id)) Utility::redirect('members.php', 'Data tidak ditemukan.');

    // handle foto baru
    $fotoFilename = $m->foto; // default keep old
    if (!empty($_FILES['foto']['name'])) {
        $tmp = $_FILES['foto']['tmp_name'];
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $fotoFilename = time() . '_' . bin2hex(random_bytes(5)) . '.' . $ext;
        $dest = __DIR__ . '/uploads/' . $fotoFilename;
        if (!move_uploaded_file($tmp, $dest)) {
            Utility::redirect("edit.php?id=$id", 'Gagal mengunggah file.');
        }
        // hapus file lama jika ada
        if (!empty($m->foto) && file_exists(__DIR__ . '/uploads/' . $m->foto)) {
            @unlink(__DIR__ . '/uploads/' . $m->foto);
        }
    }

    $data = [
        'nama' => trim($_POST['nama']),
        'nim' => trim($_POST['nim']),
        'prodi' => $_POST['prodi'],
        'angkatan' => (int)$_POST['angkatan'],
        'status' => $_POST['status'],
        'foto' => $fotoFilename
    ];

    try {
        $ok = $m->update($id, $data);
        if ($ok) Utility::redirect('members.php', 'Data berhasil diupdate.');
        else Utility::redirect("edit.php?id=$id", 'Gagal update data.');
    } catch (PDOException $e) {
        // jika upload baru berhasil tapi DB gagal, hapus file baru
        if (!empty($_FILES['foto']['name']) && isset($fotoFilename) && file_exists(__DIR__ . '/uploads/' . $fotoFilename)) {
            unlink(__DIR__ . '/uploads/' . $fotoFilename);
        }
        Utility::redirect("edit.php?id=$id", 'Terjadi error: ' . $e->getMessage());
    }
}
Utility::redirect('members.php');
