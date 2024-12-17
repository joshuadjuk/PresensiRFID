<?php
// ... existing code ...

// Koneksi ke database
include 'config.php'; // Menggunakan koneksi dari config.php

// Ambil data dari form
$nama = $_POST['nama'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Siapkan dan jalankan query
$sql = "INSERT INTO tb_login (nama, email, username, password) VALUES (?, ?, ?, ?)";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("ssss", $nama, $email, $username, $hashed_password);

if ($stmt->execute()) {
    header("Location: ../app/index.php");
} else {
    echo "Error: " . $stmt->error;
}

// Tutup koneksi
$stmt->close();
$koneksi->close();
?>