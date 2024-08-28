<div class="modal fade bd-example-modal-xl" id="update_applicator" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-black">
        <h5 class="modal-title" id="exampleModalLabel">
          <b>Update Applicator Details</b>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="update_applicator_form">
        <div class="modal-body">
          <div class="row mb-2">
            <input type="hidden" id="id_applicator_master_update" class="form-control">
            <div class="col-12">
              <label>Applicator</label><label style="color: red;">*</label>
              <input type="text" id="applicator_no_master_update" class="form-control" maxlength="100" autocomplete="off" required>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <label>Zaihai Stock Address</label><label style="color: red;">*</label>
              <input type="text" id="zaihai_stock_address_master_update" class="form-control" maxlength="100" autocomplete="off" required>
            </div>
          </div>
          <br>
          <hr>
          <div class="row">
            <div class="col-8">
              <div class="float-left">
                <button type="submit" id="btnDeleteApplicator" name="btn_delete_applicator"
                  class="btn btn-danger">Delete</button>
              </div>
            </div>
            <div class="col-4">
              <div class="float-right">
                <button type="submit" id="btnUpdateApplicator" name="btn_update_applicator"
                  class="btn btn-success">Update</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>