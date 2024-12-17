<?php
require_once('../../../conf/config.php'); // Pastikan jalur ini benar

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    $no_kartu = $_POST['no_kartu'];
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $jabatan = $_POST['jabatan'];
    $departemen = $_POST['departemen'];
    $status = $_POST['status'];
    $status_kerja = 'Selesai Bekerja';
    $start_kerja = $_POST['start_kerja'];
    $end_kerja = $_POST['end_kerja'];


    // Query untuk menyimpan data pegawai
    $query = "INSERT INTO tb_pegawai (no_kartu, nama, nik, gender, email, mobile, jabatan, departemen, status, status_kerja, start_kerja, end_kerja) 
              VALUES ('$no_kartu', '$nama', '$nik', '$gender', '$email', '$mobile', '$jabatan', '$departemen', '$status', '$status_kerja', '$start_kerja', '$end_kerja')";

    // Eksekusi query
    if (mysqli_query($koneksi, $query)) {
        header('Location: ../../index.php?page=data-pegawai'); // Redirect setelah berhasil
    } else {
        echo "Error: " . mysqli_error($koneksi); // Tampilkan error jika gagal
    }
}
?>
