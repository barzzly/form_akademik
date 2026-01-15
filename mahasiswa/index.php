<?php
include "koneksi_akademik.php";

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
    <title>Data Mahasiswa</title>
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
    </style>
</head>
<body>
<div class="container py-4">
    <!-- Header -->
    <div class="header-section">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-2"><i class="bi bi-people-fill me-2"></i>Data Mahasiswa</h2>
                <p class="mb-0 opacity-75">Manajemen data mahasiswa</p>
            </div>
            <div class="d-flex gap-2">
                <a href="../prodi/prodi.php" class="btn btn-light">
                    <i class="bi bi-mortarboard-fill me-2"></i>Prodi
                </a>
                <a href="create_mahasiswa.php" class="btn btn-light">
                    <i class="bi bi-plus-circle me-2"></i>Tambah
                </a>
            </div>
        </div>
    </div>

    <!-- Alert -->
    <?php if (isset($_GET['pesan'])) : 
        $alert = [
            "sukses_tambah" => ["success", "Data berhasil ditambahkan"],
            "sukses_update" => ["success", "Data berhasil diperbarui"],
            "sukses_hapus"  => ["success", "Data berhasil dihapus"],
            "gagal"         => ["danger", "Terjadi kesalahan"]
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
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Prodi</th>
                            <th>Tgl Lahir</th>
                            <th>Alamat</th>
                            <th width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; while ($data = $tampil->fetch_assoc()) : ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td class="fw-semibold"><?= $data['nim']; ?></td>
                            <td><?= htmlspecialchars($data['nama_mahasiswa']); ?></td>
                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                    <?= htmlspecialchars($data['nama_prodi']); ?>
                                </span>
                            </td>
                            <td><?= date('d/m/Y', strtotime($data['tanggal_lahir'])); ?></td>
                            <td>
                                <span class="text-truncate d-inline-block" style="max-width: 200px;">
                                    <?= htmlspecialchars($data['alamat']); ?>
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="edit_mahasiswa.php?nim=<?= $data['nim']; ?>" 
                                       class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="delete_mahasiswa.php?nim=<?= $data['nim']; ?>" 
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Hapus data mahasiswa?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>