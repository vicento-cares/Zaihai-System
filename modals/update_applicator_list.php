<div class="modal fade bd-example-modal-xl" id="update_applicator_list" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-black">
        <h5 class="modal-title" id="exampleModalLabel">
          <b>Update Applicator List Details</b>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="update_applicator_list_form">
        <div class="modal-body">
          <div class="row mb-2">
            <input type="hidden" id="id_applicator_list_master_update" class="form-control">
            <div class="col-12">
              <label>Car Maker</label><label style="color: red;">*</label>
              <input type="text" id="al_car_maker_master_update" class="form-control" maxlength="255" autocomplete="off" required>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label>Car Model</label><label style="color: red;">*</label>
              <input type="text" id="al_car_model_master_update" class="form-control" maxlength="255" autocomplete="off" required>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label>Applicator No.</label><label style="color: red;">*</label>
              <select id="al_applicator_no_master_update" class="form-control" onchange="get_zaihai_stock_address_dropdown(2)" required></select>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <label>Location</label><label style="color: red;">*</label>
              <select id="al_location_master_update" class="form-control" required></select>
            </div>
          </div>
          <br>
          <hr>
          <div class="row">
            <div class="col-8">
              <div class="float-left">
                <button type="submit" id="btnDeleteApplicatorList" name="btn_delete_applicator_list"
                  class="btn btn-danger">Delete</button>
              </div>
            </div>
            <div class="col-4">
              <div class="float-right">
                <button type="submit" id="btnUpdateApplicatorList" name="btn_update_applicator_list"
                  class="btn btn-success">Update</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>