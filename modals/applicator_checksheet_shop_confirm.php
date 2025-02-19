<!-- Data Info Modal -->
<div class="modal fade" id="applicator_checksheet_shop_confirm" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-dark">
        <h4 class="modal-title">MEI-295 (AC) Confirm BM Applicator Checksheet</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="applicator_checksheet_shop_confirm_form">
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-5">
              <div class="form-group">
                <label>Serial No. : </label>
                <span id="serial_no_sc" class="ml-2"></span>
              </div>
            </div>
            <div class="col-sm-7">
              <div class="form-group">
                <label>Equipment No. (F. No.) : </label>
                <span id="equipment_no_sc" class="ml-2"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-5">
              <div class="form-group">
                <label>Machine No. (Appli. No.) : </label>
                <span id="machine_no_sc" class="ml-2"></span>
              </div>
            </div>
            <div class="col-sm-7">
              <div class="form-group">
                <label>Terminal Name : </label>
                <span id="terminal_name_sc" class="ml-2"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-5">
              <div class="form-group">
                <label>Inspection Date : </label>
                <span id="inspection_date_sc" class="ml-2"></span>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label>Inspection Time : </label>
                <span id="inspection_time_sc" class="ml-2"></span>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label>Inspection Shift : </label>
                <span id="inspection_shift_sc" class="ml-2"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-4 col-sm-12">
              <div class="form-group">
                <label id="legend_sc_l">Describing Symbols</label>
              </div>
            </div>
            <div class="col-lg-2 col-sm-12">
              <div class="form-group">
                <label class="h4" for="legend_ok_sc_l">◯</label>
                <span>Normal / OK</span>
              </div>
            </div>
            <div class="col-lg-2 col-sm-12">
              <div class="form-group">
                <label class="h4" for="legend_adj_sc_l">△</label>
                <span>Adjust, Clean</span>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group">
                <label class="h4" for="legend_ng_sc_l">X</label>
                <span>NG</span>
              </div>
            </div>
            <div class="col-lg-3 col-sm-12">
              <div class="form-group">
                <label class="h5" for="legend_na_sc_l">N/A</label>
                <span>Not applicable</span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-9 col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_1_sc_l">1. Check the Appearance / Condition of Sample</p>
                <p id="cont_1_sc_l2">Good Condition:
                Not Bend, rolling or twisted. Cutting tab and Cutting burr is not sharp. Have in front and rear side. No sign of scratch and deformation</p>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <label class="h4" id="ac1_sc"></label>
              </div>
            </div>
            <div class="col-lg-2 col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_1s_sc"></p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_1r_sc">Replace Details: </p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-9 col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_2_sc_l">2. Check the Condition of Spacer and Cable</p>
                <p id="cont_2_sc_l2">Good Condition:
                Spacer is not missing , Cable is not broken</p>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <label class="h4" id="ac2_sc"></label>
              </div>
            </div>
            <div class="col-lg-2 col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_2s_sc"></p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_2r_sc">Replace Details: </p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-9 col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_3_sc_l">3. Check the Crimp and Insulation height dial</p>
                <p id="cont_3_sc_l2">Good Condition:
                Dial is can lock every number. Dial can pull and rotate</p>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <label class="h4" id="ac3_sc"></label>
              </div>
            </div>
            <div class="col-lg-2 col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_3s_sc"></p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_3r_sc">Replace Details: </p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-9 col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_4_sc_l">4. Check the Condition of Wire holder, Insulation Crimper and hold down</p>
                <p id="cont_4_sc_l2">Good Condition:
                Parts are can move by hand up and down</p>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <label class="h4" id="ac4_sc"></label>
              </div>
            </div>
            <div class="col-lg-2 col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_4s_sc"></p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_4r_sc">Replace Details: </p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-9 col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_5_sc_l">5. Check the condition of Stripper B (Auto/Manual) (STD Gap: 0.50mm)</p>
                <p id="cont_5_sc_l2">Good Condition:
                Not Broken or Mis-align. Not hit by Wire Crimper</p>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <label class="h4" id="ac5_sc"></label>
              </div>
            </div>
            <div class="col-lg-2 col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_5s_sc"></p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_5r_sc">Replace Details: </p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-9 col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_6_sc_l">6. Check the catter dust guide and catter dust shute</p>
                <p id="cont_6_sc_l2">Good Condition:
                Not loose, mis-align, deform and broken</p>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <label class="h4" id="ac6_sc"></label>
              </div>
            </div>
            <div class="col-lg-2 col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_6s_sc"></p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_6r_sc">Replace Details: </p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-9 col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_7_sc_l">7. Check the condition of slide cutter, spring</p>
                <p id="cont_7_sc_l2">Good Condition:
                Can move by hand up and down. Spring is not missing/broken</p>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <label class="h4" id="ac7_sc"></label>
              </div>
            </div>
            <div class="col-lg-2 col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_7s_sc"></p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_7r_sc">Replace Details: </p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-9 col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_8_sc_l">8. Check the Guide B</p>
                <p id="cont_8_sc_l2">Good Condition:
                Not loose and damage</p>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <label class="h4" id="ac8_sc"></label>
              </div>
            </div>
            <div class="col-lg-2 col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_8s_sc"></p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_8r_sc">Replace Details: </p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-9 col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_9_sc_l">9. Check the Condition of Feed Finger</p>
                <p id="cont_9_sc_l2">Good Condition:
                Tip is not broken and sharp. Can move by hand up and down. Claw spring attach to feed finger</p>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <label class="h4" id="ac9_sc"></label>
              </div>
            </div>
            <div class="col-lg-2 col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_9s_sc"></p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_9r_sc">Replace Details: </p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-9 col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_10_sc_l">10. Check the Condition of Feed Cam and Cam pin</p>
                <p id="cont_10_sc_l2">Good Condition:
                No rust / Have Grease</p>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <label class="h4" id="ac10_sc"></label>
              </div>
            </div>
            <div class="col-lg-2 col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_10s_sc"></p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_10r_sc">Replace Details: </p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-4 col-sm-12">
              <div class="form-group">
                <label>Content of Adjustment / Repair : </label>
                <p id="adjustment_content_sc"></p>
              </div>
            </div>
            <div class="col-lg-8 col-sm-12">
              <div class="form-group">
                <label>Content of Adjustment / Repair (Remarks): </label>
                <p id="adjustment_content_remarks_sc"></p>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-9 col-sm-12">
              <div class="form-group mb-0">
                <b id="cross_section_result_sc_l">Result of Cross section: <br>(Applicable for replacement of crimper and anvil)</b>
              </div>
            </div>
            <div class="col-lg-3 col-sm-12">
              <div class="form-group mb-0">
                <label class="h4" id="cross_section_result_sc"></label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group mt-1 mb-0">
                <label>Inspected By : </label>
                <span id="inspected_by_sc" class="ml-2"></span>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group mt-1 mb-0">
                <label>Checked By : </label>
                <span id="checked_by_sc" class="ml-2"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group mt-1 mb-0">
                <label>Confirmed By : </label>
                <span id="confirmed_by_no_sc" class="ml-2"></span>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-11 col-sm-12">
              <div class="form-group mb-0">
                <b id="judgement_sc_l">Judgement:</b>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <label class="h4" id="judgement_sc"></label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer bg-light">
          <button type="submit" id="btnShopConfirmAc" name="btn_shop_confirm_ac" class="btn btn-success btn-block">Confirm</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->