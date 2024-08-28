<div class="modal fade bd-example-modal-xl" id="new_applicator_list" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-black">
        <h5 class="modal-title" id="exampleModalLabel">
          <b>New Applicator List</b>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="new_applicator_list_form">
        <div class="modal-body">
          <div class="row mb-2">
            <div class="col-12">
              <label>Car Maker</label><label style="color: red;">*</label>
              <input type="text" id="al_car_maker_master" class="form-control" maxlength="255" autocomplete="off" required>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label>Car Model</label><label style="color: red;">*</label>
              <input type="text" id="al_car_model_master" class="form-control" maxlength="255" autocomplete="off" required>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label>Applicator No.</label><label style="color: red;">*</label>
              <select id="al_applicator_no_master" class="form-control" onchange="get_zaihai_stock_address_dropdown(1)" required></select>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label>Location</label><label style="color: red;">*</label>
              <select id="al_location_master" class="form-control" required></select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" id="btnAddApplicatorList" name="btn_add_applicator_list" class="btn btn-success">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>