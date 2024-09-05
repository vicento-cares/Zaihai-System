<div class="modal fade bd-example-modal-xl" id="update_terminal" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-black">
        <h5 class="modal-title" id="exampleModalLabel">
          <b>Update Terminal Details</b>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="update_terminal_form">
        <div class="modal-body">
          <div class="row mb-2">
            <input type="hidden" id="id_terminal_master_update" class="form-control">
            <div class="col-12">
              <label>Car Maker</label><label style="color: red;">*</label>
              <input type="text" id="term_car_maker_master_update" class="form-control" maxlength="255" autocomplete="off" required>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label>Car Model</label><label style="color: red;">*</label>
              <input type="text" id="term_car_model_master_update" class="form-control" maxlength="255" autocomplete="off" required>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label>Terminal Name</label><label style="color: red;">*</label>
              <select id="term_terminal_name_master_update" class="form-control" required></select>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label>Line Address</label><label style="color: red;">*</label>
              <input type="text" id="term_line_address_master_update" class="form-control" maxlength="100" autocomplete="off" required>
            </div>
          </div>
          <br>
          <hr>
          <div class="row">
            <div class="col-8">
              <div class="float-left">
                <button type="submit" id="btnDeleteTerminal" name="btn_delete_terminal"
                  class="btn btn-danger">Delete</button>
              </div>
            </div>
            <div class="col-4">
              <div class="float-right">
                <button type="submit" id="btnUpdateTerminal" name="btn_update_terminal"
                  class="btn btn-success">Update</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>