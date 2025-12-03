<?php
// class/Mahasiswa.php
class Mahasiswa {
    protected Database $db;
    public ?int $id = null;
    public string $nama = '';
    public string $nim = '';
    public string $prodi = '';
    public int $angkatan = 0;
    public string $status = 'aktif';
    public ?string $foto = null;

    public function __construct() {
        $this->db = new Database();
    }

    // Ambil semua mahasiswa
    public function getAll(): array {
        $sql = "SELECT * FROM mahasiswa ORDER BY id ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    // Ambil 1 mahasiswa by id
    public function setById(int $id): bool {
        $sql = "SELECT * FROM mahasiswa WHERE id = :id LIMIT 1";
        $stmt = $this->db->query($sql, ['id' => $id]);
        $row = $stmt->fetch();
        if ($row) {
            $this->id = (int)$row['id'];
            $this->nama = $row['nama'];
            $this->nim = $row['nim'];
            $this->prodi = $row['prodi'];
            $this->angkatan = (int)$row['angkatan'];
            $this->status = $row['status'];
            $this->foto = $row['foto'];
            return true;
        }
        return false;
    }

    // Simpan mahasiswa baru
    public function create(array $data): bool {
        $sql = "INSERT INTO mahasiswa (nama, nim, prodi, angkatan, status, foto)
                VALUES (:nama, :nim, :prodi, :angkatan, :status, :foto)";
        $params = [
            'nama' => $data['nama'],
            'nim' => $data['nim'],
            'prodi' => $data['prodi'],
            'angkatan' => $data['angkatan'],
            'status' => $data['status'],
            'foto' => $data['foto'] ?? null,
        ];
        $stmt = $this->db->conn->prepare($sql);
        return $stmt->execute($params);
    }

    // Update mahasiswa
    public function update(int $id, array $data): bool {
        $sql = "UPDATE mahasiswa SET
                    nama = :nama,
                    nim = :nim,
                    prodi = :prodi,
                    angkatan = :angkatan,
                    status = :status,
                    foto = :foto
                WHERE id = :id";
        $params = [
            'nama' => $data['nama'],
            'nim' => $data['nim'],
            'prodi' => $data['prodi'],
            'angkatan' => $data['angkatan'],
            'status' => $data['status'],
            'foto' => $data['foto'] ?? null,
            'id' => $id
        ];
        $stmt = $this->db->conn->prepare($sql);
        return $stmt->execute($params);
    }

    // Hapus mahasiswa
    public function delete(int $id): bool {
        // Jika ada file foto di record, caller bisa menghapus filenya (opsional)
        $sql = "DELETE FROM mahasiswa WHERE id = :id";
        $stmt = $this->db->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
