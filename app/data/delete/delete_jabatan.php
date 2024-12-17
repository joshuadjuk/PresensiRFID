<?php
require_once('../../../conf/config.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM tb_jabatan WHERE id = '$id'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header('Location: ../../index.php?page=data-jabatan');
    } else {
        header('Location: ../../index.php?page=data-jabatan');
    }
}
?>
