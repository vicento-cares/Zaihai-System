<div class="modal fade bd-example-modal-xl" id="new_applicator" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-black">
        <h5 class="modal-title" id="exampleModalLabel">
          <b>New Applicator</b>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="new_applicator_form">
        <div class="modal-body">
          <div class="row mb-2">
            <div class="col-12">
              <label>Car Maker</label><label style="color: red;">*</label>
              <select id="a_car_maker_master" class="form-control" required></select>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label>Car Model</label><label style="color: red;">*</label>
              <select id="a_car_model_master" class="form-control" required></select>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label>Applicator No.</label><label style="color: red;">*</label>
              <select id="a_applicator_no_master" class="form-control" required></select>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label>Zaihai Stock Address</label><label style="color: red;">*</label>
              <input type="text" id="a_zaihai_stock_address_master" class="form-control" maxlength="100" autocomplete="off" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" id="btnAddApplicator" name="btn_add_applicator" class="btn btn-success">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>