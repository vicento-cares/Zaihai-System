<div class="modal fade bd-example-modal-xl" id="new_terminal" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-black">
        <h5 class="modal-title" id="exampleModalLabel">
          <b>New Terminal</b>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="new_terminal_form">
        <div class="modal-body">
          <div class="row mb-2">
            <div class="col-12">
              <label>Terminal</label><label style="color: red;">*</label>
              <input type="text" id="terminal_name_master" class="form-control" maxlength="100" autocomplete="off" required>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label>Full Name</label><label style="color: red;">*</label>
              <input type="text" id="line_address_master" class="form-control" maxlength="100" autocomplete="off" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" id="btnAddTerminal" name="btn_add_terminal" class="btn btn-success">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>