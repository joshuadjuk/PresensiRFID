    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Absensi</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <button class="btn btn-primary" data-toggle="modal" data-target="#manualAbsenceModal">Tambah Absensi Izin/Sakit</button>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>No Kartu</th>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>Waktu Absensi</th>
                    <th>Status Absensi</th>
                    <th>Bukti Izin/Sakit</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 0;
                    $query = mysqli_query($koneksi,"SELECT * FROM log_absensi ORDER BY id DESC");
                    while($com = mysqli_fetch_array($query)){
                      $no++
                    ?>
                  <tr>
                    <td width='5%'><?php echo $no?></td>
                    <td><?php echo $com['no_kartu'];?></td>
                    <td><?php echo $com['nama'];?></td>
                    <td><?php echo $com['nik'];?></td>
                    <td><?php echo $com['waktu_absensi'];?></td>
                    <td><?php echo $com['status_absensi'];?></td>
                    <td>
                        <button class="btn btn-info" onclick="showImage('<?php echo $com['bukti_ijin']; ?>')" data-toggle="modal" data-target="#imageModal">Lihat Bukti</button>
                    </td>
                  </tr>
                  <?php }?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>No</th>
                    <th>No Kartu</th>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>Waktu Absensi</th>
                    <th>Status Absensi</th>
                    <th>Bukti Izin/Sakit</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>

            
            <!-- /.card -->
          </div>

          
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>

<!-- Modal untuk Absensi Ijin/Sakit -->
<div class="modal fade" id="manualAbsenceModal" tabindex="-1" role="dialog" aria-labelledby="manualAbsenceModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="manualAbsenceModalLabel">Tambah Absensi Izin/Sakit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="manualAbsenceForm" method="POST" action="data/add/submit_ijinsakit.php" enctype="multipart/form-data">
          <div class="form-group">
            <label for="pegawai">Pilih Pegawai</label>
            <input id="pegawai" name="pegawai" type="text" class="form-control" placeholder="Masukkan Nama Pegawai" list="pegawaiList" required oninput="fillEmployeeData()">
            <datalist id="pegawaiList">
                <?php
                // Ambil data pegawai dari database
                $pegawaiQuery = mysqli_query($koneksi, "SELECT * FROM tb_pegawai");
                while ($pegawai = mysqli_fetch_array($pegawaiQuery)) {
                    echo "<option value='" . $pegawai['nama'] . "' data-no_kartu='" . $pegawai['no_kartu'] . "' data-nik='" . $pegawai['nik'] . "'>";
                }
                ?>
            </datalist>
          </div>
          <div class="form-group">
            <label for="no_kartu">No Kartu</label>
            <input type="text" name="no_kartu" id="no_kartu" class="form-control" placeholder="No Kartu" required readonly>
          </div>
          <div class="form-group">
            <label for="nik">NIK</label>
            <input type="text" name="nik" id="nik" class="form-control" placeholder="NIK" required readonly>
          </div>
          <div class="form-group">
            <label for="waktu_absensi">Waktu Absensi</label>
            <input id="waktu_absensi" name="waktu_absensi" type="datetime-local" class="form-control" required>
          </div>
          <div class="form-group">
              <label for="status_absensi">Status Absensi</label>
              <select name="status_absensi" id="status_absensi" class="form-control" required>
                  <option value="Sakit">Sakit</option>
                  <option value="Izin">Izin</option>
              </select>
          </div>

          <div class="form-group">
              <label for="bukti_ijin">Upload Bukti Izin/Sakit</label>
              <input type="file" name="bukti_ijin" id="bukti_ijin" class="form-control" accept=".jpg, .jpeg, .png" required onchange="previewImage(event)">
              <small class="form-text text-muted">Format yang diterima: JPG, JPEG, PNG</small>
          </div>

          <!-- Elemen untuk menampilkan preview gambar -->
          <div id="imagePreviewContainer" style="display: none;">
              <img id="imagePreview" src="" alt="Preview" style="max-width: 100%; height: auto;">
          </div>

          <div class="form-actions">
            <button type="submit" class="btn btn-success">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal untuk Menampilkan Gambar -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Bukti Izin/Sakit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="modalImage" src="" alt="Bukti Izin/Sakit" style="max-width: 100%; height: auto;">
            </div>
        </div>
    </div>
</div>

<script>
function fillEmployeeData() {
    var input = document.getElementById("pegawai");
    var datalist = document.getElementById("pegawaiList");
    var selectedOption = Array.from(datalist.options).find(option => option.value === input.value);

    if (selectedOption) {
        var noKartu = selectedOption.getAttribute("data-no_kartu");
        var nik = selectedOption.getAttribute("data-nik");

        // Isi input dengan data yang diambil
        document.getElementById("no_kartu").value = noKartu; // Isi No Kartu
        document.getElementById("nik").value = nik; // Isi NIK
    } else {
        // Jika tidak ada yang dipilih, kosongkan input
        document.getElementById("no_kartu").value = '';
        document.getElementById("nik").value = '';
    }
}

function previewImage(event) {
    var input = event.target;
    var previewContainer = document.getElementById('imagePreviewContainer');
    var imagePreview = document.getElementById('imagePreview');

    // Cek apakah ada file yang dipilih
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        // Ketika file dibaca, set src dari img dengan hasil pembacaan
        reader.onload = function(e) {
            imagePreview.src = e.target.result;
            previewContainer.style.display = 'block'; // Tampilkan preview
        }

        reader.readAsDataURL(input.files[0]); // Membaca file sebagai URL data
    } else {
        previewContainer.style.display = 'none'; // Sembunyikan preview jika tidak ada file
    }
}

function showImage(imagePath) {
    var modalImage = document.getElementById('modalImage');
    modalImage.src = imagePath; // Set src dari img di modal
}
</script>