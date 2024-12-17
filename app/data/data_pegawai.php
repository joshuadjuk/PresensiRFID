    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Pegawai</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                <button class="btn btn-primary" data-toggle="modal" data-target="#submitModal">Submit New Pegawai</button>
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>No Kartu</th>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>Jenis Kelamin</th>
                    <th>Email</th>
                    <th>Nomor Telepon</th>
                    <th>Jabatan</th>
                    <th>Departemen</th>
                    <th>Status</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Status Kerja</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 0;
                    $query = mysqli_query($koneksi,"SELECT * FROM tb_pegawai");
                    while($com = mysqli_fetch_array($query)){
                      $no++
                    ?>
                  <tr>
                    <td width='5%'><?php echo $no?></td>
                    <td><?php echo $com['no_kartu'];?></td>
                    <td><?php echo $com['nama'];?></td>
                    <td><?php echo $com['nik'];?></td>
                    <td><?php echo $com['gender'];?></td>
                    <td><?php echo $com['email'];?></td>
                    <td><?php echo $com['mobile'];?></td>
                    <td><?php echo $com['jabatan'];?></td>
                    <td><?php echo $com['departemen'];?></td>
                    <td><?php echo $com['status'];?></td>  
                    <td><?php echo $com['start_kerja'];?></td>
                    <td><?php echo $com['end_kerja'];?></td>
                    <td><?php echo $com['status_kerja'];?></td>
                    <td>
                      <a href="data/delete/delete_pegawai.php?id=<?php echo $com['id'];?>" class="btn btn-danger" onclick="return confirmDelete();">Delete</a>
                      <button class="btn btn-warning" onclick="fillEditModal('<?php echo $com['no_kartu']; ?>')">Edit</button>
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
                    <th>Jenis Kelamin</th>
                    <th>Email</th>
                    <th>Nomor Telepon</th>
                    <th>Jabatan</th>
                    <th>Departemen</th>
                    <th>Status</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Status Kerja</th>
                    <th>Action</th>
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

<!-- Modal add -->
<div class="modal fade" id="submitModal" tabindex="-1" role="dialog" aria-labelledby="submitModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="submitModalLabel">Tambah Pegawai</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addEmployeeForm" method="POST" action="data/add/submit_pegawai.php">
          <div class="form-group">
            <label for="getUID">No Kartu</label>
            <input type="text" name="no_kartu" id="getUID" class="form-control" placeholder="Please Scan your Card / Key Chain to display ID" required readonly>
          </div>
          <div class="form-group">
            <label for="name">Nama</label>
            <input id="name" name="nama" type="text" class="form-control" placeholder="Masukkan Nama" required>
          </div>
          <div class="form-group">
            <label for="nik">NIK</label>
            <input id="nik" name="nik" type="text" class="form-control" placeholder="Masukkan NIK" required>
          </div>
          <div class="form-group">
            <label for="gender">Jenis Kelamin</label>
            <select name="gender" id="gender" class="form-control" required>
              <option value="Laki-laki">Laki-laki</option>
              <option value="Perempuan">Perempuan</option>
            </select>
          </div>
          <div class="form-group">
            <label for="email">Email Address</label>
            <input name="email" id="email" type="email" class="form-control" placeholder="Masukkan Email" required>
          </div>
          <div class="form-group">
            <label for="mobile">Nomor Telepon</label>
            <input name="mobile" id="mobile" type="text" class="form-control" placeholder="Masukkan Nomor Telepon" required>
          </div>
          <div class="form-group">
            <label for="jabatan">Jabatan</label>
            <input id="jabatan" name="jabatan" type="text" class="form-control" placeholder="Masukkan Jabatan" list="jabatanList" required>
            <datalist id="jabatanList">
              <?php
              // Ambil data jabatan dari database
              $jabatanQuery = mysqli_query($koneksi, "SELECT * FROM tb_jabatan");
              while ($jabatan = mysqli_fetch_array($jabatanQuery)) {
                  echo "<option value='" . $jabatan['nama_jabatan'] . "'>";
              }
              ?>
            </datalist>
          </div>
          <div class="form-group">
            <label for="departemen">Departemen</label>
            <input id="departemen" name="departemen" type="text" class="form-control" placeholder="Masukkan Departemen" list="departemenList" required>
            <datalist id="departemenList">
              <?php
              // Ambil data departemen dari database
              $departemenQuery = mysqli_query($koneksi, "SELECT * FROM tb_departemen");
              while ($departemen = mysqli_fetch_array($departemenQuery)) {
                  echo "<option value='" . $departemen['nama_departemen'] . "'>";
              }
              ?>
            </datalist>
          </div>
          <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
              <option value="Aktif">Aktif</option>
              <option value="Tidak Aktif">Tidak Aktif</option>
            </select>
          </div>
          <div class="form-group">
            <label for="start_kerja">Waktu Masuk</label>
            <input id="start_kerja" name="start_kerja" type="time" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="end_kerja">Waktu Pulang</label>
            <input id="end_kerja" name="end_kerja" type="time" class="form-control" required>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn btn-success">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal edit -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Pegawai</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editEmployeeForm" method="POST" action="data/edit/submit_edit_pegawai.php">
          <div class="form-group">
            <label for="editUID">No Kartu</label>
            <input type="text" name="no_kartu" id="editUID" class="form-control" placeholder="Scan your Card / Key Chain to display ID" required readonly>
          </div>
          <div class="form-group">
            <label for="editName">Nama</label>
            <input id="editName" name="nama" type="text" class="form-control" placeholder="Masukkan Nama" required>
          </div>
          <div class="form-group">
            <label for="editNIK">NIK</label>
            <input id="editNIK" name="nik" type="text" class="form-control" placeholder="Masukkan NIK" required>
          </div>
          <div class="form-group">
            <label for="editGender">Jenis Kelamin</label>
            <select name="gender" id="editGender" class="form-control" required>
              <option value="Male">Laki-laki</option>
              <option value="Female">Perempuan</option>
            </select>
          </div>
          <div class="form-group">
            <label for="editEmail">Email Address</label>
            <input name="email" id="editEmail" type="email" class="form-control" placeholder="Masukkan Email" required>
          </div>
          <div class="form-group">
            <label for="editMobile">Nomor Telepon</label>
            <input name="mobile" id="editMobile" type="text" class="form-control" placeholder="Masukkan Nomor Telepon" required>
          </div>
          <div class="form-group">
            <label for="editJabatan">Jabatan</label>
            <input id="editJabatan" name="jabatan" type="text" class="form-control" placeholder="Masukkan Jabatan" list="editJabatanList" required>
            <datalist id="editJabatanList">
              <?php
              // Ambil data jabatan dari database
              $jabatanQuery = mysqli_query($koneksi, "SELECT * FROM tb_jabatan");
              while ($jabatan = mysqli_fetch_array($jabatanQuery)) {
                  echo "<option value='" . $jabatan['nama_jabatan'] . "'>";
              }
              ?>
            </datalist>
          </div>
          <div class="form-group">
            <label for="editDepartemen">Departemen</label>
            <input id="editDepartemen" name="departemen" type="text" class="form-control" placeholder="Masukkan Departemen" list="editDepartemenList" required>
            <datalist id="editDepartemenList">
              <?php
              // Ambil data departemen dari database
              $departemenQuery = mysqli_query($koneksi, "SELECT * FROM tb_departemen");
              while ($departemen = mysqli_fetch_array($departemenQuery)) {
                  echo "<option value='" . $departemen['nama_departemen'] . "'>";
              }
              ?>
            </datalist>
          </div>
          <div class="form-group">
            <label for="editStatus">Status</label>
            <select name="status" id="editStatus" class="form-control" required>
              <option value="Aktif">Aktif</option>
              <option value="Tidak Aktif">Tidak Aktif</option>
            </select>
          </div>
          <div class="form-group">
            <label for="editStartKerja">Waktu Masuk</label>
            <input id="editStartKerja" name="start_kerja" type="time" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="editEndKerja">Waktu Pulang</label>
            <input id="editEndKerja" name="end_kerja" type="time" class="form-control" required>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn btn-success">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>




