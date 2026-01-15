<?php
include "koneksi_akademik.php";

$prodi = $db->query("SELECT id, nama_prodi FROM prodi ORDER BY nama_prodi ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .input-group-text {
            background: #f8f9fa;
            border-right: none;
        }
        .form-label {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-dark mb-2">Tambah Mahasiswa</h2>
                <p class="text-muted">Isi data mahasiswa dengan lengkap</p>
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="proses_mahasiswa.php">
                        <!-- NIM -->
                        <div class="mb-4">
                            <label class="form-label">NIM</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-person-vcard text-primary"></i>
                                </span>
                                <input type="number" class="form-control" name="nim" 
                                       placeholder="Contoh: 22012345" required>
                            </div>
                        </div>

                        <!-- Nama -->
                        <div class="mb-4">
                            <label class="form-label">Nama Mahasiswa</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-person-fill text-primary"></i>
                                </span>
                                <input type="text" class="form-control" name="nama_mahasiswa" 
                                       placeholder="Nama lengkap mahasiswa" required>
                            </div>
                        </div>

                        <!-- Prodi -->
                        <div class="mb-4">
                            <label class="form-label">Program Studi</label>
                            <select name="prodi_id" class="form-select" required>
                                <option value="">-- Pilih Program Studi --</option>
                                <?php while ($p = $prodi->fetch_assoc()) : ?>
                                    <option value="<?= $p['id']; ?>">
                                        <?= htmlspecialchars($p['nama_prodi']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <!-- Tanggal Lahir -->
                        <div class="mb-4">
                            <label class="form-label">Tanggal Lahir</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-calendar-date text-primary"></i>
                                </span>
                                <input type="date" class="form-control" name="tanggal_lahir" required>
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="mb-5">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" name="alamat" rows="3" 
                                      placeholder="Alamat lengkap mahasiswa" required></textarea>
                        </div>

                        <!-- Tombol -->
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <a href="mahasiswa.php" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                            <div class="d-flex gap-2">
                                <button type="reset" class="btn btn-light">
                                    <i class="bi bi-arrow-clockwise me-2"></i>Reset
                                </button>
                                <button type="submit" name="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i>Simpan
                                </button>
                            </div>
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