<?php
session_start();
include('config.php');

$username = $_POST['username'];
$password = $_POST['password'];

// Periksa apakah username dan password diisi
if ($username == '' || $password == '') {
    header('Location:../index.php?error=2');
    exit();
}

// Persiapkan dan jalankan query
$query = $koneksi->prepare("SELECT * FROM tb_login WHERE username = ?");
$query->bind_param("s", $username);
$query->execute();
$result = $query->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    // Verifikasi password
    if (password_verify($password, $user['password'])) {
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['level'] = $user['level'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['usr_img'] = $user['usr_img'];
        header('Location:../app');
        exit();
    } else {
        // Password tidak cocok
        header('Location:../index.php?error=1');
        exit();
    }
} else {
    // Username tidak ditemukan
    header('Location:../index.php?error=1');
    exit();
}

?>
