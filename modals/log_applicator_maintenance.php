<div class="modal fade bd-example-modal-xl" id="log_applicator_maintenance" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-black">
        <h5 class="modal-title" id="exampleModalLabel">
          <b>Log Applicator Maintenance</b>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="log_applicator_maintenance_form">
        <input type="hidden" id="asmc_id">
        <input type="hidden" id="asmc_applicator_no">
        <div class="modal-body">
          <div class="row mb-2">
            <div class="col-12">
              <label class="mr-2">Applicator No:</label>
              <span id="asmc_applicator_no_label"></span>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label class="mr-2">Shot Limit Status EE (Wire Crimper):</label>
              <span id="asmc_shotcnt_u_ee_status_label"></span>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label class="mr-2">Shot Limit Status EE (Wire Anvil):</label>
              <span id="asmc_shotcnt_d_ee_status_label"></span>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label class="mr-2">Shot Limit Status EE (Insulation Crimper):</label>
              <span id="asmc_shotcnt_i_u_ee_status_label"></span>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label class="mr-2">Shot Limit Status EE (Insulation Anvil):</label>
              <span id="asmc_shotcnt_i_d_ee_status_label"></span>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label class="mr-2">Shot Limit Status EE (Slide Cutter):</label>
              <span id="asmc_shotcnt_c_ee_status_label"></span>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label>Maintenance By</label><label style="color: red;">*</label>
              <input type="text" id="asmc_maitenance_by" class="form-control" maxlength="100" autocomplete="off" required>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label>Maintenance Date</label><label style="color: red;">*</label>
              <input type="date" id="asmc_maitenance_date" class="form-control" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" id="btnLogApplicatorMaintenance" name="btn_log_applicator_maintenance" class="btn btn-success">Save Log</button>
        </div>
      </form>
    </div>
  </div>
</div>