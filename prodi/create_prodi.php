<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Program Studi</title>
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
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
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
                <h2 class="fw-bold text-dark mb-2">Tambah Program Studi</h2>
                <p class="text-muted">Isi data program studi dengan lengkap</p>
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="proses_prodi.php">
                        <!-- Nama Prodi -->
                        <div class="mb-4">
                            <label class="form-label">Nama Program Studi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-mortarboard-fill text-success"></i>
                                </span>
                                <input type="text" class="form-control" name="nama_prodi" 
                                       placeholder="Contoh: Teknik Informatika" required>
                            </div>
                        </div>

                        <!-- Jenjang -->
                        <div class="mb-4">
                            <label class="form-label">Jenjang</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-diagram-3-fill text-success"></i>
                                </span>
                                <select name="jenjang" class="form-select" required>
                                    <option value="">-- Pilih Jenjang --</option>
                                    <option value="D3">D3</option>
                                    <option value="D4">D4</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                </select>
                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-5">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control" name="keterangan" rows="3"
                                      placeholder="Deskripsi singkat program studi..." required></textarea>
                        </div>

                        <!-- Tombol -->
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <a href="prodi.php" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                            <div class="d-flex gap-2">
                                <button type="reset" class="btn btn-light">
                                    <i class="bi bi-arrow-clockwise me-2"></i>Reset
                                </button>
                                <button type="submit" class="btn btn-success" name="submit">
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