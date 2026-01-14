<?php
include "koneksi_akademik.php";

/* Validasi parameter */
if (!isset($_GET['nim'])) {
    header("Location: mahasiswa.php");
    exit();
}

$nim = $_GET['nim'];

/* Ambil data mahasiswa */
$stmt = $db->prepare("SELECT * FROM mahasiswa WHERE nim = ?");
$stmt->bind_param("i", $nim);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    echo "Data mahasiswa tidak ditemukan!";
    exit();
}

/* Ambil semua prodi untuk dropdown */
$prodi = $db->query("SELECT id, nama_prodi FROM prodi ORDER BY nama_prodi ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Mahasiswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">

            <h3 class="text-center fw-bold mb-4">
                <i class="bi bi-pencil-square text-warning"></i> Edit Data Mahasiswa
            </h3>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">

                    <form method="POST" action="update_mahasiswa.php">

                        <!-- NIM -->
                        <div class="mb-3">
                            <label class="form-label">NIM</label>
                            <input type="number" 
                                   class="form-control bg-light" 
                                   name="nim" 
                                   value="<?= $data['nim']; ?>" 
                                   readonly>
                            <small class="text-muted">NIM tidak dapat diubah</small>
                        </div>

                        <!-- Nama -->
                        <div class="mb-3">
                            <label class="form-label">Nama Mahasiswa</label>
                            <input type="text" 
                                   class="form-control" 
                                   name="nama_mahasiswa" 
                                   value="<?= htmlspecialchars($data['nama_mahasiswa']); ?>" 
                                   required>
                        </div>

                        <!-- Prodi -->
                        <div class="mb-3">
                            <label class="form-label">Program Studi</label>
                            <select name="prodi_id" class="form-select" required>
                                <option value="">-- Pilih Program Studi --</option>
                                <?php while ($p = $prodi->fetch_assoc()) : ?>
                                    <option value="<?= $p['id']; ?>"
                                        <?= ($p['id'] == $data['prodi_id']) ? 'selected' : ''; ?>>
                                        <?= htmlspecialchars($p['nama_prodi']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <!-- Tanggal Lahir -->
                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" 
                                   class="form-control" 
                                   name="tanggal_lahir" 
                                   value="<?= $data['tanggal_lahir']; ?>" 
                                   required>
                        </div>

                        <!-- Alamat -->
                        <div class="mb-4">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" 
                                      name="alamat" 
                                      rows="3" 
                                      required><?= htmlspecialchars($data['alamat']); ?></textarea>
                        </div>

                        <!-- Tombol -->
                        <div class="d-flex justify-content-between">
                            <a href="mahasiswa.php" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Batal
                            </a>
                            <button type="submit" name="update" class="btn btn-success">
                                <i class="bi bi-save"></i> Simpan Perubahan
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
//.
</body>
</html>
