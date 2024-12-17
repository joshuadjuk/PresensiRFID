<?php
// Include database connection configuration
require_once('../../../conf/config.php'); // Pastikan jalur ini benar

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $no_kartu = $_POST['no_kartu'];
    $nama = $_POST['pegawai'];
    $nik = $_POST['nik'];
    $waktu_absensi = $_POST['waktu_absensi'];
    $status_absensi = $_POST['status_absensi'];
    $img = $_FILES['bukti_ijin'];

    // Cek apakah file diupload
    if (isset($img) && $img['error'] == UPLOAD_ERR_OK) {
        // Directory where the file will be saved
        $target_dir = "../buktiijinsakit/";
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($img["name"], PATHINFO_EXTENSION));

        // Change directory permission to ensure it's writable
        if (!is_writable($target_dir)) {
            if (!chmod($target_dir, 0775)) {
                echo "Failed to set directory permissions.";
                exit();
            }
        }

        // Check if image file is a actual image or fake image
        $check = getimagesize($img["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size (5MB maximum)
        if ($img["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            echo "Sorry, only JPG, JPEG, and PNG files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            // Generate a new file name
            $formattedTime = date('YmdHis', strtotime($waktu_absensi));
            $newFileName = $nik . '-' . str_replace(' ', '-', $nama) . '-' . $status_absensi . '-' . $formattedTime . '.' . $imageFileType;
            $target_file = $target_dir . $newFileName;

            // Try to upload file
            if (move_uploaded_file($img["tmp_name"], $target_file)) {
                // Save to database with relative path
                $relativePath = "data/buktiijinsakit/" . $newFileName; // Path relatif
                $query = "INSERT INTO log_absensi (no_kartu, nama, nik, waktu_absensi, status_absensi, bukti_ijin) VALUES ('$no_kartu', '$nama', '$nik', '$waktu_absensi', '$status_absensi', '$relativePath')";
                $result = mysqli_query($koneksi, $query);

                if ($result) {
                    // Update status_absensi in tb_pegawai
                    if ($status_absensi == "Izin") {
                        $newStatus = "Izin Bekerja";
                    } elseif ($status_absensi == "Sakit") {
                        $newStatus = "Izin Sakit";
                    } else {
                        $newStatus = $status_absensi; // Jika status tidak dikenali, tetap gunakan status yang sama
                    }

                    $updateQuery = "UPDATE tb_pegawai SET status_kerja = '$newStatus' WHERE nik = '$nik'";
                    mysqli_query($koneksi, $updateQuery);

                    header('Location: ../../index.php?page=data-absensi');
                } else {
                    echo "Sorry, there was an error saving your data: " . mysqli_error($koneksi);
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo "No file was uploaded or there was an upload error.";
    }

    mysqli_close($koneksi);
} else {
    echo "Invalid request method.";
}
?>