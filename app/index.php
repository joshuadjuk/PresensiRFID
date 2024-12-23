<?php 
session_start();
if(!$_SESSION['nama']){
  header('Location:../index.php?session=expired');
}
include('header.php');
include('../conf/config.php');
?>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <?php include('preloader.php');?>

  <!-- Navbar -->
  <?php include('navbar.php');?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <?php include('logo.php');?>

    <!-- Sidebar -->
    <?php include('sidebar.php');?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php include('content_header.php');?>
    <!-- /.content-header -->

    <!-- Main content -->
    <?php
    if (isset($_GET['page'])){
      if ($_GET['page']=='dashboard'){
        include('data/dashboard.php');
      }
      else if ($_GET['page']=='data-pegawai'){
        include('data/data_pegawai.php');
      }
      else if ($_GET['page']=='data-absensi'){
        include('data/data_absensi.php');
      }
      else if ($_GET['page']=='data-departemen'){
        include('data/data_departemen.php');
      }
      else if ($_GET['page']=='data-jabatan'){
        include('data/data_jabatan.php');
      }
    }
    else{
      include('data/dashboard.php');
    }?>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include('footer.php');?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->



</body>
</html>