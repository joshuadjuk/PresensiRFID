<?php
// Include database connection configuration
require_once('conf/config.php'); // Pastikan jalur ini benar

// Ambil konten dari Telegram
$content = file_get_contents("php://input");
$update = json_decode($content, true);

// Ambil ID chat dan pesan
$chat_id = $update["message"]["chat"]["id"];
$message = $update["message"]["text"];

// Fungsi untuk mengirim pesan
function sendMessage($chat_id, $text) {
    $url = "https://api.telegram.org/bot7273839532:AAH_4Z4YN0iLF4TnD-qU15o5_a8Gx5mXIzM/sendMessage?chat_id=$chat_id&text=" . urlencode($text);
    file_get_contents($url);
}

// Fungsi untuk mengatur status pengguna
function setUserState($chat_id, $state, $no_kartu = null, $nama = null, $nik = null, $status_absensi = null, $newFileName = null) {
    global $koneksi; // Menggunakan koneksi global
    // Simpan status pengguna di database
    $query = "INSERT INTO user_states (chat_id, state, no_kartu, nama, nik, status_absensi, newFileName) VALUES ('$chat_id', '$state', '$no_kartu', '$nama', '$nik', '$status_absensi', '$newFileName') ON DUPLICATE KEY UPDATE state='$state', no_kartu='$no_kartu', nama='$nama', nik='$nik', status_absensi='$status_absensi', newFileName='$newFileName'";
    mysqli_query($koneksi, $query);
}

// Fungsi untuk mendapatkan status pengguna
function getUserState($chat_id) {
    global $koneksi; // Menggunakan koneksi global
    $query = "SELECT state, no_kartu, nama, nik, status_absensi, newFileName FROM user_states WHERE chat_id='$chat_id'";
    $result = mysqli_query($koneksi, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row;
    }
    return null;
}

// Cek pesan yang diterima
if ($message == "/start") {
    sendMessage($chat_id, "Silakan pilih:\n1. Ijin\n2. Sakit\nKetik 'Ijin' atau 'Sakit'");
    setUserState($chat_id, "waiting_for_status");
} else {
    $userState = getUserState($chat_id);
    
    if ($userState['state'] == "waiting_for_status" && ($message == "Ijin" || $message == "Sakit")) {
        // Simpan status absensi
        setUserState($chat_id, "waiting_for_name_or_nik", null, null, null, $message);
        sendMessage($chat_id, "Masukkan Nama Pegawai atau NIK yang terdaftar:");
    } elseif ($userState['state'] == "waiting_for_name_or_nik" && !empty($message)) {
        // Cek apakah input adalah NIK atau Nama
        $input = $message;
        $query = "SELECT no_kartu, nama, nik FROM tb_pegawai WHERE nik = '$input' OR nama = '$input'";
        $result = mysqli_query($koneksi, $query);
        
        if ($row = mysqli_fetch_assoc($result)) {
            $no_kartu = $row['no_kartu'];
            $nama = $row['nama'];
            $nik = $row['nik'];
            sendMessage($chat_id, "Data ditemukan:\nNo Kartu: $no_kartu\nNama: $nama\nNIK: $nik\nSilakan kirim foto bukti Ijin/Sakit:");
            setUserState($chat_id, "waiting_for_image", $no_kartu, $nama, $nik, $userState['status_absensi']);
        } else {
            sendMessage($chat_id, "Data tidak ditemukan. Silakan coba lagi.");
        }
    } elseif ($userState['state'] == "waiting_for_image" && isset($update["message"]["photo"])) {
        // Mendapatkan ID foto yang dikirim
        $photo = $update["message"]["photo"];
        $file_id = end($photo)["file_id"]; // Ambil file_id dari foto terbesar
        $file_url = "https://api.telegram.org/bot7273839532:AAH_4Z4YN0iLF4TnD-qU15o5_a8Gx5mXIzM/getFile?file_id=$file_id";
        
        // Mendapatkan URL file
        $file_info = json_decode(file_get_contents($file_url), true);
        $file_path = $file_info["result"]["file_path"];
        $bukti_url = "https://api.telegram.org/file/bot7273839532:AAH_4Z4YN0iLF4TnD-qU15o5_a8Gx5mXIzM/$file_path";

        // Proses penyimpanan file ke server
        $target_dir = "app/data/buktiijinsakit/"; // Pastikan direktori ini ada dan dapat ditulis
        $imageFileType = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
        $formattedTime = date('YmdHis');
        $newFileName = $userState['nik'] . '-' . str_replace(' ', '-', $userState['nama']) . '-' . $formattedTime . '.' . $imageFileType;
        $target_file = $target_dir . $newFileName;

        // Mengunduh file gambar dari URL dan menyimpannya ke server
        if (file_put_contents($target_file, file_get_contents($bukti_url))) {
            // Konfirmasi data yang diisi
            $status_absensi = $userState['status_absensi']; // Ambil status dari user_state
            sendMessage($chat_id, "Konfirmasi Data:\nKeterangan: $status_absensi\nNo Kartu: {$userState['no_kartu']}\nNama: {$userState['nama']}\nNIK: {$userState['nik']}\nBukti Ijin: $bukti_url\nKetik 'Selesai' untuk mengirim data.");

            // Simpan nama file ke user_state
            setUserState($chat_id, "waiting_for_confirmation", $userState['no_kartu'], $userState['nama'], $userState['nik'], $status_absensi, $newFileName);
        } else {
            sendMessage($chat_id, "Gagal menyimpan file gambar. Silakan coba lagi.");
        }
    } elseif ($userState['state'] == "waiting_for_confirmation" && strtolower($message) == "selesai") {
        // Simpan data ke database
        $query = "INSERT INTO log_absensi (no_kartu, nama, nik, waktu_absensi, status_absensi, bukti_ijin) VALUES ('{$userState['no_kartu']}', '{$userState['nama']}', '{$userState['nik']}', NOW(), '{$userState['status_absensi']}', 'data/buktiijinsakit/{$userState['newFileName']}')";
        $result = mysqli_query($koneksi, $query);

        if ($result) {
            // Update status_kerja di tb_pegawai
            $status_kerja = ($userState['status_absensi'] == "Ijin") ? "Ijin" : "Sakit";
            $updateQuery = "UPDATE tb_pegawai SET status_kerja='$status_kerja' WHERE nik='{$userState['nik']}'";
            mysqli_query($koneksi, $updateQuery);

            // Pesan terima kasih berdasarkan status absensi
            if ($userState['status_absensi'] == "Ijin") {
                sendMessage($chat_id, "Terimakasih {$userState['nama']}, data kamu sudah di input.");
            } elseif ($userState['status_absensi'] == "Sakit") {
                sendMessage($chat_id, "Terimakasih {$userState['nama']}, data kamu sudah di input.\nSemoga cepat sembuh {$userState['nama']}!!!");
            }
        } else {
            sendMessage($chat_id, "Terjadi kesalahan saat mengirim data: " . mysqli_error($koneksi));
        }
        // Hapus data pengguna setelah selesai
        setUserState($chat_id, null); // Reset state
    } else {
        sendMessage($chat_id, "Format tidak dikenali. Gunakan /start untuk memulai.");
    }
}

mysqli_close($koneksi);
?>