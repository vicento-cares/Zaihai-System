<!-- Data Info Modal -->
<div class="modal fade" id="applicator_checksheet" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-dark">
        <h4 class="modal-title">MEI-295 (AC) Applicator Checksheet</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="applicator_checksheet_form">
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-5">
              <div class="form-group">
                <label>Serial No. : </label>
                <span id="serial_no_ac_i" class="ml-2"></span>
              </div>
            </div>
            <div class="col-sm-7">
              <div class="form-group">
                <label>Equipment No. (F. No.) : </label>
                <span id="equipment_no_ac_i" class="ml-2"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-5">
              <div class="form-group">
                <label>Machine No. (Appli. No.) : </label>
                <span id="machine_no_split_ac_i" class="ml-2"></span>
                <input type="hidden" id="machine_no_ac_i" name="machine_no_ac_i" value="">
              </div>
            </div>
            <div class="col-sm-7">
              <div class="form-group">
                <label>Zaihai Location (Applicator) : </label>
                <select id="ai_location" class="form-control" required></select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-5">
              <div class="form-group">
                <label>Terminal Name : </label>
                <span id="terminal_name_ac_i" class="ml-2"></span>
              </div>
            </div>
            <div class="col-sm-7">
              <div class="form-group">
                <label>Terminal Line Address : </label>
                <select id="line_address_ac_i" class="form-control" required></select>
              </div>
            </div>
          </div>
          <div class="row">
            <input type="hidden" id="inspection_date_time_ac_i" name="inspection_date_time_ac_i" value="">
            <div class="col-sm-5">
              <div class="form-group">
                <label>Inspection Date : </label>
                <span id="inspection_date_ac_i" class="ml-2"></span>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label>Inspection Time : </label>
                <span id="inspection_time_ac_i" class="ml-2"></span>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label>Inspection Shift : </label>
                <span id="inspection_shift_ac_i" class="ml-2"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-4 col-sm-12">
              <div class="form-group">
                <label id="legend_ac_l">Describing Symbols</label>
              </div>
            </div>
            <div class="col-lg-2 col-sm-12">
              <div class="form-group">
                <label class="h4" for="legend_ok_ac_l">◯</label>
                <span>Normal / OK</span>
              </div>
            </div>
            <div class="col-lg-2 col-sm-12">
              <div class="form-group">
                <label class="h4" for="legend_adj_ac_l">△</label>
                <span>Adjust, Clean</span>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group">
                <label class="h4" for="legend_ng_ac_l">X</label>
                <span>NG</span>
              </div>
            </div>
            <div class="col-lg-3 col-sm-12">
              <div class="form-group">
                <label class="h5" for="legend_na_ac_l">N/A</label>
                <span>Not applicable</span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-8 col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_1_ac_l">1. Check the Appearance / Condition of Sample</p>
                <p id="cont_1_ac_l2">Good Condition:
                Not Bend, rolling or twisted. Cutting tab and Cutting burr is not sharpHave in front and rear side. No sign of scratch and deformation</p>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_1_ok_ac_i" name="cont_1_ac_i" value="1" required>
                <label class="h4" for="cont_1_ok_ac_i">◯</label>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_1_adj_ac_i" name="cont_1_ac_i" value="2">
                <label class="h4" for="cont_1_adj_ac_i">△</label>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_1_ng_ac_i" name="cont_1_ac_i" value="3">
                <label class="h4" for="cont_1_ng_ac_i">X</label>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_1_na_ac_i" name="cont_1_ac_i" value="4">
                <label class="h5" for="cont_1_na_ac_i">N/A</label>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-4 col-sm-12">
              <select class="form-control" id="cont_1s_ac_i" style="width: 100%;" disabled>
                <option selected value="">Select Option For 1 △</option>
                <option value="Repair/Adjust">Repair/Adjust</option>
                <option value="Clean">Clean</option>
              </select>
            </div>
            <div class="col-lg-8 col-sm-12">
              <input type="text" class="form-control" id="cont_1r_ac_i" placeholder="Repair/Adjust/Clean/Replace Details 1" autocomplete="off" maxlength="255" disabled>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-8 col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_2_ac_l">2. Check the Condition of Spacer and Cable</p>
                <p id="cont_2_ac_l2">Good Condition:
                Spacer is not missing , Cable is not broken</p>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_2_ok_ac_i" name="cont_2_ac_i" value="1" required>
                <label class="h4" for="cont_2_ok_ac_i">◯</label>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_2_adj_ac_i" name="cont_2_ac_i" value="2">
                <label class="h4" for="cont_2_adj_ac_i">△</label>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_2_ng_ac_i" name="cont_2_ac_i" value="3">
                <label class="h4" for="cont_2_ng_ac_i">X</label>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_2_na_ac_i" name="cont_2_ac_i" value="4">
                <label class="h5" for="cont_2_na_ac_i">N/A</label>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-4 col-sm-12">
              <select class="form-control" id="cont_2s_ac_i" style="width: 100%;" disabled>
                <option selected value="">Select Option For 2 △</option>
                <option value="Repair/Adjust">Repair/Adjust</option>
                <option value="Clean">Clean</option>
              </select>
            </div>
            <div class="col-lg-8 col-sm-12">
              <input type="text" class="form-control" id="cont_2r_ac_i" placeholder="Repair/Adjust/Clean/Replace Details 2" autocomplete="off" maxlength="255" disabled>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-8 col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_3_ac_l">3. Check the Crimp and Insulation height dial</p>
                <p id="cont_3_ac_l2">Good Condition:
                Dial is can lock every number. Dial can pull and rotate</p>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_3_ok_ac_i" name="cont_3_ac_i" value="1" required>
                <label class="h4" for="cont_3_ok_ac_i">◯</label>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_3_adj_ac_i" name="cont_3_ac_i" value="2">
                <label class="h4" for="cont_3_adj_ac_i">△</label>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_3_ng_ac_i" name="cont_3_ac_i" value="3">
                <label class="h4" for="cont_3_ng_ac_i">X</label>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_3_na_ac_i" name="cont_3_ac_i" value="4">
                <label class="h5" for="cont_3_na_ac_i">N/A</label>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-4 col-sm-12">
              <select class="form-control" id="cont_3s_ac_i" style="width: 100%;" disabled>
                <option selected value="">Select Option For 3 △</option>
                <option value="Repair/Adjust">Repair/Adjust</option>
                <option value="Clean">Clean</option>
              </select>
            </div>
            <div class="col-lg-8 col-sm-12">
              <input type="text" class="form-control" id="cont_3r_ac_i" placeholder="Repair/Adjust/Clean/Replace Details 3" autocomplete="off" maxlength="255" disabled>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-8 col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_4_ac_l">4. Check the Condition of Wire holder, Insulation Crimper and hold down</p>
                <p id="cont_4_ac_l2">Good Condition:
                Parts are can move by hand up and down</p>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_4_ok_ac_i" name="cont_4_ac_i" value="1" required>
                <label class="h4" for="cont_4_ok_ac_i">◯</label>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_4_adj_ac_i" name="cont_4_ac_i" value="2">
                <label class="h4" for="cont_4_adj_ac_i">△</label>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_4_ng_ac_i" name="cont_4_ac_i" value="3">
                <label class="h4" for="cont_4_ng_ac_i">X</label>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_4_na_ac_i" name="cont_4_ac_i" value="4">
                <label class="h5" for="cont_4_na_ac_i">N/A</label>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-4 col-sm-12">
              <select class="form-control" id="cont_4s_ac_i" style="width: 100%;" disabled>
                <option selected value="">Select Option For 4 △</option>
                <option value="Repair/Adjust">Repair/Adjust</option>
                <option value="Clean">Clean</option>
              </select>
            </div>
            <div class="col-lg-8 col-sm-12">
              <input type="text" class="form-control" id="cont_4r_ac_i" placeholder="Repair/Adjust/Clean/Replace Details 4" autocomplete="off" maxlength="255" disabled>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-8 col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_5_ac_l">5. Check the condition of Stripper B (Auto/Manual) (STD Gap: 0.50mm)</p>
                <p id="cont_5_ac_l2">Good Condition:
                Not Broken or Mis-align. Not hit by Wire Crimper</p>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_5_ok_ac_i" name="cont_5_ac_i" value="1" required>
                <label class="h4" for="cont_5_ok_ac_i">◯</label>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_5_adj_ac_i" name="cont_5_ac_i" value="2">
                <label class="h4" for="cont_5_adj_ac_i">△</label>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_5_ng_ac_i" name="cont_5_ac_i" value="3">
                <label class="h4" for="cont_5_ng_ac_i">X</label>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_5_na_ac_i" name="cont_5_ac_i" value="4">
                <label class="h5" for="cont_5_na_ac_i">N/A</label>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-4 col-sm-12">
              <select class="form-control" id="cont_5s_ac_i" style="width: 100%;" disabled>
                <option selected value="">Select Option For 5 △</option>
                <option value="Repair/Adjust">Repair/Adjust</option>
                <option value="Clean">Clean</option>
              </select>
            </div>
            <div class="col-lg-8 col-sm-12">
              <input type="text" class="form-control" id="cont_5r_ac_i" placeholder="Repair/Adjust/Clean/Replace Details 5" autocomplete="off" maxlength="255" disabled>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-8 col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_6_ac_l">6. Check the catter dust guide and catter dust shute</p>
                <p id="cont_6_ac_l2">Good Condition:
                Not loose, mis-align, deform and broken</p>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_6_ok_ac_i" name="cont_6_ac_i" value="1" required>
                <label class="h4" for="cont_6_ok_ac_i">◯</label>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_6_adj_ac_i" name="cont_6_ac_i" value="2">
                <label class="h4" for="cont_6_adj_ac_i">△</label>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_6_ng_ac_i" name="cont_6_ac_i" value="3">
                <label class="h4" for="cont_6_ng_ac_i">X</label>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_6_na_ac_i" name="cont_6_ac_i" value="4">
                <label class="h5" for="cont_6_na_ac_i">N/A</label>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-4 col-sm-12">
              <select class="form-control" id="cont_6s_ac_i" style="width: 100%;" disabled>
                <option selected value="">Select Option For 6 △</option>
                <option value="Repair/Adjust">Repair/Adjust</option>
                <option value="Clean">Clean</option>
              </select>
            </div>
            <div class="col-lg-8 col-sm-12">
              <input type="text" class="form-control" id="cont_6r_ac_i" placeholder="Repair/Adjust/Clean/Replace Details 6" autocomplete="off" maxlength="255" disabled>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-8 col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_7_ac_l">7. Check the condition of slide cutter, spring</p>
                <p id="cont_7_ac_l2">Good Condition:
                Can move by hand up and down. Spring is not missing/broken</p>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_7_ok_ac_i" name="cont_7_ac_i" value="1" required>
                <label class="h4" for="cont_7_ok_ac_i">◯</label>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_7_adj_ac_i" name="cont_7_ac_i" value="2">
                <label class="h4" for="cont_7_adj_ac_i">△</label>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_7_ng_ac_i" name="cont_7_ac_i" value="3">
                <label class="h4" for="cont_7_ng_ac_i">X</label>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_7_na_ac_i" name="cont_7_ac_i" value="4">
                <label class="h5" for="cont_7_na_ac_i">N/A</label>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-4 col-sm-12">
              <select class="form-control" id="cont_7s_ac_i" style="width: 100%;" disabled>
                <option selected value="">Select Option For 7 △</option>
                <option value="Repair/Adjust">Repair/Adjust</option>
                <option value="Clean">Clean</option>
              </select>
            </div>
            <div class="col-lg-8 col-sm-12">
              <input type="text" class="form-control" id="cont_7r_ac_i" placeholder="Repair/Adjust/Clean/Replace Details 7" autocomplete="off" maxlength="255" disabled>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-8 col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_8_ac_l">8. Check the Guide B</p>
                <p id="cont_8_ac_l2">Good Condition:
                Not loose and damage</p>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_8_ok_ac_i" name="cont_8_ac_i" value="1" required>
                <label class="h4" for="cont_8_ok_ac_i">◯</label>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_8_adj_ac_i" name="cont_8_ac_i" value="2">
                <label class="h4" for="cont_8_adj_ac_i">△</label>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_8_ng_ac_i" name="cont_8_ac_i" value="3">
                <label class="h4" for="cont_8_ng_ac_i">X</label>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_8_na_ac_i" name="cont_8_ac_i" value="4">
                <label class="h5" for="cont_8_na_ac_i">N/A</label>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-4 col-sm-12">
              <select class="form-control" id="cont_8s_ac_i" style="width: 100%;" disabled>
                <option selected value="">Select Option For 8 △</option>
                <option value="Repair/Adjust">Repair/Adjust</option>
                <option value="Clean">Clean</option>
              </select>
            </div>
            <div class="col-lg-8 col-sm-12">
              <input type="text" class="form-control" id="cont_8r_ac_i" placeholder="Repair/Adjust/Clean/Replace Details 8" autocomplete="off" maxlength="255" disabled>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-8 col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_9_ac_l">9. Check the Condition of Feed Finger</p>
                <p id="cont_9_ac_l2">Good Condition:
                Tip is not broken and sharp. Can move by hand up and down. Claw spring attach to feed finger</p>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_9_ok_ac_i" name="cont_9_ac_i" value="1" required>
                <label class="h4" for="cont_9_ok_ac_i">◯</label>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_9_adj_ac_i" name="cont_9_ac_i" value="2">
                <label class="h4" for="cont_9_adj_ac_i">△</label>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_9_ng_ac_i" name="cont_9_ac_i" value="3">
                <label class="h4" for="cont_9_ng_ac_i">X</label>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_9_na_ac_i" name="cont_9_ac_i" value="4">
                <label class="h5" for="cont_9_na_ac_i">N/A</label>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-4 col-sm-12">
              <select class="form-control" id="cont_9s_ac_i" style="width: 100%;" disabled>
                <option selected value="">Select Option For 9 △</option>
                <option value="Repair/Adjust">Repair/Adjust</option>
                <option value="Clean">Clean</option>
              </select>
            </div>
            <div class="col-lg-8 col-sm-12">
              <input type="text" class="form-control" id="cont_9r_ac_i" placeholder="Repair/Adjust/Clean/Replace Details 9" autocomplete="off" maxlength="255" disabled>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-8 col-sm-12">
              <div class="form-group mb-0">
                <p id="cont_10_ac_l">10. Check the Condition of Feed Cam and Cam pin</p>
                <p id="cont_10_ac_l2">Good Condition:
                No rust / Have Grease</p>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_10_ok_ac_i" name="cont_10_ac_i" value="1" required>
                <label class="h4" for="cont_10_ok_ac_i">◯</label>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_10_adj_ac_i" name="cont_10_ac_i" value="2">
                <label class="h4" for="cont_10_adj_ac_i">△</label>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_10_ng_ac_i" name="cont_10_ac_i" value="3">
                <label class="h4" for="cont_10_ng_ac_i">X</label>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cont_10_na_ac_i" name="cont_10_ac_i" value="4">
                <label class="h5" for="cont_10_na_ac_i">N/A</label>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-4 col-sm-12">
              <select class="form-control" id="cont_10s_ac_i" style="width: 100%;" disabled>
                <option selected value="">Select Option For 10 △</option>
                <option value="Repair/Adjust">Repair/Adjust</option>
                <option value="Clean">Clean</option>
              </select>
            </div>
            <div class="col-lg-8 col-sm-12">
              <input type="text" class="form-control" id="cont_10r_ac_i" placeholder="Repair/Adjust/Clean/Replace Details 10" autocomplete="off" maxlength="255" disabled>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Content of Adjustment / Repair : </label>
                <textarea id="adjustment_content_ac_i" name="adjustment_content_ac_i" class="form-control" style="resize: none;" rows="3" maxlength="255" onkeyup="count_adjustment_content_char()"></textarea>
                <span id="adjustment_content_ac_i_count"></span>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-lg-8 col-sm-12">
              <div class="form-group mb-0">
                <b id="cross_section_result_ac_l">Result of Cross section: <br>(Applicable for replacement of crimper and anvil)</b>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cross_section_result_ok_ac_i" name="cross_section_result_ac_i" value="1">
                <label class="h4" for="cross_section_result_ok_ac_i">◯</label>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cross_section_result_adj_ac_i" name="cross_section_result_ac_i" value="2">
                <label class="h4" for="cross_section_result_adj_ac_i">△</label>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cross_section_result_ng_ac_i" name="cross_section_result_ac_i" value="3">
                <label class="h4" for="cross_section_result_ng_ac_i">X</label>
              </div>
            </div>
            <div class="col-lg-1 col-sm-12">
              <div class="form-group mb-0">
                <input type="radio" id="cross_section_result_na_ac_i" name="cross_section_result_ac_i" value="4">
                <label class="h5" for="cross_section_result_na_ac_i">N/A</label>
              </div>
            </div>
          </div>
          <div class="row">
            <input type="hidden" id="inspected_by_no_ac_i" name="inspected_by_no_ac_i" value="">
            <div class="col-sm-12">
              <div class="form-group mt-1 mb-0">
                <label>Inspected By : </label>
                <span id="inspected_by_ac_i" class="ml-2"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer bg-light">
          <button type="submit" id="btnMakeAc" name="btn_make_ac" class="btn btn-success">Make Checksheet</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->