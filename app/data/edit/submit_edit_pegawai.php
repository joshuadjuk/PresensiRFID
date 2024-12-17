<?php
require_once('../../../conf/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $no_kartu = $_POST['no_kartu'];
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $jabatan = $_POST['jabatan'];
    $departemen = $_POST['departemen'];
    $status = $_POST['status'];
    $start_kerja = $_POST['start_kerja'];
    $end_kerja = $_POST['end_kerja'];

    // Query untuk memperbarui data pegawai
    $query = "UPDATE tb_pegawai SET 
                nama = '$nama',
                nik = '$nik',
                gender = '$gender',
                email = '$email',
                mobile = '$mobile',
                jabatan = '$jabatan',
                departemen = '$departemen',
                status = '$status',
                start_kerja = '$start_kerja',
                end_kerja = '$end_kerja'
              WHERE no_kartu = '$no_kartu'";

    // Eksekusi query
    if (mysqli_query($koneksi, $query)) {
        // Jika berhasil, redirect atau tampilkan pesan sukses
        header('Location: ../../index.php?page=data-pegawai'); // Redirect setelah berhasil
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    echo "Request method tidak valid.";
}
?>