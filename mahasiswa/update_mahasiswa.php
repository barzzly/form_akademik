<?php
include "koneksi_akademik.php";

if (isset($_POST['update'])) {

    $nim        = $_POST['nim'];
    $nama       = trim($_POST['nama_mahasiswa']);
    $prodi_id   = $_POST['prodi_id'];
    $tgl        = $_POST['tanggal_lahir'];
    $alamat     = trim($_POST['alamat']);

    // Validasi
    if (empty($nim) || empty($nama) || empty($prodi_id) || empty($tgl) || empty($alamat)) {
        // PERBAIKAN: Kembali ke edit dengan pesan error
        header("Location: edit_mahasiswa.php?nim=$nim&pesan=kosong");
        exit();
    }

    // Query Update
    $sql = "UPDATE mahasiswa 
            SET nama_mahasiswa = ?, 
                prodi_id = ?, 
                tanggal_lahir = ?, 
                alamat = ? 
            WHERE nim = ?";

    $stmt = $db->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sissi", $nama, $prodi_id, $tgl, $alamat, $nim);

        if ($stmt->execute()) {
            // PERBAIKAN: Redirect ke index.php bukan mahasiswa.php
            header("Location: index.php?pesan=sukses_update");
            exit();
        } else {
            // PERBAIKAN: Redirect ke index.php bukan mahasiswa.php
            header("Location: index.php?pesan=gagal");
            exit();
        }

        $stmt->close();
    } else {
        echo "Error database: " . $db->error;
        echo "<br><a href='edit_mahasiswa.php?nim=$nim'>Kembali ke Edit</a>";
        exit();
    }
} else {
    // PERBAIKAN: Redirect ke index.php bukan mahasiswa.php
    header("Location: index.php");
    exit();
}

$db->close();
?>