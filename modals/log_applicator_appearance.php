<div class="modal fade bd-example-modal-xl" id="log_applicator_appearance" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-black">
        <h5 class="modal-title" id="exampleModalLabel">
          <b>Log Applicator Appearance Inspection</b>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="log_applicator_appearance_form">
        <input type="hidden" id="asqa_applicator_no">
        <div class="modal-body">
          <div class="row mb-2">
            <div class="col-12">
              <label class="mr-2">Applicator No:</label>
              <span id="asqa_applicator_no_label"></span>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label class="mr-2">Shot Limit Status QA (Wire Crimper):</label>
              <span id="asqa_shotcnt_u_qa_status_label"></span>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label class="mr-2">Shot Limit Status QA (Wire Anvil):</label>
              <span id="asqa_shotcnt_d_qa_status_label"></span>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label class="mr-2">Shot Limit Status QA (Insulation Crimper):</label>
              <span id="asqa_shotcnt_i_u_qa_status_label"></span>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label class="mr-2">Shot Limit Status QA (Insulation Anvil):</label>
              <span id="asqa_shotcnt_i_d_qa_status_label"></span>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label class="mr-2">Shot Limit Status QA (Slide Cutter):</label>
              <span id="asqa_shotcnt_c_qa_status_label"></span>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label>Inspected By</label><label style="color: red;">*</label>
              <input type="text" id="asqa_inspected_by" class="form-control" maxlength="100" autocomplete="off" required>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label>Inspection Date</label><label style="color: red;">*</label>
              <input type="date" id="asqa_inspection_date" class="form-control" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" id="btnLogApplicatorAppearance" name="btn_log_applicator_appearance" class="btn btn-success">Save Log</button>
        </div>
      </form>
    </div>
  </div>
</div>