<section class="content">
    <div class="container-fluid">
        <div class="row">
          <div class="col-lg-5">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Maintenance Schedule</h3>
              </div>
              <div class="card-body">
                <div id="calendar"></div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
</section>


<!-- Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Repair Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>No Asset:</strong> <span id="modalNoAsset"></span></p>
                <p><strong>No Health:</strong> <span id="modalNoHealth"></span></p>
                <p><strong>Brand:</strong> <span id="modalBrand"></span></p>
                <p><strong>Lokasi:</strong> <span id="modalLokasi"></span></p>
                <p><strong>Repair Schedule:</strong> <span id="modalRepairSchedule"></span></p>
                <p><strong>Keterangan:</strong> <span id="modalKeterangan"></span></p>
            </div>
        </div>
    </div>
</div>