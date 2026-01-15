<?php
session_start();
// CEK LOGIN
if (!isset($_SESSION['nim'])) {
    header("Location: ../mahasiswa/login.php");
    exit();
}

include "koneksi_akademik.php";

if (!isset($_GET['id'])) {
    header("Location: prodi.php");
    exit;
}

$id = (int) $_GET['id'];

// Ambil data prodi
$stmt = $db->prepare("SELECT * FROM prodi WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    echo "Data program studi tidak ditemukan!";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Program Studi</title>
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
        .form-label {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <!-- NAVBAR SEDERHANA -->
    <nav class="navbar navbar-dark" style="background: linear-gradient(90deg, #10b981 0%, #059669 100%);">
        <div class="container">
            <a class="navbar-brand fw-bold" href="../mahasiswa/index.php">
                <i class="bi bi-mortarboard-fill me-2"></i>Sistem Akademik
            </a>
            <span class="navbar-text text-white">
                <i class="bi bi-person-circle me-1"></i><?php echo $_SESSION['nama']; ?>
            </span>
        </div>
    </nav>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-dark mb-2">Edit Program Studi</h2>
                <p class="text-muted">Perbarui data program studi</p>
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="update_prodi.php">
                        <input type="hidden" name="id" value="<?= $data['id']; ?>">
                        
                        <!-- Nama Prodi -->
                        <div class="mb-4">
                            <label class="form-label">Nama Program Studi</label>
                            <input type="text" class="form-control" name="nama_prodi" 
                                   value="<?= htmlspecialchars($data['nama_prodi']); ?>" required>
                        </div>

                        <!-- Jenjang -->
                        <div class="mb-4">
                            <label class="form-label">Jenjang</label>
                            <select name="jenjang" class="form-select" required>
                                <option value="D2" <?= $data['jenjang']=='D2'?'selected':''; ?>>D2</option>
                                <option value="D3" <?= $data['jenjang']=='D3'?'selected':''; ?>>D3</option>
                                <option value="D4" <?= $data['jenjang']=='D4'?'selected':''; ?>>D4</option>
                                <option value="S1" <?= $data['jenjang']=='S1'?'selected':''; ?>>S1</option>
                                <option value="S2" <?= $data['jenjang']=='S2'?'selected':''; ?>>S2</option>
                            </select>
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-5">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control" name="keterangan" rows="3" required><?= htmlspecialchars($data['keterangan']); ?></textarea>
                        </div>

                        <!-- Tombol -->
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <a href="prodi.php" class="btn btn-outline-secondary">
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