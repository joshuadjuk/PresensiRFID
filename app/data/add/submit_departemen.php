<?php
require_once('../../../conf/config.php'); // Pastikan jalur ini benar

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    $nama_departemen = $_POST['nama_departemen'];

    // Query untuk menyimpan data pegawai
    $query = "INSERT INTO tb_departemen (nama_departemen) 
              VALUES ('$nama_departemen')";

    // Eksekusi query
    if (mysqli_query($koneksi, $query)) {
        header('Location: ../../index.php?page=data-departemen'); // Redirect setelah berhasil
    } else {
        echo "Error: " . mysqli_error($koneksi); // Tampilkan error jika gagal
    }
}
?>
