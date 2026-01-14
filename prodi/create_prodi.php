<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Program Studi</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <!-- Judul -->
            <div class="text-center mb-4">
                <h3 class="fw-bold">Tambah Program Studi</h3>
                <p class="text-muted">Form input data program studi</p>
            </div>

            <!-- Card -->
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">

                    <form method="POST" action="proses_prodi.php">

                        <!-- Nama Prodi -->
                        <div class="mb-3">
                            <label for="nama_prodi" class="form-label">Nama Program Studi</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-mortarboard-fill"></i>
                                </span>
                                <input type="text" 
                                       class="form-control" 
                                       id="nama_prodi" 
                                       name="nama_prodi" 
                                       placeholder="Contoh: Teknik Informatika"
                                       required>
                            </div>
                        </div>
//.
                        <!-- Jenjang -->
                        <div class="mb-3">
                            <label for="jenjang" class="form-label">Jenjang</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-diagram-3-fill"></i>
                                </span>
                                <select name="jenjang" id="jenjang" class="form-select" required>
                                    <option value="">-- Pilih Jenjang --</option>
                                    <option value="D3">D3</option>
                                    <option value="D4">D4</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                </select>
                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-4">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" 
                                      id="keterangan" 
                                      name="keterangan" 
                                      rows="3"
                                      placeholder="Deskripsi singkat program studi..."
                                      required></textarea>
                        </div>

                        <!-- Tombol -->
                        <div class="d-flex justify-content-between">
                            <a href="prodi.php" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>

                            <div>
                                <button type="reset" class="btn btn-outline-secondary me-2">
                                    <i class="bi bi-x-circle"></i> Reset
                                </button>
                                <button type="submit" class="btn btn-primary" name="submit">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
