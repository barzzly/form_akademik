<?php
session_start();
include "koneksi_akademik.php";

// CEK LOGIN - Jika belum login, redirect ke login
if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit();
}

// CEK DAN ISI SESSION NAMA JIKA KOSONG
if (!isset($_SESSION['nama']) || empty($_SESSION['nama'])) {
    $nim = $_SESSION['nim'];
    $query = "SELECT nama_mahasiswa FROM mahasiswa WHERE nim = '$nim'";
    $result = $db->query($query);
    
    if ($result && $result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $_SESSION['nama'] = $data['nama_mahasiswa'];
    } else {
        $_SESSION['nama'] = "Mahasiswa";
    }
}

// Query data mahasiswa
$tampil = $db->query("
    SELECT 
        m.nim,
        m.nama_mahasiswa,
        m.tanggal_lahir,
        m.alamat,
        p.nama_prodi
    FROM mahasiswa m
    JOIN prodi p ON m.prodi_id = p.id
    ORDER BY m.nim ASC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa - Sistem Akademik</title>
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
        .table-hover tbody tr:hover {
            background-color: #f8f9ff;
        }
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
        }
        .btn-sm {
            padding: 6px 12px;
            border-radius: 6px;
        }
        .header-section {
            background: linear-gradient(135deg, #4a6cf7 0%, #6a11cb 100%);
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            color: white;
        }
        .navbar {
            background: linear-gradient(90deg, #4a6cf7 0%, #6a11cb 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .nav-link {
            color: rgba(255,255,255,0.9) !important;
            transition: all 0.3s ease;
        }
        .nav-link:hover {
            color: white !important;
            transform: translateY(-2px);
        }
        .nav-link.active {
            color: white !important;
            font-weight: 600;
            background: rgba(255,255,255,0.1);
            border-radius: 6px;
            padding: 8px 16px;
        }
        .dropdown-menu {
            border-radius: 10px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-top: 10px;
        }
        .dropdown-item {
            border-radius: 6px;
            margin: 2px 8px;
            padding: 8px 12px;
            transition: all 0.3s ease;
        }
        .dropdown-item:hover {
            background-color: #f8f9ff;
            transform: translateX(5px);
        }
        .btn-light {
            background: rgba(255,255,255,0.9);
            color: #4a6cf7;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-light:hover {
            background: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .alert {
            border-radius: 10px;
            border: none;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">
                <i class="bi bi-mortarboard-fill me-2"></i>Sistem Akademik
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">
                            <i class="bi bi-house-door me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../prodi/prodi.php">
                            <i class="bi bi-diagram-3 me-1"></i>Program Studi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profil.php">
                            <i class="bi bi-person-circle me-1"></i>Profil
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" 
                           role="button" data-bs-toggle="dropdown">
                            <div class="me-2" style="width: 32px; height: 32px; background: rgba(255,255,255,0.2); 
                                 border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <div>
                                <div class="small text-white-50">Halo,</div>
                                <div class="fw-semibold"><?php echo htmlspecialchars($_SESSION['nama']); ?></div>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="profil.php">
                                <i class="bi bi-person me-2"></i>Profil Saya
                            </a></li>
                            <li><a class="dropdown-item" href="edit_profil.php">
                                <i class="bi bi-pencil-square me-2"></i>Edit Profil
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php">
                                <i class="bi bi-box-arrow-right me-2 text-danger"></i>
                                <span class="text-danger">Logout</span>
                            </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <!-- Header -->
        <div class="header-section">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="fw-bold mb-2">
                        <i class="bi bi-people-fill me-2"></i>Data Mahasiswa
                    </h1>
                    <p class="mb-0 opacity-75">
                        Halo, <span class="fw-semibold"><?php echo htmlspecialchars($_SESSION['nama']); ?></span>! 
                        Selamat datang di sistem akademik.
                    </p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="d-flex gap-2 justify-content-md-end">
                        <a href="../prodi/prodi.php" class="btn btn-light">
                            <i class="bi bi-mortarboard-fill me-1"></i>Prodi
                        </a>
                        <a href="create_mahasiswa.php" class="btn btn-light">
                            <i class="bi bi-plus-circle me-1"></i>Tambah Mahasiswa
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        <?php if (isset($_GET['pesan'])) : 
            $alert_messages = [
                "sukses_tambah" => [
                    "type" => "success",
                    "icon" => "bi-check-circle-fill",
                    "title" => "Berhasil!",
                    "text" => "Data mahasiswa berhasil ditambahkan"
                ],
                "sukses_update" => [
                    "type" => "success", 
                    "icon" => "bi-check-circle-fill",
                    "title" => "Berhasil!",
                    "text" => "Data mahasiswa berhasil diperbarui"
                ],
                "sukses_hapus" => [
                    "type" => "success",
                    "icon" => "bi-check-circle-fill",
                    "title" => "Berhasil!",
                    "text" => "Data mahasiswa berhasil dihapus"
                ],
                "gagal" => [
                    "type" => "danger",
                    "icon" => "bi-exclamation-triangle-fill",
                    "title" => "Gagal!",
                    "text" => "Terjadi kesalahan sistem"
                ],
                "kosong" => [
                    "type" => "warning",
                    "icon" => "bi-info-circle-fill",
                    "title" => "Perhatian!",
                    "text" => "Harap isi semua field yang diperlukan"
                ]
            ];
            
            if (isset($alert_messages[$_GET['pesan']])) :
                $alert = $alert_messages[$_GET['pesan']]; ?>
                <div class="alert alert-<?= $alert['type'] ?> alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi <?= $alert['icon'] ?> fs-4 me-3"></i>
                        <div>
                            <div class="fw-semibold"><?= $alert['title'] ?></div>
                            <div class="small"><?= $alert['text'] ?></div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; 
        endif; ?>

        <!-- Statistics Card -->
        <?php
        // Hitung statistik
        $stats_query = $db->query("
            SELECT 
                COUNT(*) as total_mahasiswa,
                COUNT(DISTINCT prodi_id) as total_prodi
            FROM mahasiswa
        ");
        $stats = $stats_query->fetch_assoc();
        ?>
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm mb-3 mb-md-0">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                            <i class="bi bi-people-fill fs-3 text-primary"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Total Mahasiswa</div>
                            <div class="h4 fw-bold mb-0"><?= $stats['total_mahasiswa'] ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 p-3 rounded-3 me-3">
                            <i class="bi bi-mortarboard-fill fs-3 text-success"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Total Program Studi</div>
                            <div class="h4 fw-bold mb-0"><?= $stats['total_prodi'] ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-table me-2"></i>Daftar Mahasiswa
                </h5>
            </div>
            <div class="card-body p-0">
                <?php if ($tampil->num_rows > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th width="50" class="ps-4">No</th>
                                    <th>NIM</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>Program Studi</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Alamat</th>
                                    <th width="120" class="pe-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1; 
                                while ($data = $tampil->fetch_assoc()) : 
                                ?>
                                <tr>
                                    <td class="ps-4"><?= $no++; ?></td>
                                    <td class="fw-semibold"><?= htmlspecialchars($data['nim']); ?></td>
                                    <td><?= htmlspecialchars($data['nama_mahasiswa']); ?></td>
                                    <td>
                                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">
                                            <?= htmlspecialchars($data['nama_prodi']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?= date('d/m/Y', strtotime($data['tanggal_lahir'])); ?>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 200px;">
                                            <?= htmlspecialchars($data['alamat']); ?>
                                        </div>
                                    </td>
                                    <td class="pe-4 text-center">
                                        <div class="btn-group" role="group">
                                            <a href="edit_mahasiswa.php?nim=<?= $data['nim']; ?>" 
                                               class="btn btn-sm btn-outline-warning rounded-start"
                                               title="Edit" data-bs-toggle="tooltip">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="delete_mahasiswa.php?nim=<?= $data['nim']; ?>" 
                                               class="btn btn-sm btn-outline-danger rounded-end"
                                               title="Hapus" data-bs-toggle="tooltip"
                                               onclick="return confirm('Hapus data mahasiswa <?= htmlspecialchars($data['nama_mahasiswa']) ?>?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <!-- Empty State -->
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="bi bi-people display-1 text-muted"></i>
                        </div>
                        <h5 class="text-muted mb-3">Belum ada data mahasiswa</h5>
                        <p class="text-muted mb-4">
                            Mulai dengan menambahkan data mahasiswa pertama Anda.
                        </p>
                        <a href="create_mahasiswa.php" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Tambah Mahasiswa Pertama
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            <?php if ($tampil->num_rows > 0): ?>
            <div class="card-footer bg-white border-0 py-3 text-muted small">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-info-circle me-1"></i>
                        Menampilkan <?= $no-1 ?> data mahasiswa
                    </div>
                    <div>
                        Terakhir diperbarui: <?= date('d/m/Y H:i:s') ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-5 py-4 border-top">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="fw-semibold mb-3">Sistem Akademik</h6>
                    <p class="text-muted small mb-0">
                        Sistem manajemen data mahasiswa dan program studi terintegrasi.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="text-muted small">
                        &copy; <?= date('Y') ?> Sistem Akademik. All rights reserved.
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
        
        // Auto close alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
        
        // Format date for better readability
        document.addEventListener('DOMContentLoaded', function() {
            const dateCells = document.querySelectorAll('td:nth-child(5)');
            dateCells.forEach(cell => {
                const dateText = cell.textContent.trim();
                if (dateText) {
                    const [day, month, year] = dateText.split('/');
                    cell.innerHTML = `<span class="fw-semibold">${day}/${month}</span><br><small class="text-muted">${year}</small>`;
                }
            });
        });
    </script>
</body>
</html>