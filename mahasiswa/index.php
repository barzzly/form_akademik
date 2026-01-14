<?php
include "koneksi_akademik.php";

/*
  Query JOIN Mahasiswa + Prodi
  mahasiswa.prodi_id → prodi.id
*/
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

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

<div class="container my-5">

    <!-- HEADER HALAMAN -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">
                <i class="bi bi-people-fill text-primary"></i> Data Mahasiswa
            </h3>
            <small class="text-muted">Manajemen data mahasiswa</small>
        </div>

        <div class="d-flex gap-2">
            <a href="../prodi/prodi.php" class="btn btn-outline-primary">
                <i class="bi bi-mortarboard-fill"></i> Prodi
            </a>
            <a href="create_mahasiswa.php" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Mahasiswa
            </a>
        </div>
    </div>

    <!-- ALERT -->
    <?php
    if (isset($_GET['pesan'])) {
        $alert = [
            "sukses_tambah" => ["success", "Data mahasiswa berhasil ditambahkan"],
            "sukses_update" => ["success", "Data mahasiswa berhasil diperbarui"],
            "sukses_hapus"  => ["success", "Data mahasiswa berhasil dihapus"],
            "gagal"         => ["danger", "Terjadi kesalahan sistem"]
        ];

        if (isset($alert[$_GET['pesan']])) {
            [$type, $text] = $alert[$_GET['pesan']];
            echo "
            <div class='alert alert-$type alert-dismissible fade show'>
                <i class='bi bi-info-circle'></i> $text
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            </div>";
        }
    }
    ?>

    <!-- CARD TABEL -->
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-secondary text-center">
                        <tr>
                            <th width="50">No</th>
                            <th>NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Program Studi</th>
                            <th>Tanggal Lahir</th>
                            <th>Alamat</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $no = 1;
                        while ($data = $tampil->fetch_assoc()) :
                    ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td class="fw-semibold"><?= $data['nim']; ?></td>
                            <td><?= htmlspecialchars($data['nama_mahasiswa']); ?></td>
                            <td class="text-center">
                                <span class="badge bg-info text-dark">
                                    <?= htmlspecialchars($data['nama_prodi']); ?>
                                </span>
                            </td>
                            <td class="text-center"><?= $data['tanggal_lahir']; ?></td>
                            <td><?= htmlspecialchars($data['alamat']); ?></td>
                            <td class="text-center">
                                <a href="edit_mahasiswa.php?nim=<?= $data['nim']; ?>" 
                                   class="btn btn-warning btn-sm" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="delete_mahasiswa.php?nim=<?= $data['nim']; ?>" 
                                   class="btn btn-danger btn-sm" title="Hapus"
                                   onclick="return confirm('Yakin ingin menghapus data mahasiswa ini?');">
                                    <i class="bi bi-trash-fill"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
//.
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
