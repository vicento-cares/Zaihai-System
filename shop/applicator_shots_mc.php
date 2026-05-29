<?php include 'plugins/navbar.php';?>
<?php include 'plugins/sidebar/shop_bar.php';?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Applicator Maintenance Logging</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="applicator_shots_mc.php">Applicator Maintenance Logging</a></li>
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
              <h3 class="card-title"><i class="fas fa-cogs"></i> Applicator Shots Table based on Applicator Shots Limit Exceeded</h3>
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
                <input type="hidden" id="asmc_car_maker_search" value="<?= isset($_SESSION['car_maker']) ? htmlspecialchars($_SESSION['car_maker']) : ''; ?>">
                <input type="hidden" id="asmc_car_model_search" value="<?= isset($_SESSION['car_model']) ? htmlspecialchars($_SESSION['car_model']) : ''; ?>">
                <div class="col-sm-6">
                  <label>Applicator No.</label>
                  <input list="asmc_applicator_no_search_list" class="form-control" id="asmc_applicator_no_search">
                  <datalist id="asmc_applicator_no_search_list"></datalist>
                </div>
                <div class="col-sm-3">
                  <label>&nbsp;</label>
                  <button type="button" class="btn btn-secondary btn-block" onclick="export_recent_applicator_shots_mc('recentApplicatorShotsMcTable')"><i class="fas fa-download"></i> Export</button>
                </div>
                <div class="col-sm-3">
                  <label>&nbsp;</label>
                  <button type="button" class="btn btn-success btn-block" onclick="get_recent_applicator_shots_mc()"><i class="fas fa-search"></i> Search</button>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-sm-2">
                  <span id="count_view"></span>
                </div>
              </div>
              <div class="table-responsive" style="max-height: 500px; overflow: auto; display:inline-block;">
                <table id="recentApplicatorShotsMcTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                  <thead style="text-align: center;">
                    <tr>
                      <th>#</th>
                      <th>Applicator No.</th>
                      <th>Status</th>
                      <th>Detected By</th>
                      <th>Elapsed Time</th>
                      <th>Scan Date Detected</th>
                      <th>Shot Count (Wire Crimper)</th>
                      <th>Shot Limit EE (Wire Crimper)</th>
                      <th>Shot Limit Status EE (Wire Crimper)</th>
                      <th>Shot Count (Wire Anvil)</th>
                      <th>Shot Limit EE (Wire Anvil)</th>
                      <th>Shot Limit Status EE (Wire Anvil)</th>
                      <th>Shot Count (Insulation Crimper)</th>
                      <th>Shot Limit EE (Insulation Crimper)</th>
                      <th>Shot Limit Status EE (Insulation Crimper)</th>
                      <th>Shot Count (Insulation Anvil)</th>
                      <th>Shot Limit EE (Insulation Anvil)</th>
                      <th>Shot Limit Status EE (Insulation Anvil)</th>
                      <th>Shot Count (Slide Cutter)</th>
                      <th>Shot Limit EE (Slide Cutter)</th>
                      <th>Shot Limit Status EE (Slide Cutter)</th>
                    </tr>
                  </thead>
                  <tbody id="recentApplicatorShotsMcData" style="text-align: center;"></tbody>
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
<?php include 'plugins/js/applicator_shots_mc_script.php';?>