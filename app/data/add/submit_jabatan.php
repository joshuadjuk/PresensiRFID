<?php
require_once('../../../conf/config.php'); // Pastikan jalur ini benar

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    $nama_jabatan = $_POST['nama_jabatan'];

    // Query untuk menyimpan data pegawai
    $query = "INSERT INTO tb_jabatan (nama_jabatan) 
              VALUES ('$nama_jabatan')";

    // Eksekusi query
    if (mysqli_query($koneksi, $query)) {
        header('Location: ../../index.php?page=data-jabatan'); // Redirect setelah berhasil
    } else {
        echo "Error: " . mysqli_error($koneksi); // Tampilkan error jika gagal
    }
}
?>
