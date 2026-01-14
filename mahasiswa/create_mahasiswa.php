<?php
include "koneksi_akademik.php";

/* Ambil data prodi untuk dropdown */
$prodi = $db->query("SELECT id, nama_prodi FROM prodi ORDER BY nama_prodi ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mahasiswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <!-- Judul -->
            <h3 class="text-center fw-bold mb-4">
                <i class="bi bi-person-plus-fill text-primary"></i> Tambah Mahasiswa
            </h3>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">

                    <form method="POST" action="proses_mahasiswa.php">

                        <!-- NIM -->
                        <div class="mb-3">
                            <label class="form-label">NIM</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-vcard"></i></span>
                                <input type="number" 
                                       class="form-control" 
                                       name="nim" 
                                       placeholder="Contoh: 22012345" 
                                       required>
                            </div>
                        </div>

                        <!-- Nama -->
                        <div class="mb-3">
                            <label class="form-label">Nama Mahasiswa</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                <input type="text" 
                                       class="form-control" 
                                       name="nama_mahasiswa" 
                                       placeholder="Nama lengkap mahasiswa" 
                                       required>
                            </div>
                        </div>

                        <!-- Prodi -->
                        <div class="mb-3">
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
                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                                <input type="date" 
                                       class="form-control" 
                                       name="tanggal_lahir" 
                                       required>
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="mb-4">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" 
                                      name="alamat" 
                                      rows="3" 
                                      placeholder="Alamat lengkap mahasiswa" 
                                      required></textarea>
                        </div>

                        <!-- Tombol -->
                        <div class="d-flex justify-content-between">
                            <a href="mahasiswa.php" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>

                            <div>
                                <button type="reset" class="btn btn-outline-secondary me-2">
                                    <i class="bi bi-x-circle"></i> Reset
                                </button>
                                <button type="submit" name="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Simpan
                                </button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
//.
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
