<div class="modal fade bd-example-modal-xl" id="new_account" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-black">
        <h5 class="modal-title" id="exampleModalLabel">
          <b>New Account</b>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="new_account_form">
        <div class="modal-body">
          <div class="row mb-2">
            <div class="col-4">
              <label>Employee No.</label><label style="color: red;">*</label>
              <input type="text" id="emp_no_master" class="form-control" maxlength="255" autocomplete="off" required>
            </div>
            <div class="col-8">
              <label>Full Name</label><label style="color: red;">*</label>
              <input type="text" id="full_name_master" class="form-control" maxlength="255" autocomplete="off" required>
            </div>
          </div>
          <div class="row">
            <div class="col-4">
              <label>Role</label><label style="color: red;">*</label>
              <select class="form-control" id="role_master" name="role" required>
                <option disabled selected value="">Select Account Type</option>
                <option value="Shop">Shop</option>
                <option value="Inspector">Inspector</option>
                <option value="BM">BM</option>
                <option value="ME">ME</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" id="btnAddAccount" name="btn_add_account" class="btn btn-success">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>