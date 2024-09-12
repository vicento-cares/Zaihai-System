<div class="modal fade bd-example-modal-xl" id="update_account" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-black">
        <h5 class="modal-title" id="exampleModalLabel">
          <b>Update Account Details</b>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="update_account_form">
        <div class="modal-body">
          <div class="row mb-2">
            <input type="hidden" id="id_account_master_update" class="form-control">
            <div class="col-4">
              <label>Employee No.</label><label style="color: red;">*</label>
              <input type="text" id="emp_no_master_update" class="form-control" maxlength="255" autocomplete="off" required>
            </div>
            <div class="col-8">
              <label>Full Name</label><label style="color: red;">*</label>
              <input type="text" id="full_name_master_update" class="form-control" maxlength="255" autocomplete="off" required>
            </div>
          </div>
          <div class="row">
            <div class="col-4">
              <label>Role</label><label style="color: red;">*</label>
              <select class="form-control" id="role_master_update" name="role" required>
                <option disabled selected value="">Select Account Type</option>
                <option value="Shop">Shop</option>
                <option value="Inspector">Inspector</option>
                <option value="BM">BM</option>
                <option value="ME">ME</option>
              </select>
            </div>
          </div>
          <br>
          <hr>
          <div class="row">
            <div class="col-8">
              <div class="float-left">
                <button type="submit" id="btnDeleteAccount" name="btn_delete_account"
                  class="btn btn-danger">Delete</button>
              </div>
            </div>
            <div class="col-4">
              <div class="float-right">
                <button type="submit" id="btnUpdateAccount" name="btn_update_account"
                  class="btn btn-success">Update</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>