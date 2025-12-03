<?php
require_once __DIR__ . '/inc/config.php';

$id = (int)($_GET['id'] ?? 0);
if (!$id) Utility::redirect('members.php', 'ID tidak valid.');

$m = new Mahasiswa();
if (!$m->setById($id)) Utility::redirect('members.php', 'Data tidak ditemukan.');

// hapus file foto jika ada
if (!empty($m->foto) && file_exists(__DIR__ . '/uploads/' . $m->foto)) {
    @unlink(__DIR__ . '/uploads/' . $m->foto);
}

try {
    $ok = $m->delete($id);
    if ($ok) Utility::redirect('members.php', 'Data berhasil dihapus.');
    else Utility::redirect('members.php', 'Gagal menghapus data.');
} catch (PDOException $e) {
    Utility::redirect('members.php', 'Terjadi error: ' . $e->getMessage());
}
