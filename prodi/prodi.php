<?php
session_start();
// CEK LOGIN - Tambahkan di bagian paling atas
if (!isset($_SESSION['nim'])) {
    header("Location: ../mahasiswa/login.php");
    exit();
}

// Include koneksi database
include "koneksi_akademik.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Studi</title>
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
            overflow: hidden;
        }
        .table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #2d3748;
            border-bottom: 2px solid #e9ecef;
            padding: 12px 16px;
        }
        .table td {
            padding: 12px 16px;
            vertical-align: middle;
        }
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
        }
        .header-section {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            color: white;
        }
        .btn {
            border-radius: 8px;
            padding: 8px 16px;
        }
        .navbar {
            background: linear-gradient(90deg, #10b981 0%, #059669 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .nav-link {
            color: rgba(255,255,255,0.9) !important;
        }
        .nav-link:hover {
            color: white !important;
        }
        .nav-link.active {
            color: white !important;
            font-weight: 600;
        }
        .dropdown-menu {
            border-radius: 8px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="../mahasiswa/index.php">
                <i class="bi bi-mortarboard-fill me-2"></i>Sistem Akademik
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../mahasiswa/index.php">
                            <i class="bi bi-house-door me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="prodi.php">
                            <i class="bi bi-diagram-3 me-1"></i>Program Studi
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" 
                           data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i><?php echo $_SESSION['nama']; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="../mahasiswa/profil.php"><i class="bi bi-person me-2"></i>Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="../mahasiswa/logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <!-- Header -->
        <div class="header-section">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-2"><i class="bi bi-mortarboard-fill me-2"></i>Program Studi</h2>
                    <p class="mb-0 opacity-75">Halo, <?php echo $_SESSION['nama']; ?>! Selamat datang di manajemen program studi.</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="../mahasiswa/index.php" class="btn btn-light">
                        <i class="bi bi-people-fill me-2"></i>Mahasiswa
                    </a>
                    <a href="create_prodi.php" class="btn btn-light">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Prodi
                    </a>
                </div>
            </div>
        </div>

        <!-- Alert -->
        <?php if (isset($_GET['pesan'])) : 
            $alert = [
                "sukses_tambah" => ["success", "Program studi berhasil ditambahkan"],
                "sukses_update" => ["success", "Program studi berhasil diperbarui"],
                "sukses_hapus"  => ["success", "Program studi berhasil dihapus"],
                "gagal"         => ["danger", "Terjadi kesalahan sistem"],
                "kosong"        => ["warning", "Harap isi semua field"]
            ];
            if (isset($alert[$_GET['pesan']])) :
                [$type, $text] = $alert[$_GET['pesan']]; ?>
                <div class="alert alert-<?= $type ?> alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i><?= $text ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; 
        endif; ?>

        <!-- Tabel -->
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>Nama Prodi</th>
                                <th width="100">Jenjang</th>
                                <th>Keterangan</th>
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $tampil = $db->query("SELECT * FROM prodi ORDER BY jenjang ASC, nama_prodi ASC");
                            while ($data = $tampil->fetch_assoc()) : ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td class="fw-semibold"><?= htmlspecialchars($data['nama_prodi']); ?></td>
                                <td>
                                    <span class="badge bg-success bg-opacity-10 text-success">
                                        <?= htmlspecialchars($data['jenjang']); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-truncate d-inline-block" style="max-width: 300px;">
                                        <?= htmlspecialchars($data['keterangan']); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="edit_prodi.php?id=<?= $data['id']; ?>" 
                                           class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="delete_prodi.php?id=<?= $data['id']; ?>" 
                                           class="btn btn-sm btn-outline-danger" title="Hapus"
                                           onclick="return confirm('Hapus program studi <?= htmlspecialchars($data['nama_prodi']) ?>?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    
                    <?php if ($tampil->num_rows == 0): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 3rem; color: #dee2e6;"></i>
                        <h5 class="mt-3 text-muted">Belum ada data program studi</h5>
                        <p class="text-muted">Klik "Tambah Prodi" untuk menambahkan data pertama</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Info Footer -->
        <div class="text-center mt-4 text-muted">
            <small>
                <i class="bi bi-info-circle me-1"></i>
                Total <?php echo $tampil->num_rows; ?> program studi ditemukan
            </small>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto close alert setelah 5 detik
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>
</html>