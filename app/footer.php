<footer class="main-footer">
    <strong>Copyright &copy; 2024 JoshuaDjuk </strong>
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>

 <!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- jQuery UI -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

<script>
        document.getElementById('darkModeToggle').addEventListener('click', function() {
          document.body.classList.toggle('dark-mode');
        });
</script>

<?php
	    $Write="<?php $" . "UIDresult=''; " . "echo $" . "UIDresult;" . " ?>";
	    file_put_contents('../UIDContainer.php',$Write);
?>

<script>
  $(document).ready(function(){
    // Load UID when the modal is opened
    $('#submitModal').on('show.bs.modal', function () {
      console.log("Attempting to load UID...");
      loadUID(); // Panggil fungsi untuk memuat UID saat modal dibuka

      // Set interval untuk memuat UID setiap 500 ms
      var uidInterval = setInterval(function() {
        loadUID();
      }, 500);

      // Hentikan interval ketika modal ditutup
      $('#submitModal').on('hidden.bs.modal', function () {
        clearInterval(uidInterval);
      });
    });

    function loadUID() {
      $.get("../UIDContainer.php", function(data) {
        console.log("Data received: ", data); // Log data yang diterima
        $('#getUID').val(data.trim()); // Set UID ke textarea, gunakan trim() untuk menghapus spasi
      }).fail(function(jqXHR, textStatus, errorThrown) {
        console.error("Error loading UID: ", textStatus, errorThrown); // Log error jika gagal
      });
    }
  });
</script>


<!-- Script Edit Pegawai -->
<script>
  // Fungsi untuk mengisi modal edit dengan data pegawai
  function fillEditModal(no_kartu) {
    // Lakukan AJAX untuk mendapatkan data pegawai berdasarkan no_kartu
    $.ajax({
      url: '../conf/get_pegawai.php', // Endpoint untuk mendapatkan data pegawai
      type: 'GET',
      data: { no_kartu: no_kartu },
      success: function(data) {
        // Isi form dengan data pegawai
        const pegawai = JSON.parse(data);
        $('#editUID').val(pegawai.no_kartu);
        $('#editName').val(pegawai.nama);
        $('#editNIK').val(pegawai.nik);
        $('#editGender').val(pegawai.gender);
        $('#editEmail').val(pegawai.email);
        $('#editMobile').val(pegawai.mobile);
        $('#editJabatan').val(pegawai.jabatan);
        $('#editDepartemen').val(pegawai.departemen);
        $('#editStatus').val(pegawai.status);
        $('#editStartKerja').val(pegawai.start_kerja);
        $('#editEndKerja').val(pegawai.end_kerja);
        
        // Tampilkan modal
        $('#editModal').modal('show');
      },
      error: function() {
        alert('Error fetching data.');
      }
    });
  }
</script>