<?php
require_once('config.php'); // Pastikan jalur ini benar

if (isset($_GET['no_kartu'])) {
    $no_kartu = $_GET['no_kartu'];
    
    // Query untuk mendapatkan data pegawai
    $query = mysqli_query($koneksi, "SELECT * FROM tb_pegawai WHERE no_kartu = '$no_kartu'");
    
    if (mysqli_num_rows($query) > 0) {
        $pegawai = mysqli_fetch_assoc($query);
        echo json_encode($pegawai); // Mengembalikan data dalam format JSON
    } else {
        echo json_encode([]); // Jika tidak ditemukan, kembalikan array kosong
    }
} else {
    echo json_encode([]); // Jika no_kartu tidak diset, kembalikan array kosong
}
?>