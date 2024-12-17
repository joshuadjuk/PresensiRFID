    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Departemen</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                <button class="btn btn-primary" data-toggle="modal" data-target="#submitModal">Submit New Departemen</button>
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Departemen</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 0;
                    $query = mysqli_query($koneksi,"SELECT * FROM tb_departemen");
                    while($com = mysqli_fetch_array($query)){
                      $no++
                    ?>
                  <tr>
                    <td width='5%'><?php echo $no?></td>
                    <td><?php echo $com['nama_departemen'];?></td>
                    <td>
                      <a href="data/delete/delete_departemen.php?id=<?php echo $com['id'];?>" class="btn btn-danger" onclick="return confirmDelete();">Delete</a>
                    </td>
                  </tr>
                  <?php }?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Nama Departemen</th>
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
        <h5 class="modal-title" id="submitModalLabel">Tambah Departemen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addEmployeeForm" method="POST" action="data/add/submit_departemen.php">
          <div class="form-group">
            <label for="nama_departemen">Nama Departemen</label>
            <input id="nama_departemen" name="nama_departemen" type="text" class="form-control" placeholder="Masukkan Nama Departemen" required>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn btn-success">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>




