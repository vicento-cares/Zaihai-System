<?php include 'plugins/navbar.php';?>
<?php include 'plugins/sidebar/shop_bar.php';?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Applicator Shots</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="applicator_shots.php">Applicator Shots</a></li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <div class="card card-gray-dark card-outline">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-list"></i> Applicator Shots Table</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                  <i class="fas fa-expand"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row mb-4">
                <input type="hidden" id="as_car_maker_search" value="<?= isset($_SESSION['car_maker']) ? htmlspecialchars($_SESSION['car_maker']) : ''; ?>">
                <input type="hidden" id="as_car_model_search" value="<?= isset($_SESSION['car_model']) ? htmlspecialchars($_SESSION['car_model']) : ''; ?>">
                <div class="col-sm-2">
                  <label>Status</label>
                  <select id="as_status_search" class="form-control" onchange="get_recent_applicator_shots()">
                    <option selected value="">All</option>
                    <option value="Ready To Use">Ready To Use</option>
                    <option value="Out">Out</option>
                    <option value="Pending">Pending</option>
                  </select>
                </div>
                <div class="col-sm-2">
                    <label>Shot Limit Status</label>
                    <select id="as_shot_limit_status_search" class="form-control" onchange="get_recent_applicator_shots()">
                        <option selected value="">All</option>
                        <option value="Good">All Good</option>
                        <option value="Good-EE">All EE Good</option>
                        <option value="Exceeded">All Exceeded</option>
                        <option value="Exceeded-EE">All EE 100k Exceeded</option>
                    </select>
                </div>
                <div class="col-sm-4">
                  <label>Applicator No.</label>
                  <input list="as_applicator_no_search_list" class="form-control" id="as_applicator_no_search">
                  <datalist id="as_applicator_no_search_list"></datalist>
                </div>
                <div class="col-sm-4">
                  <label>Location</label>
                  <input list="as_location_search_list" class="form-control" id="as_location_search">
                  <datalist id="as_location_search_list"></datalist>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-sm-2 offset-sm-8">
                  <button type="button" class="btn btn-secondary btn-block" onclick="export_recent_applicator_shots('recentApplicatorShotsTable')"><i class="fas fa-download"></i> Export</button>
                </div>
                <div class="col-sm-2">
                  <button type="button" class="btn btn-success btn-block" onclick="get_recent_applicator_shots()"><i class="fas fa-search"></i> Search</button>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-sm-2">
                  <span id="count_view"></span>
                </div>
              </div>
              <div class="table-responsive" style="max-height: 500px; overflow: auto; display:inline-block;">
                <table id="recentApplicatorShotsTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                  <thead style="text-align: center;">
                    <tr>
                      <th>#</th>
                      <th>Car Maker</th>
                      <th>Car Model</th>
                      <th>Applicator No.</th>
                      <th>Location</th>
                      <th>Status</th>
                      <th>Elapsed Time</th>
                      <th>Shot Count (Wire Crimper)</th>
                      <th>Shot Limit EE (Wire Crimper)</th>
                      <th>Shot Limit QA (Wire Crimper)</th>
                      <th>Shot Limit Status EE (Wire Crimper)</th>
                      <th>Shot Limit Status QA (Wire Crimper)</th>
                      <th>Shot Count (Wire Anvil)</th>
                      <th>Shot Limit EE (Wire Anvil)</th>
                      <th>Shot Limit QA (Wire Anvil)</th>
                      <th>Shot Limit Status EE (Wire Anvil)</th>
                      <th>Shot Limit Status QA (Wire Anvil)</th>
                      <th>Shot Count (Insulation Crimper)</th>
                      <th>Shot Limit EE (Insulation Crimper)</th>
                      <th>Shot Limit QA (Insulation Crimper)</th>
                      <th>Shot Limit Status EE (Insulation Crimper)</th>
                      <th>Shot Limit Status QA (Insulation Crimper)</th>
                      <th>Shot Count (Insulation Anvil)</th>
                      <th>Shot Limit EE (Insulation Anvil)</th>
                      <th>Shot Limit QA (Insulation Anvil)</th>
                      <th>Shot Limit Status EE (Insulation Anvil)</th>
                      <th>Shot Limit Status QA (Insulation Anvil)</th>
                      <th>Shot Count (Slide Cutter)</th>
                      <th>Shot Limit EE (Slide Cutterr)</th>
                      <th>Shot Limit QA (Slide Cutter)</th>
                      <th>Shot Limit Status EE (Slide Cutter)</th>
                      <th>Shot Limit Status QA (Slide Cutter)</th>
                    </tr>
                  </thead>
                  <tbody id="recentApplicatorShotsData" style="text-align: center;">
                    <tr>
                      <td colspan="32" style="text-align:center;">
                        <div class="spinner-border text-dark" role="status">
                          <span class="sr-only">Loading...</span>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
  </section>
</div>

<?php include 'plugins/footer.php';?>
<?php include 'plugins/js/applicator_shots_script.php';?>