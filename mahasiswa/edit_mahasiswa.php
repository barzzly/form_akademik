<?php
include "koneksi_akademik.php";

// PERBAIKAN: Redirect ke index.php bukan mahasiswa.php
if (!isset($_GET['nim'])) {
    header("Location: index.php");
    exit();
}

$nim = $_GET['nim'];
$stmt = $db->prepare("SELECT * FROM mahasiswa WHERE nim = ?");
$stmt->bind_param("i", $nim);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    echo "Data tidak ditemukan!";
    exit();
}

$prodi = $db->query("SELECT id, nama_prodi FROM prodi ORDER BY nama_prodi ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }
        .card {
            border-radius: 12px;
            border: none;
        }
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #dee2e6;
            padding: 10px 15px;
        }
        .form-control:focus, .form-select:focus {
            border-color: #4a6cf7;
            box-shadow: 0 0 0 3px rgba(74, 108, 247, 0.1);
        }
        .btn {
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
        }
        .form-label {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
        }
        .bg-light {
            background-color: #f8f9fa !important;
        }
        textarea.form-control {
            min-height: 100px;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-dark mb-2">Edit Mahasiswa</h2>
                <p class="text-muted">Perbarui data mahasiswa</p>
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="update_mahasiswa.php">
                        <!-- NIM -->
                        <div class="mb-4">
                            <label class="form-label">NIM</label>
                            <input type="number" class="form-control bg-light" 
                                   name="nim" value="<?= $data['nim']; ?>" readonly>
                            <small class="text-muted">NIM tidak dapat diubah</small>
                        </div>

                        <!-- Nama -->
                        <div class="mb-4">
                            <label class="form-label">Nama Mahasiswa</label>
                            <input type="text" class="form-control" name="nama_mahasiswa" 
                                   value="<?= htmlspecialchars($data['nama_mahasiswa']); ?>" required>
                        </div>

                        <!-- Prodi -->
                        <div class="mb-4">
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
                        <div class="mb-4">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" name="tanggal_lahir" 
                                   value="<?= $data['tanggal_lahir']; ?>" required>
                        </div>

                        <!-- Alamat -->
                        <div class="mb-5">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" name="alamat" rows="3" required><?= htmlspecialchars(trim($data['alamat'])); ?></textarea>
                        </div>

                        <!-- Tombol -->
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <!-- PERBAIKAN: Kembali ke index.php bukan mahasiswa.php -->
                            <a href="index.php" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-2"></i>Batal
                            </a>
                            <button type="submit" name="update" class="btn btn-success">
                                <i class="bi bi-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>