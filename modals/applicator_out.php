<!-- Data Info Modal -->
<div class="modal fade" id="applicator_out" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-dark">
        <h4 class="modal-title">Applicator Out</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="applicator_out_form">
        <div class="modal-body">
          <div class="row mb-2">
            <div class="col-lg-6 col-sm-12">
              <div class="form-group mb-0">
                <h5 id="ao_opt_label">Choose Option</h5>
              </div>
            </div>
            <div class="col-lg-3 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="ao_opt_scan" name="ao_opt" value="1" onclick="toggle_opt_divs()" required
                  checked>
                <label class="h5" for="ao_opt_scan">Scan</label>
              </div>
            </div>
            <div class="col-lg-3 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="ao_opt_borrowed" name="ao_opt" value="2" onclick="toggle_opt_divs()">
                <label class="h5" for="ao_opt_borrowed">Borrowed</label>
              </div>
            </div>
          </div>
          <div class="row mb-2" id="ao_opt_scan_div">
            <div class="col-sm-12">
              <input type="text" class="form-control" id="ao_location" placeholder="Location" oncopy="return false"
                onpaste="return false" autocomplete="off" maxlength="255" ondrop="event.preventDefault();">
            </div>
          </div>
          <div class="row mb-2 d-none" id="ao_opt_borrowed_div">
            <div class="col-sm-8">
              <label>Borrowed By</label><label style="color: red;">*</label>
              <select id="ao_borrowed_by_location" class="form-control" required></select>
            </div>
            <div class="col-sm-4">
              <label>Remarks</label><label style="color: red;">*</label>
              <select id="ao_borrowed_by_remarks" class="form-control" required>
                <option disabled selected value="">Select Remarks</option>
                <option value="Recrimp">Recrimp</option>
                <option value="Pullout">Pullout</option>
              </select>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-12">
              <input type="text" class="form-control" id="ao_applicator_no" placeholder="Applicator No."
                oncopy="return false" onpaste="return false" autocomplete="off" maxlength="255"
                ondrop="event.preventDefault();" disabled>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-12">
              <input type="text" class="form-control" id="ao_terminal_name" placeholder="Terminal Name"
                oncopy="return false" onpaste="return false" autocomplete="off" maxlength="255"
                ondrop="event.preventDefault();" disabled>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-12">
              <span class="text-bold" id="out_applicator_result"></span>
            </div>
          </div>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->