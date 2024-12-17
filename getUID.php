<?php
require_once('conf/config.php'); // Pastikan jalur ini benar

// Set timezone
date_default_timezone_set('Asia/Jakarta'); // Mengatur timezone ke Asia/Jakarta

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["UIDresult"])) {
        $UIDresult = $_POST["UIDresult"];
        
        // Simpan UID ke UIDContainer.php
        $Write = "<?php $" . "UIDresult='" . $UIDresult . "'; " . "echo $" . "UIDresult;" . " ?>";
        file_put_contents('UIDContainer.php', $Write);
        
        // Proses absensi
        if (!empty($UIDresult)) {
            // Cek apakah UID ada di tb_pegawai
            $query = mysqli_query($koneksi, "SELECT * FROM tb_pegawai WHERE no_kartu = '$UIDresult'");
            
            if (mysqli_num_rows($query) > 0) {
                $pegawai = mysqli_fetch_array($query);
                
                // Ambil informasi pegawai
                $no_kartu = $pegawai['no_kartu'];
                $nama = $pegawai['nama'];
                $nik = $pegawai['nik'];
                $end_kerja = $pegawai['end_kerja']; // Ambil waktu end kerja
                
                // Ambil waktu saat ini
                $waktu_absensi = date('Y-m-d H:i:s'); // Waktu saat ini sesuai timezone yang telah diatur
                
                // Hitung selisih waktu untuk pulang
                $selisih_waktu_pulang = (strtotime($waktu_absensi) - strtotime($end_kerja)) / 60; // dalam menit
                
                // Cek apakah pegawai sudah melakukan absensi
                $check_query = mysqli_query($koneksi, "SELECT * FROM log_absensi WHERE no_kartu = '$no_kartu' AND DATE(waktu_absensi) = CURDATE() ORDER BY id DESC LIMIT 1");
                
                if (mysqli_num_rows($check_query) == 0) {
                    // Jika belum ada absensi, set status kerja menjadi 'bekerja'
                    $update_status = mysqli_query($koneksi, "UPDATE tb_pegawai SET status_kerja = 'Bekerja' WHERE no_kartu = '$no_kartu'");
                    
                    if ($update_status) {
                        // Catat waktu absensi ke log_absensi
                        $insert_query = "INSERT INTO log_absensi (no_kartu, nama, nik, waktu_absensi, status_absensi) 
                                         VALUES ('$no_kartu', '$nama', '$nik', '$waktu_absensi', 'Masuk')";
                        
                        if (mysqli_query($koneksi, $insert_query)) {
                            // Mengembalikan data dalam format JSON
                            echo json_encode([
                                'status' => 'success',
                                'nama' => $nama,
                                'nik' => $nik,
                                'waktu_absensi' => $waktu_absensi,
                                'status_absensi' => 'Masuk'
                            ]);
                        } else {
                            echo json_encode(['status' => 'error', 'message' => mysqli_error($koneksi)]);
                        }
                    } else {
                        echo json_encode(['status' => 'error', 'message' => mysqli_error($koneksi)]);
                    }
                } else {
                    // Jika sudah ada absensi, periksa waktu untuk pulang
                    if ($selisih_waktu_pulang >= 0 && $selisih_waktu_pulang <= 30) {
                        // Jika waktu saat ini berada dalam rentang 30 menit setelah end_kerja
                        $insert_query = "INSERT INTO log_absensi (no_kartu, nama, nik, waktu_absensi, status_absensi) 
                                         VALUES ('$no_kartu', '$nama', '$nik', '$waktu_absensi', 'Selesai Bekerja')";
                        
                        // Ubah status kerja menjadi 'Selesai Bekerja'
                        $update_status = mysqli_query($koneksi, "UPDATE tb_pegawai SET status_kerja = 'Selesai Bekerja' WHERE no_kartu = '$no_kartu'");
                        
                        if (mysqli_query($koneksi, $insert_query) && $update_status) {
                            // Return JSON instead of plain text
                            echo json_encode([
                                'status' => 'success',
                                'message' => "Data absensi pulang berhasil disimpan dan status kerja diubah menjadi 'Selesai Bekerja'."
                            ]);
                        } else {
                            echo json_encode(['status' => 'error', 'message' => mysqli_error($koneksi)]);
                        }
                    } else {
                        // Jika pegawai melakukan scan sebelum waktu pulang
                        echo json_encode([
                            'status' => 'error',
                            'message' => "Scan sebelum waktu pulang, tidak ada input."
                        ]);
                    }
                }
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => "UID tidak ditemukan di tb_pegawai."
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => "UID tidak valid."
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => "UIDresult tidak ditemukan."
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => "Request method tidak valid."
    ]);
}
?>
