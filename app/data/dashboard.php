<?php
$result = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tb_pegawai");
$row = mysqli_fetch_assoc($result);
$totalPegawai = $row['total']; // Ambil total pegawai dari hasil query
?>

<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
            <div class="inner">
                <h3><?php echo $totalPegawai; ?></h3>
                <p>Jumlah Pegawai</p>
            </div>
              <div class="icon">
                <i class="fa fa-user"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
        <div class="col-lg-6">
        </div>
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
</section>
