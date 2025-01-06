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
            <div class="col-sm-12">
              <input type="text" class="form-control" id="ao_location" placeholder="Location" oncopy="return false"
                onpaste="return false" autocomplete="off" maxlength="255">
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-12">
              <input type="text" class="form-control" id="ao_applicator_no" placeholder="Applicator No."
                oncopy="return false" onpaste="return false" autocomplete="off" maxlength="255" disabled>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-sm-12">
              <input type="text" class="form-control" id="ao_terminal_name" placeholder="Terminal Name"
                oncopy="return false" onpaste="return false" autocomplete="off" maxlength="255" disabled>
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