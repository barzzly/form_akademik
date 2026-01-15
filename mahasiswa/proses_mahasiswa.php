<?php
include "koneksi_akademik.php";

if (isset($_POST['submit'])) {

    $nim        = $_POST['nim'];
    $nama       = trim($_POST['nama_mahasiswa']);
    $prodi_id   = $_POST['prodi_id'];
    $tgl        = $_POST['tanggal_lahir'];
    $alamat     = trim($_POST['alamat']);

    // Validasi kosong
    if (empty($nim) || empty($nama) || empty($prodi_id) || empty($tgl) || empty($alamat)) {
        header("Location: create_mahasiswa.php?pesan=kosong");
        exit();
    }

    // Query insert
    $sql = "INSERT INTO mahasiswa 
            (nim, nama_mahasiswa, prodi_id, tanggal_lahir, alamat) 
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $db->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("isiss", $nim, $nama, $prodi_id, $tgl, $alamat);

        if ($stmt->execute()) {
            header("Location: index.php?pesan=sukses_tambah");
            exit();
        } else {
            // Tampilkan error detail
            echo "Gagal menyimpan data: " . $stmt->error;
            echo "<br><a href='create_mahasiswa.php'>Kembali ke Form</a>";
        }

        $stmt->close();
    } else {
        echo "Error database: " . $db->error;
    }

} else {
    header("Location: index.php");
    exit();
}

$db->close();
?>